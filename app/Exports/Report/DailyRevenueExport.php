<?php

namespace App\Exports\Report;

use App\Models\Master\Hotel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyRevenueExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
{
    protected $filter;

    function __construct($filter) {
        $this->filter = $filter;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array{
        return [
            'No',
            'Room Number',
            'Room Rate',
            'Discount (%)',
            'Revenue',
            ];
    }

    public function collection()
    {
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')') // SET FILTER ACCESS HOTEL
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $this->filter['filterHotel'] = $this->filter['filterHotel'] ?? array_key_first($data['hotels']); //GET FILTER
        $orders = DB::table('transaction_hotel_orders as t1')
            ->select('t1.id', 't1.discount', 't2.number', 't3.price')
            ->join('master_rooms as t2', function ($join){
                $join->whereRaw('FIND_IN_SET( t2.id, t1.rooms )');
            })
            ->join('master_room_prices as t3', function ($join){
                $join->on('t2.type_id', 't3.type_id');
                $join->on('t3.hotel_id', 't1.hotel_id');
            })->whereRaw("'".$this->filter['filterDate']."'".' BETWEEN arrival_date AND departure_date')
        ;
         if (!empty($this->filter['filterHotel']))
            $orders->where('t1.hotel_id',  $this->filter['filterHotel']); //check if not empty then where
        if (!empty($this->filter['filter']))
            $orders->where('number', 'like', '%' . $this->filter['filter'] . '%');
        $orders = $orders->get();
        $no=0;
        $totalRevenue = 0;
        foreach ($orders as $key => $r){
            $no++;
            $revenue = $r->price;
            if($r->discount > 0)
                $revenue = $r->price - ($r->price * $r->discount / 100);
            $arrData[$no]['no'] = $no;
            $arrData[$no]['number'] = $r->number;
            $arrData[$no]['price'] = setCurrency($r->price);
            $arrData[$no]['discount'] = $r->discount;
            $arrData[$no]['revenue'] = setCurrency($revenue);

            $totalRevenue += $revenue;
        }
        $no++;
        $arrData[$no]['no'] = $no;
        $arrData[$no]['number'] = '';
        $arrData[$no]['price'] = '';
        $arrData[$no]['discount'] = '';
        $arrData[$no]['revenue'] = setCurrency($totalRevenue);

        $datas = collect($arrData ?? []);

        return $datas;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:E2')->getFont()->setBold(true);
        $sheet->getStyle('A2:E'.$highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ],
        ]);
        $sheet->mergeCells('A'.$highestRow.':D'.$highestRow);
        $sheet->setCellValue('A'.$highestRow, 'Total Revenue');
        $sheet->getStyle('C3:E'.$highestRow)->applyFromArray([
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            )
        ]);
        $sheet->getStyle('A'.$highestRow)->applyFromArray([
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            )
        ]);
        $sheet->setTitle('Laporan Daily Revenue');
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 12,
            'E' => 15,
        ];
    }
}
