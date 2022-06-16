<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoomPackageRequest;
use App\Models\Master\Hotel;
use App\Models\Master\RoomPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoomPackageController extends Controller
{
    public function __construct()
    {
        \View::share([
            'status' => defaultStatus(),
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
        $sql = RoomPackage::where('hotel_id', $data['filterHotel']);
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['packages'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.room-packages.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['hotel'] = Hotel::find($id);
        $data['id'] = $id;

        return view('masters.room-packages.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomPackageRequest $request, $id)
    {
        RoomPackage::create([
            'hotel_id' => $id,
            'name' => $request->name,
            'price' => resetCurrency($request->price),
            'status' => $request->status,
            'description' => $request->description,
            ]);

        Alert::success('Success', 'Data Paket berhasil disimpan');

        return redirect()->route('masters.room-packages.index', ['filterHotel' => $id]);
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
        $data['package'] = RoomPackage::find($id);
        $data['hotel'] = Hotel::find($data['package']->hotel_id);

        return view('masters.room-packages.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomPackageRequest $request, $id)
    {
        $package = RoomPackage::find($id);
        $package->name = $request->name;
        $package->price = resetCurrency($request->price);
        $package->status = $request->status;
        $package->description = $request->description;
        $package->save();

        Alert::success('Success', 'Data Paket berhasil disimpan');

        return redirect()->route('masters.room-packages.index', ['filterHotel' => $package->hotel_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RoomPackage::find($id)->delete();

        Alert::success('Success', 'Data Paket berhasil dihapus');

        return redirect()->back();
    }
}
