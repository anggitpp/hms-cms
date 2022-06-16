<?php

namespace App\Http\Controllers\Report;

use App\Exports\Report\ListGuestInhouseExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListGuestInhouseController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'PAN',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }

        \View::share([
            'masters' => $masters,
        ]);
    }
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
        $data['filterDate'] = $request->get('filterDate') ? resetDate($request->get('filterDate')) : date('Y-m-d');
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['arrRoom'] = Room::select('id', 'number')
            ->where('hotel_id', array_key_first($data['hotels']))
            ->pluck('number', 'id')
            ->toArray();
        $sql = DB::table('transaction_hotel_orders')
            ->select('id', 'name', 'nationality_id', 'arrival_date', 'departure_date', 'number_of_adults', 'note', 'rooms')
            ->whereRaw("'".$data['filterDate']."'".' BETWEEN arrival_date AND departure_date')
            ->orderBy('id', 'asc');
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%');
        if (!empty($data['filterHotel']))
            $sql->where('hotel_id',  $data['filterHotel']); //check if not empty then where
        $data['orders'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('reports.guest-inhouse.index', $data) : abort(401);    }

    /**
     * Export data
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new ListGuestInhouseExport([
            'filter' => $request->get('filter'),
            'filterDate' => $request->get('filterDate'),
            'filterHotel' => $request->get('filterHotel')
        ]), 'List Guest Inhouse.xlsx');
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
