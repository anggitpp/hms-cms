<?php

namespace App\Exports\Report;

use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Setting\Master;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ListGuestInhouseExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
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
            'Guest Name',
            'Nationality',
            'Room Number',
            'Check In Date',
            'Check Out Date',
            'Number of Pax',
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
        $arrRoom = Room::select('id', 'number')
            ->where('hotel_id', $this->filter['filterHotel'])
            ->pluck('number', 'id')
            ->toArray();
        $arrMaster = Master::select('id', 'name')
            ->active()
            ->where('category', 'PAN')
            ->pluck('name', 'id')
            ->toArray();
        $orders = DB::table('transaction_hotel_orders')
            ->select('id', 'name', 'nationality_id', 'arrival_date', 'departure_date', 'number_of_adults', 'note', 'rooms')
            ->whereRaw("'".$this->filter['filterDate']."'".' BETWEEN arrival_date AND departure_date');
        if (!empty($this->filter['filterHotel']))
            $orders->where('hotel_id',  $this->filter['filterHotel']); //check if not empty then where
        if (!empty($this->filter['filter']))
            $orders->where('number', 'like', '%' . $this->filter['filter'] . '%');
        $orders = $orders->get();
        $no=0;
        foreach ($orders as $key => $r){
            if(str_contains($r->rooms, ',')){
                $rooms = explode(',',$r->rooms);
                foreach ($rooms as $k => $v){
                    $listRoom[] = $arrRoom[trim($v)];
                }
                $rooms = implode(', ', $listRoom);
            }else{
                $rooms = $arrRoom[$r->rooms];
            }
            $no++;

            $arrData[$no]['no'] = $no;
            $arrData[$no]['name'] = $r->name;
            $arrData[$no]['nationality'] = $arrMaster[$r->nationality_id];
            $arrData[$no]['number'] = $rooms;
            $arrData[$no]['arrivalDate'] = setDate($r->arrival_date, 't');
            $arrData[$no]['departureDate'] = setDate($r->departure_date, 't');
            $arrData[$no]['pax'] = $r->number_of_adults;
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
//        $sheet->getStyle('D3:F'.$highestRow)->applyFromArray([
//            'alignment' => array(
//                'horizontal' => Alignment::HORIZONTAL_RIGHT,
//            )
//        ]);
        $sheet->setTitle('List Guest Inhouse');
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 30,
        ];
    }
}
