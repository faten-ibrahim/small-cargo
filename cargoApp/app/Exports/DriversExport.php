<?php

namespace App\Exports;

use App\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DriversExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = \Auth::user();
        $role = $user->roles->first()->name;
        if ($role === 'admin') {
            // $drivers = Driver::all();
            $drivers = DB::table('drivers')
                ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
                ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
                ->select(
                    'drivers.*',
                    DB::raw("count(driver_order.order_id) as count"),
                    'users.name as supervisor_name'
                )
                ->groupBy('drivers.id')
                ->orderBy('drivers.created_at','desc')
                ->get();

            return $drivers;
        } elseif ($role === 'supervisor') {
            $user = \Auth::user();
            $id = $user->id;
            $drivers = DB::table('drivers')
                ->leftJoin('driver_order', 'drivers.id', '=', 'driver_order.driver_id')
                ->select('drivers.*', DB::raw("count(driver_order.order_id) as count"))
                ->groupBy('drivers.id')
                ->where('drivers.user_id', '=', $id)
                ->orderBy('drivers.created_at','desc')
                ->get();

            return $drivers;
        }
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'phone',
            'Address',
            'creation date',
            'Status',
            'Availability',
            'Car Type',
            'Car Number',
            'Rating',
            'Orders Numbers',
            'Supervisor Name',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                // All headers - set font size to 14
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('B2:G8');

                // Set first row to height 20
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);

                // Set A1:D4 range to wrap text in cells
                $event->sheet->getDelegate()->getStyle('A1:D4')
                    ->getAlignment()->setWrapText(true);
            },
        ];
    }
}

