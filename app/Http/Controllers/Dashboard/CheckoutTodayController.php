<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Transaction\HotelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutTodayController extends Controller
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
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $data['arrRoom'] = Room::select('id', 'number')
            ->where('hotel_id', array_key_first($data['hotels']))
            ->pluck('number', 'id')
            ->toArray();
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterDate'] = $request->get('filterDate') ? resetDate($request->get('filterDate')) : date('Y-m-d'); //GET FILTER
        $sql = DB::table('transaction_hotel_orders as t1')
            ->select('t1.id', 't1.rooms', 't1.name', 't1.phone_number', 't1.departure_date', 't1.fix_price', 't1.hotel_id')
            ->join('master_rooms as t2', function ($join) use ($data) {
            $join->whereRaw('FIND_IN_SET(t1.rooms, t2.id)');
            $join->on('t1.hotel_id', DB::raw($data['filterHotel']));
            $join->on('t1.status', '!=', DB::raw("'c'"));
        });
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('number', 'like', '%' . $data['filter'] . '%');
        if (!empty($data['filterHotel']))
            $sql->where('t1.hotel_id',  $data['filterHotel']); //check if not empty then where
        if (!empty($data['filterDate']))
            $sql->where('departure_date','=', $data['filterDate']); //check if not empty then where
        $data['orders'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('dashboards.checkout-today.index', $data) : abort(401);
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
