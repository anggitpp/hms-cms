<?php

namespace App\Http\Controllers\Report;

use App\Exports\Report\DailyRevenueExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Setting\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DailyRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')') // SET FILTER ACCESS HOTEL
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $data['filterType'] = $request->get('filterType'); //GET FILTER
        $data['filterDate'] = $request->get('filterDate') ? resetDate($request->get('filterDate')) : date('Y-m-d');
        $data['filter'] = $request->get('filter'); //GET FILTER
        $sql = DB::table('transaction_hotel_orders as t1')
            ->select('t1.id', 't1.discount', 't2.number', 't3.price')
            ->join('master_rooms as t2', function ($join){
           $join->whereRaw('FIND_IN_SET( t2.id, t1.rooms )');
        })
        ->join('master_room_prices as t3', function ($join){
            $join->on('t2.type_id', 't3.type_id');
            $join->on('t3.hotel_id', 't1.hotel_id');
        })
            ->whereRaw("'".$data['filterDate']."'".' BETWEEN arrival_date AND departure_date')
            ->orderBy('t1.id', 'asc');
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%');
        if (!empty($data['filterHotel']))
            $sql->where('t1.hotel_id',  $data['filterHotel']); //check if not empty then where
        if (!empty($data['filterType']))
            $sql->where('t1.type_id',  $data['filterType']); //check if not empty then where
        $data['orders'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('reports.daily-revenue.index', $data) : abort(401);    }

    /**
     * Export data
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new DailyRevenueExport([
            'filter' => $request->get('filter'),
            'filterDate' => $request->get('filterDate'),
            'filterHotel' => $request->get('filterHotel')
        ]), 'Laporan Daily Revenue.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
