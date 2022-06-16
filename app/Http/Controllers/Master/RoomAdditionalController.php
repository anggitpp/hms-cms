<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoomAdditionalRequest;
use App\Models\Master\Hotel;
use App\Models\Master\RoomAdditional;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoomAdditionalController extends Controller
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
        $sql = RoomAdditional::where('hotel_id', $data['filterHotel']);
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['additionals'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.room-additionals.index', $data) : abort(401);
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

        return view('masters.room-additionals.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomAdditionalRequest $request, $id)
    {
        RoomAdditional::create([
            'hotel_id' => $id,
            'name' => $request->name,
            'price' => resetCurrency($request->price),
            'status' => $request->status,
            'description' => $request->description,
        ]);

        Alert::success('Success', 'Data Additional berhasil disimpan');

        return redirect()->route('masters.room-additionals.index', ['filterHotel' => $id]);
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
        $data['additional'] = RoomAdditional::find($id);
        $data['hotel'] = Hotel::find($data['additional']->hotel_id);

        return view('masters.room-additionals.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomAdditionalRequest $request, $id)
    {
        $additional = RoomAdditional::find($id);
        $additional->name = $request->name;
        $additional->price = resetCurrency($request->price);
        $additional->status = $request->status;
        $additional->description = $request->description;
        $additional->save();

        Alert::success('Success', 'Data Additional berhasil disimpan');

        return redirect()->route('masters.room-additionals.index', ['filterHotel' => $additional->hotel_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RoomAdditional::find($id)->delete();

        Alert::success('Success', 'Data Additional berhasil dihapus');

        return redirect()->back();
    }
}
