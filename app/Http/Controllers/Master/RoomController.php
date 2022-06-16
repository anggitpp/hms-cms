<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoomRequest;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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
        $sql = Room::query();
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
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
        $data['rooms'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.rooms.index', $data) : abort(401);
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

        return !empty($this->access('create')) ? view('masters.rooms.form', $data) : abort(401);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request, $id)
    {
        Room::create([
            'hotel_id' => $id,
            'number' => $request->number,
            'type_id' => $request->type_id,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'inactive_reason' => $request->inactive_reason,
        ]);

        Alert::success('Success', 'Data Kamar berhasil disimpan');

        return redirect()->route('masters.rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['room'] = Room::find($id);
        $data['hotel'] = Hotel::find($data['room']->hotel_id);
        $data['styleReason'] = $data['room']->status_id == $this->getParameter('OOF') || $data['room']->status_id == $this->getParameter('TOOF') ? 'block' : 'none';

        return !empty($this->access('edit')) ? view('masters.rooms.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
        $room = Room::find($id);
        $room->number = $request->number;
        $room->type_id = $request->type_id;
        $room->description = $request->description;
        $room->status_id = $request->status_id;
        $room->inactive_reason = $request->inactive_reason;
        $room->save();

        Alert::success('Success', 'Data Kamar berhasil disimpan');

        return redirect()->route('masters.rooms.index', ['filterHotel' => $room->hotel_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::find($id)->delete();

        Alert::success('Success', 'Data Kamar berhasil dihapus');

        return redirect()->back();
    }
}
