<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\HotelRequest;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Master\RoomPackage;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'SPV',
                'SKT',
                'MTH',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->photoPath = '/uploads/masters/hotel/';

        \View::share([
            'masters' => $masters,
            'status' => $this->defaultStatus,
            'photoPath' => $this->photoPath,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Hotel::whereRaw('id IN ('.\Auth::user()->hotel_access.')');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['hotels'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.hotels.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getLastNumber = Hotel::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        $data['lastCode'] = 'HT'.Str::padLeft(intval(Str::substr($getLastNumber,2,3)) + 1, '3', '0');
        $data['defaultLatitude'] = -6.226163451540129;
        $data['defaultLongitude'] = 106.95634603500368;

        return !empty($this->access('create')) ? view('masters.hotels.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelRequest $request)
    {
        $photo = uploadFile(
            $request->file('photo'),
            Str::slug($request->input('name')).'_'.time(),
            $this->photoPath);

        Hotel::create([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
            'type_id' => $request->type_id,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'photo' => $photo,
            'status' => $request->status,
            'description' => $request->description,
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        Alert::success('Success', 'Data Hotel berhasil disimpan');

        return redirect()->route('masters.hotels.index');
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
        $data['hotel'] = Hotel::find($id);

        return !empty($this->access('edit')) ? view('masters.hotels.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HotelRequest $request, $id)
    {
        $hotel = Hotel::find($id);
        $photo = $request->exist_photo ? $hotel->photo : '';
        if($hotel->photo && $photo == '')
            \Storage::disk('public')->delete($hotel->photo);
        if($request->file('photo')){
            Storage::disk('public')->delete($hotel->photo);
            $photo = uploadFile($request->file('photo'), Str::slug($request->input('name')).'_'.time(), $this->photoPath);
        }
        $hotel->name = $request->name;
        $hotel->code = $request->code;
        $hotel->address = $request->address;
        $hotel->type_id = $request->type_id;
        $hotel->province_id = $request->province_id;
        $hotel->city_id = $request->city_id;
        $hotel->phone_number = $request->phone_number;
        $hotel->email = $request->email;
        $hotel->photo = $photo;
        $hotel->status = $request->status;
        $hotel->description = $request->description;
        $hotel->postal_code = $request->postal_code;
        $hotel->latitude = $request->latitude;
        $hotel->longitude = $request->longitude;
        $hotel->save();

        Alert::success('Success', 'Data Hotel berhasil disimpan');

        return redirect()->route('masters.hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        Storage::disk('public')->delete($hotel->photo);
        $hotel->delete();

        Room::where('hotel_id', $id)->delete();
        RoomPackage::where('hotel_id', $id)->delete();

        Alert::success('Success', 'Data Hotel berhasil dihapus');

        return !empty($this->access('destroy')) ? redirect()->back() : abort(401);
    }

    public function subMasters($id){
        $cities = DB::table("app_masters")
            ->where("parent_id",$id)
            ->pluck("name","id");

        return json_encode($cities);
    }
}
