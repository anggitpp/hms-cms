<?php

namespace App\Exports\Report;

use App\Models\Master\Hotel;
use App\Models\Master\Room;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyRoomOccupancyExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
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
            'Check In Date',
            'Check Out Date',
            'Remark',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')') // SET FILTER ACCESS HOTEL
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $this->filter['filterHotel'] = $this->filter['filterHotel'] ?? array_key_first($data['hotels']); //GET FILTER
        $orders = DB::table('transaction_hotel_orders as t1')
            ->select('t1.id', 't1.arrival_date', 't1.departure_date', 't1.note', 't2.number')
            ->join('master_rooms as t2', function ($join){
                $join->whereRaw('FIND_IN_SET( t2.id, t1.rooms )');
            })
            ->whereRaw("'".$this->filter['filterDate']."'".' BETWEEN arrival_date AND departure_date');
        if (!empty($this->filter['filterHotel']))
            $orders->where('t1.hotel_id',  $this->filter['filterHotel']); //check if not empty then where
        if (!empty($this->filter['filter']))
            $orders->where('number', 'like', '%' . $this->filter['filter'] . '%');
        $orders = $orders->get();
        $no=0;
        $totalOccupied = 0;
        $totalAvailable = Room::where('status_id', $this->filter['statusActive'])->count();
        foreach ($orders as $key => $r){
            $no++;

            $arrData[$no]['no'] = $no;
            $arrData[$no]['number'] = $r->number;
            $arrData[$no]['arrivalDate'] = setDate($r->arrival_date, 't');
            $arrData[$no]['departureDate'] = setDate($r->departure_date, 't');
            $arrData[$no]['note'] = $r->note;

            $totalOccupied++;
        }
        $no++;
        $arrData[$no]['no'] = $no;
        $arrData[$no]['number'] = '';
        $arrData[$no]['arrivalDate'] = '';
        $arrData[$no]['departureDate'] = '';
        $arrData[$no]['note'] = floor($totalOccupied / $totalAvailable * 100) . ' %';

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
        $sheet->setCellValue('A'.$highestRow, 'Room Occupancy');
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
        $sheet->setTitle('Laporan Daily Occupancy');
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
            'C' => 20,
            'D' => 20,
            'E' => 25,
        ];
    }
}
