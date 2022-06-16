<?php

namespace App\Exports\Report;

use App\Models\Master\Hotel;
use App\Models\Master\RoomPackage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ListRoomNumberExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
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
            'Number of Pax',
            'Package',
            'Extra Bed',
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
        $arrPackage = RoomPackage::select('name', 'id')->pluck('name', 'id')->toArray();
        $orders = DB::table('transaction_hotel_orders as t1')
            ->select('t1.id', 't1.arrival_date', 't1.departure_date', 't1.note', 't1.number_of_adults', 't1.extra_bed', 't1.package_id', 't2.number')
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
        foreach ($orders as $key => $r){
            $no++;

            $arrData[$no]['no'] = $no;
            $arrData[$no]['number'] = $r->number;
            $arrData[$no]['arrivalDate'] = setDate($r->arrival_date, 't');
            $arrData[$no]['departureDate'] = setDate($r->departure_date, 't');
            $arrData[$no]['pax'] = $r->number_of_adults;
            $arrData[$no]['package'] = $r->package_id ? $arrPackage[$r->package_id] : '';
            $arrData[$no]['extraBed'] = $r->extra_bed;
            $arrData[$no]['note'] = $r->note;
        }

        $datas = collect($arrData ?? []);

        return $datas;
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:H2')->getFont()->setBold(true);
        $sheet->getStyle('A2:H'.$highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ],
        ]);

        $sheet->setTitle('Laporan List Room Number');
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
            'E' => 20,
            'F' => 25,
            'G' => 15,
            'H' => 30,
        ];
    }
}
