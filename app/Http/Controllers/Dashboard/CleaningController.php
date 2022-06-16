<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Setting\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CleaningController extends Controller
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
        $data['paramStatus'] = Parameter::select('value', 'code')->pluck('value', 'code')->toArray();
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $data['filterType'] = $request->get('filterType'); //GET FILTER
        $data['filter'] = $request->get('filter'); //GET FILTER
        $sql = DB::table('master_rooms')
            ->select('id','number')
            ->whereRaw('hotel_id IN ('.\Auth::user()->hotel_access.')')
            ->where('status_id', $data['paramStatus']['CLN'])
            ->orderBy('number');
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%');
        if (!empty($data['filterHotel']))
            $sql->where('hotel_id',  $data['filterHotel']); //check if not empty then where
        if (!empty($data['filterType']))
            $sql->where('type_id',  $data['filterType']); //check if not empty then where
        $data['rooms'] = $sql->paginate($this->defaultPagination($request));
        $data['total'] = $sql->count();

        return !empty($this->access('index')) ? view('dashboards.cleaning.index', $data) : abort(401);
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
    public function update($id)
    {
        $room = Room::find($id);
        $room->status_id = $this->getParameter('AVL');
        $room->save();

        Alert::success('Success', 'Status Kamar berhasil diubah');

        return redirect()->back();
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
