<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Transaction\HotelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
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
            'arrStatus' => array($this->getParameter('OOF') => 'danger', $this->getParameter('TOOF') => 'danger', $this->getParameter('BOOKED') => 'secondary', $this->getParameter('OCC') => 'dark')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Room::query();
        $data['hotels'] = Hotel::select('id', 'name')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $data['filterTipe'] = $request->get('filterTipe'); //GET FILTER
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if (!empty($data['filterHotel']))
            $sql->where('hotel_id',  $data['filterHotel']); //check if not empty then where
        if (!empty($data['filterTipe']))
            $sql->where('type_id',  $data['filterTipe']); //check if not empty then where
        $data['totalAvailable'] = DB::table('master_rooms')->select(DB::raw('COUNT(id) as totalAvailable'))->where('hotel_id', $data['filterHotel'])->where('status_id', $this->getParameter('AVL'))->pluck('totalAvailable')->first();
        $data['totalRoom'] = DB::table('master_rooms')->select(DB::raw('COUNT(id) as totalRoom'))->where('hotel_id', $data['filterHotel'])->pluck('totalRoom')->first();
        $data['hotel'] = Hotel::find($data['filterHotel']);
        $data['rooms'] = $sql->paginate($this->defaultPagination($request));


        return !empty($this->access('index')) ? view('dashboards.hotels.index', $data) : abort(401);
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
