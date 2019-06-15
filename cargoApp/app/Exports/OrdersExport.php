<?php

namespace App\Exports;

use App\Order;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;



class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $orders = Order::leftjoin('company_order', 'orders.id', 'company_order.order_id')
            ->leftjoin('driver_order', 'orders.id', 'driver_order.order_id')
            ->leftjoin('packages', 'orders.id', 'packages.order_id')
            ->leftjoin('companies', 'companies.id', 'company_order.sender_id')
            ->leftjoin('drivers', 'drivers.id', 'driver_order.driver_id')
            ->select(
                'orders.id',
                'companies.name as comp_name',
                'orders.shipment_type',
                'orders.pickup_date',
                'orders.status',
                'orders.estimated_cost',
                'orders.final_cost',
                'drivers.name',
                'drivers.phone',
                'packages.Weight',
                'packages.quantity',
                'packages.height',
                'packages.length',
                'packages.width',
                'packages.value',
                'packages.pickup_location',
                'packages.drop_off_location',
                'packages.time_to_deliver'

            )->orderBy('packages.created_at', 'desc')->get();

        return $orders;
    }

    public function headings(): array
    {
        return [
            '#',
            'Company name',
            'Shipment type',
            'Pick up date/time',
            'Status',
            'Estimated cost',
            'Final cost',
            'Driver name',
            'Driver phone',
            'Order Weight',
            'Order quantity',
            'Order.height',
            'Order.length',
            'Order.width',
            'Order value',
            // 'Order photo',
            'Order pickup location',
            'Order drop off location',
            'Order time to deliver',
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
