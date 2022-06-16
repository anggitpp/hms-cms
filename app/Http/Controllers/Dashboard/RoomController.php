<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Setting\Parameter;
use App\Models\Transaction\HotelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name', 'category')
            ->whereIn('category', [
                'MSK',
                'MTK',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value) {
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();

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
        $data['filterType'] = $request->get('filterType'); //GET FILTER
        $data['filterDate'] = $request->get('filterDate') ? resetDate($request->get('filterDate')) : date('Y-m-d');
        $data['filter'] = $request->get('filter'); //GET FILTER
        $sql = DB::table('master_rooms as t1')
            ->select('t1.id', 't1.number', 't1.inactive_reason', 't1.hotel_id', 't2.id as idOrder', 't2.name', 't2.departure_date', 't2.number_of_adults', 't2.status',
            DB::raw('CASE WHEN `t1`.`status_id` = "517" THEN "o" WHEN `t1`.`status_id` = "518" THEN "o" WHEN `t1`.`status_id` = "532" THEN "c" ELSE `t2`.`status` END as roomStatus'))
            ->whereRaw('t1.hotel_id IN ('.\Auth::user()->hotel_access.')') // SET FILTER ACCESS HOTEL
            ->leftJoin('transaction_hotel_orders as t2', function ($join) use ($data){
                $join->whereRaw('FIND_IN_SET(t1.id, t2.rooms)');
                $join->on('t1.hotel_id', DB::raw($data['filterHotel']));
                $join->on('t2.status', '!=', DB::raw("'c'"));
                $join->whereRaw("'".$data['filterDate']."'".' BETWEEN t2.arrival_date AND t2.departure_date');
            })->orderBy('t1.number');
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%')
                ->orWhere('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if (!empty($data['filterHotel']))
            $sql->where('t1.hotel_id',  $data['filterHotel']); //check if not empty then where
        if (!empty($data['filterType']))
            $sql->where('t1.type_id',  $data['filterType']); //check if not empty then where
        $rooms = $sql->get();
        $data['totalAvailable'] = 0;
        $data['totalRoom'] = 0;
        $available = $this->getParameter('AVL');
        $data['paramStatus'] = Parameter::select('value', 'code')->pluck('value', 'code')->toArray();
        $data['arrStatus'] = array('o' => 'danger', 'r' => 'secondary', 's' => 'dark', 'c' => 'warning'); // SET COLOR
        foreach ($rooms as $key => $r){
            $data['detail'][$r->id]['name'] = $r->name; //GET ORDER NAME
            $data['detail'][$r->id]['number_of_adults'] = $r->number_of_adults; //GET ORDER NUMBER OF ADULT
            $data['detail'][$r->id]['departure_date'] = $r->departure_date; // GET ORDER DEPARTURE DATE
            if($r->roomStatus == NULL) {
                $data['totalAvailable']++; //TOTAL AVAILABLE
            }
            $data['totalRoom']++; //TOTAL KAMAR
        }
        $data['rooms'] = $rooms;

//        dd($data);

        return !empty($this->access('index')) ? view('dashboards.rooms.index', $data) : abort(401);
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
