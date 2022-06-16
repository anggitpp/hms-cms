<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use App\Models\Master\Hotel;
use App\Models\Setting\Group;
use App\Models\Setting\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = User::query(); //SET QUERY
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['users'] = $sql->paginate(10)->onEachSide(1); //FINAL RESULT

        return !empty($this->access('index')) ? view('settings.users.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = defaultStatus();
        $data['groups'] = Group::orderBy('id')
            ->pluck('name','id')
            ->toArray();
        $data['employees'] = Employee::select(DB::raw('CONCAT(employee_number, " - ",name) name'), 'id')->pluck('name', 'id')->toArray();
        $data['hotels'] = Hotel::select('name', 'id')->get();

        return !empty($this->access('create')) ? view('settings.users.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $picture = uploadFile(
            $request->file('picture'),
            Str::slug($request->input('name')).'_'.time(),
            '/uploads/images/');
        $hotels = implode(',', $request->hotels);

        User::create([
            'username' => $request->username,
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'group_id' => $request->group_id,
            'hotel_access' => $hotels,
            'password' => bcrypt($request->password),
            'description' => $request->description,
            'picture' => $picture,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'User inserted successfully');

        return redirect()->route('settings.users.index');
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
        $data['employees'] = Employee::select(DB::raw('CONCAT(employee_number, " - ",name) name'), 'id')->pluck('name', 'id')->toArray();
        $data['status'] = defaultStatus();
        $data['user'] = User::find($id);
        $data['groups'] = Group::orderBy('id')
            ->pluck('name','id')
            ->toArray();
        $data['hotels'] = Hotel::select('name', 'id')->get();
        $data['selectedHotels'] = explode(',', $data['user']->hotel_access);

        return view('settings.users.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $picture = $user->picture;
        if($request->file('picture')){
            Storage::disk('public')->delete($user->picture);
            $picture = uploadFile($request->file('picture'), Str::slug($request->input('name')).'_'.time(), '/uploads/images/');
        }

        $hotels = implode(',', $request->hotels);

        $user->username = $request->username;
        $user->employee_id = $request->employee_id;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->group_id = $request->group_id;
        $user->hotel_access = $hotels;
        $user->description = $request->description;
        $user->picture = $picture;
        $user->status = $request->status;
        $user->save();

        Alert::success('Success', 'User updated successfully');

        return redirect()->route('settings.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        Storage::disk('public')->delete($user->picture);
        $user->delete();

        Alert::success('Success', 'User deleted successfully');

        return redirect()->back();
    }

    public function getEmployeeDetail($id)
    {
        $emp = Employee::select('name', 'phone_number')->find($id);

        return json_encode($emp);
    }
}
