<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoomPriceRequest;
use App\Models\Master\Hotel;
use App\Models\Master\RoomPrice;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoomPriceController extends Controller
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
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $sql = DB::table('app_masters as t1')
            ->select('t1.id', 't1.name', 't2.price', 't2.description')
            ->leftJoin('master_room_prices as t2', function ($join) use ($data){
            $join->on('t1.id', 't2.type_id');
            $join->on('hotel_id',  DB::raw($data['filterHotel'])); //check if not empty then where
        })->where('category', 'MTK')
        ->orderBy('t1.order');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['masters'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.room-prices.index', $data) : abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $hotelId)
    {
        $data['hotel'] = Hotel::find($hotelId);
        $data['master'] = Master::find($id);
        $data['price'] = RoomPrice::where('hotel_id', $hotelId)->where('type_id', $id)->first();

        return !empty($this->access('edit')) ? view('masters.room-prices.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomPriceRequest $request, $id, $hotelId)
    {
        RoomPrice::updateOrInsert(
            [
            'hotel_id' => $hotelId,
            'type_id' => $id],
            [
            'price' => resetCurrency($request->price),
            'description' => $request->description,
            ]
        );

        Alert::success('Success', 'Data Harga berhasil disimpan');

        return redirect()->route('masters.room-prices.index', ['filterHotel' => $hotelId]);
    }
}
