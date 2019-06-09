<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SupervisorsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $supervisors = User::whereHas(
            'roles',
            function ($supervisor) {
                $supervisor->where('name', 'supervisor');
            }
        )
            ->leftJoin('drivers', function ($join) {
                $join->on('users.id', '=', 'drivers.user_id');;
            })
            ->select(
                'users.id',
                'users.name',
                'users.phone',
                'users.email',
                'users.address',
                'users.created_at',
                'users.status',
                DB::raw("count(drivers.user_id) as drivers_count")
            )
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'asc')->get();

        return $supervisors;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'phone',
            'Email',
            'Address',
            'creation date',
            'Status',
            'Drivers No',
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
