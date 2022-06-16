<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\EmployeeRequest;
use App\Models\Master\Employee;
use App\Models\Master\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name', 'category')
            ->whereIn('category', [
                'SAG',
                'MPP',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value) {
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->photoPath = '/uploads/masters/employees/';
        \View::share([
            'masters' => $masters,
            'gender' => array('m' => 'Laki-Laki', 'f' => 'Perempuan'),
            'status' => defaultStatus(),
            'photoPath' => '/uploads/masters/employees/'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Employee::query();
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if (!empty($data['filterHotel']))
            $sql->where('hotel_id',  $data['filterHotel']); //check if not empty then where
        $data['employees'] = $sql->paginate($this->defaultPagination($request));

        return !empty($this->access('index')) ? view('masters.employees.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
            ->pluck('name', 'id')
            ->toArray();
        $data['cities'] = DB::table('app_masters as t1')->join('app_masters as t2', function ($join){
            $join->on('t1.parent_id', 't2.id');
            $join->on('t1.category', DB::raw('"SKT"'));
            $join->on('t2.category', DB::raw('"SPV"'));
            $join->on('t1.status', DB::raw('"t"'));
            $join->on('t2.status', DB::raw('"t"'));
        })
            ->select( 't1.id as idKota', DB::raw('CONCAT(t2.name, " - ", t1.name) as city'))
            ->pluck('city', 'idKota')
            ->toArray();
        $data['id'] = $id;

        return !empty($this->access('create')) ? view('masters.employees.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request, $id)
    {
        $photo = uploadFile(
            $request->file('photo'),
            Str::slug($request->input('name')).'_'.time(),
            $this->photoPath);

        Employee::create([
            'name' => $request->name,
            'employee_number' => $request->employee_number,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date ? resetDate($request->birth_date) : '',
            'gender' => $request->gender,
            'religion_id' => $request->religion_id,
            'hotel_id' => $request->hotel_id,
            'position_id' => $request->position_id,
            'phone_number' => $request->phone_number,
            'photo' => $photo,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Data Pegawai berhasil disimpan');

        return redirect()->route('masters.employees.index', ['filterHotel' => $request->hotel_id]);
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
        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
            ->pluck('name', 'id')
            ->toArray();
        $data['cities'] = DB::table('app_masters as t1')->join('app_masters as t2', function ($join){
            $join->on('t1.parent_id', 't2.id');
            $join->on('t1.category', DB::raw('"SKT"'));
            $join->on('t2.category', DB::raw('"SPV"'));
            $join->on('t1.status', DB::raw('"t"'));
            $join->on('t2.status', DB::raw('"t"'));
        })
            ->select( 't1.id as idKota', DB::raw('CONCAT(t2.name, " - ", t1.name) as city'))
            ->pluck('city', 'idKota')
            ->toArray();
        $data['emp'] = Employee::find($id);

        return !empty($this->access('edit')) ? view('masters.employees.form', $data) : abort(401);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $emp = Employee::find($id);
        $photo = $request->exist_photo ? $emp->photo : '';
        if($emp->photo && $photo == '')
            \Storage::disk('public')->delete($emp->photo);
        if($request->file('photo')){
            Storage::disk('public')->delete($emp->photo);
            $photo = uploadFile($request->file('photo'), Str::slug($request->input('name')).'_'.time(), $this->photoPath);
        }

        $emp->name = $request->name;
        $emp->employee_number = $request->employee_number;
        $emp->birth_place = $request->birth_place;
        $emp->birth_date = $request->birth_date ? resetDate($request->birth_date) : '';
        $emp->gender = $request->gender;
        $emp->religion_id = $request->religion_id;
        $emp->hotel_id = $request->hotel_id;
        $emp->position_id = $request->position_id;
        $emp->phone_number = $request->phone_number;
        $emp->photo = $photo;
        $emp->status = $request->status;
        $emp->save();

        Alert::success('Success', 'Data Pegawai berhasil disimpan');

        return redirect()->route('masters.employees.index', ['filterHotel' => $request->hotel_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::find( $id);
        Storage::disk('public')->delete($emp->photo);
        $emp->delete();

        Alert::success('Success', 'Data Pegawai berhasil dihapus');

        return redirect()->back();
    }
}
