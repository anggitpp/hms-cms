<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\HotelOrderRequest;
use App\Models\Master\Hotel;
use App\Models\Master\Room;
use App\Models\Master\RoomAdditional;
use App\Models\Master\RoomPackage;
use App\Models\Master\RoomPrice;
use App\Models\Setting\Master;
use App\Models\Transaction\HotelOrder;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class HotelOrderController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'SPV',
                'SKT',
                'MPP',
                'PAN',
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
            'paymentOption' => array('c' => 'Cash', 't' => 'Transfer', 'k' => 'Debit/Kartu Kredit', 'v' => 'Voucher', 'm' => 'Company'),
            'accomodation' => array('f' => 'Full', 'r' => 'Room Only'),
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
        $sql = HotelOrder::whereRaw('hotel_id IN ('.\Auth::user()->hotel_access.')'); //set filter access hotel

        $data['hotels'] = Hotel::select('id', 'name')
            ->whereRaw('id IN ('.\Auth::user()->hotel_access.')')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();
        $data['arrRoom'] = Room::select('id', 'number')
            ->where('hotel_id', array_key_first($data['hotels']))
            ->pluck('number', 'id')
            ->toArray();
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterHotel'] = $request->get('filterHotel') ?? array_key_first($data['hotels']); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if (!empty($data['filter']))
            $sql->where('number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if (!empty($data['filterHotel']))
            $sql->where('hotel_id',  $data['filterHotel']); //check if not empty then where
        $data['orders'] = $sql->orderBy('id', 'desc')->paginate($this->defaultPagination($request));
        $data['status'] = array('s' => 'Check in', 'r' => 'Reservasi', 'c' => 'Check out');

        return !empty($this->access('index')) ? view('transactions.orders.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['extraBedPrice'] = RoomAdditional::where('hotel_id', $request->get('hotelId'))
            ->where('name', 'Extra Bed')
            ->first()->price;
        $packages = RoomPackage::where('hotel_id', $request->get('hotelId'))
            ->select('name', 'price', 'id')->get();
        foreach ($packages as $key => $value){
            $data['packages'][$value->id] = $value->name.' - '.setCurrency($value->price);
        }

        if(!empty($request->get('roomId'))) {
            $selectedDate = $request->get('selectedDate');
            if(!empty($selectedDate)){
                $carbonSelectedDate = Carbon::createFromDate($selectedDate);
            }
            $today = $carbonSelectedDate ? $carbonSelectedDate->toDateString() : Carbon::now()->toDateString();
            $tommorow = $carbonSelectedDate ? $carbonSelectedDate->addDays(1)->toDateString() : Carbon::now()->addDays(1)->toDateString();
            $roomType = Room::find($request->get('roomId'))->type_id;
            $price = RoomPrice::where('type_id', $roomType)->where('hotel_id', $request->get('hotelId'))->first()->price;
            if ($request->get('roomId')) {
                $data['defaultSelected']['tanggalMasuk'] = $today;
                $data['defaultSelected']['tanggalKeluar'] = $tommorow;
                $data['defaultSelected']['totalHari'] = 1;
                $data['defaultSelected']['harga'] = $price;
                $data['defaultSelected']['totalHarga'] = $price;
            }
        }

        $rooms = DB::table('master_rooms as t1')->join('app_masters as t2', function ($join){
            $join->on('t1.type_id', 't2.id');
        });
        if(!empty($request->get('roomId'))){ // IF FROM DASHBOARD THEN FILTER BY SELECTED DATE
            $rooms->leftJoin('transaction_hotel_orders as t3', function ($join) use ($today, $tommorow){
                $join->whereRaw('FIND_IN_SET(t1.id, t3.rooms)');
                $join->whereRaw("(arrival_date >= '".$today."' AND arrival_date <= '".$tommorow."' 
                OR 
                departure_date >= '".$today."' AND departure_date <= '".$tommorow."'
                OR 
                '".$today."' BETWEEN arrival_date AND departure_date
                OR 
                '".$tommorow."' BETWEEN arrival_date AND departure_date
                )");
            })
            ->where('t3.id', NULL);
        }
        $rooms = $rooms->select('t1.number', 't1.id', 't2.name')
            ->where('t1.hotel_id', $request->get('hotelId'))
            ->get();

        foreach ($rooms as $key => $value){
            $data['rooms'][$value->name][$value->id] = $value->number;
        }

        $data['selectedRoom'] = $request->get('roomId');
        $data['status'] = array('s' => 'Check in', 'r' => 'Reservasi');

        return view('transactions.orders.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelOrderRequest $request)
    {
        $status = $request->status == 's' ? 'OCC' : 'BOOKED';
        $status = $request->status == 'c' ? 'CLN' : $status;
        $totalPrice = 0;
        foreach ($request->rooms as $key => $value){
            $room = Room::find($value);
            $room->status_id = $this->getParameter($status);
            $room->save();

            $price = RoomPrice::where('type_id', $room->type_id)->where('hotel_id', $room->hotel_id)->first()->price;
            $totalPrice += $price;
        }
        $listRoom = implode(",", $request->rooms);

        //LETS FORGET FORM AND RE FORMULA AGAIN
        //FIRST, GET RANGE DATE
        $package = RoomPackage::find($request->package_id); //GET PACKAGE DATA
        $arrivalDate = Carbon::parse(resetDate($request->arrival_date));
        $departureDate = Carbon::parse(resetDate($request->departure_date));
        $numberOfNights = $arrivalDate->diffInDays($departureDate);
        //GET PRICE
        $price = $totalPrice * $numberOfNights;
        //GET DISCOUNT PRICE
        $fixPrice = $price;
        if(!empty($request->discount)) {
            $discountPrice = $totalPrice * $numberOfNights * $request->discount / 100;
            $fixPrice -= $discountPrice;
        }
        //GET PRICE EXTRA BED
        $extraBed = RoomAdditional::where('hotel_id', $request->hotel_id)
            ->where('name', 'Extra Bed')
            ->first()->price;
        if(!empty($request->extra_bed)) {
            $extraBedPrice = $request->extra_bed * $extraBed * $numberOfNights;
            $fixPrice += $extraBedPrice;
        }
        //GET PACKAGE PRICE
        if(!empty($request->package_total)) {
            $packagePrice = $request->package_total * $package->price * $numberOfNights;
            $fixPrice += $packagePrice;
        }

        HotelOrder::create([
            'hotel_id' => $request->hotel_id,
            'name' => $request->name,
            'identity_number' => $request->identity_number,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'arrival_date' => resetDate($request->arrival_date),
            'departure_date' => resetDate($request->departure_date),
            'number_of_nights' => $numberOfNights,
            'rooms' => $listRoom,
            'price' => $price,
            'number_of_adults' => $request->number_of_adults,
            'package_id' => $request->package_id,
            'package_price' => $packagePrice ?? 0,
            'package_total' => $request->package_total,
            'extra_bed' => $request->extra_bed,
            'extra_bed_price' => $extraBedPrice ?? 0,
            'note' => $request->note,
            'discount' => $request->discount,
            'discount_price' => $discountPrice ?? 0,
            'fix_price' => $fixPrice,
            'payment_method' => $request->payment_method,
            'payment_detail' => $request->payment_detail,
            'status' => $request->status,
            'company_emergency_name' => $request->company_emergency_name,
            'company_phone' => $request->company_phone,
            'company_accomodation' => $request->company_accomodation,
            'nationality_id' => $request->nationality_id,
        ]);

        Alert::success('Success', 'Data Pemesanan berhasil disimpan');

        return redirect()->route('transactions.orders.index', ['filterHotel' => $request->hotel_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $packages = RoomPackage::where('hotel_id', $request->get('hotelId'))
            ->select('name', 'price', 'id')->get();
        foreach ($packages as $key => $value){
            $data['packages'][$value->id] = $value->name.' - '.setCurrency($value->price);
        }

        $data['order'] = HotelOrder::find($id);
        if($data['order']->extra_bed)
            $data['order']->extra_bed_piece_price = $data['order']->extra_bed_price / $data['order']->number_of_nights / $data['order']->extra_bed;

        $rooms = DB::table('master_rooms as t1')->join('app_masters as t2', function ($join){
            $join->on('t1.type_id', 't2.id');
        })
            ->leftJoin('transaction_hotel_orders as t3', function ($join) use ($data){
                $join->whereRaw('FIND_IN_SET(t1.id, t3.rooms)');
                $join->whereRaw("(
                arrival_date >= '".$data['order']->arrival_date."' AND arrival_date <= '".$data['order']->departure_date."' 
                OR 
                departure_date >= '".$data['order']->arrival_date."' AND departure_date <= '".$data['order']->departure_date."'
                OR '".$data['order']->arrival_date."' BETWEEN arrival_date AND departure_date
                OR '".$data['order']->departure_date."' BETWEEN arrival_date AND departure_date
                )");
            })
            ->whereRaw("(t3.id IS NULL OR t3.id = $id)")
            ->select('t1.number', 't1.id', 't2.name')
            ->where('t1.hotel_id', $data['order']->hotel_id)
            ->get();

        foreach ($rooms as $key => $value){
            $data['rooms'][$value->name][$value->id] = $value->number;
        }

        $data['status'] = array('s' => 'Check in', 'r' => 'Reservasi', 'c' => 'Checkout');

        return view('transactions.orders.form', $data);
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
        $order = HotelOrder::find($id);
        //RESET ROOM
        if(str_contains($order->rooms, ',')) {
            $rooms = explode(',', $order->rooms);
            foreach ($rooms as $key => $value) {
                $room = Room::find($value);
                $room->status_id = $this->getParameter('AVL');
                $room->save();
            }
        }else{
            $room = Room::find($order->rooms);
            $room->status_id = $this->getParameter('AVL');
            $room->save();
        }

        //SET STATUS ROOM
        $status = $request->status == 's' ? 'OCC' : 'BOOKED';
        $status = $request->status == 'c' ? 'CLN' : $status;
        $totalPrice = 0;
        foreach ($request->rooms as $key => $value) {
            $room = Room::find($value);
            $room->status_id = $this->getParameter($status);
            $room->save();

            $price = RoomPrice::where('type_id', $room->type_id)->where('hotel_id', $room->hotel_id)->first()->price;
            $totalPrice += $price;
        }
        $listRoom = implode(",", $request->rooms);

        //LETS FORGET FORM AND RE FORMULA AGAIN
        //FIRST, GET RANGE DATE
        $package = RoomPackage::find($request->package_id);
        $arrivalDate = Carbon::parse(resetDate($request->arrival_date));
        $departureDate = Carbon::parse(resetDate($request->departure_date));
        $numberOfNights = $arrivalDate->diffInDays($departureDate);
        //GET PRICE
        $price = $totalPrice * $numberOfNights;
        //GET DISCOUNT PRICE
        $fixPrice = $price;
        if(!empty($request->discount)) {
            $discountPrice = $totalPrice * $numberOfNights * $request->discount / 100;
            $fixPrice -= $discountPrice;
        }
        //GET PRICE EXTRA BED
        $extraBed = RoomAdditional::where('hotel_id', $request->hotel_id)
            ->where('name', 'Extra Bed')
            ->first()->price;
        if(!empty($request->extra_bed)) {
            $extraBedPrice = $request->extra_bed * $extraBed * $numberOfNights;
            $fixPrice += $extraBedPrice;
        }
        //GET PACKAGE PRICE
        if(!empty($request->package_total)) {
            $packagePrice = $request->package_total * $package->price * $numberOfNights;
            $fixPrice += $packagePrice;
        }

        $order->hotel_id = $request->hotel_id;
        $order->name = $request->name;
        $order->identity_number = $request->identity_number;
        $order->phone_number = $request->phone_number;
        $order->address = $request->address;
        $order->province_id = $request->province_id;
        $order->city_id = $request->city_id;
        $order->postal_code = $request->postal_code;
        $order->email = $request->email;
        $order->company_name = $request->company_name;
        $order->arrival_date = resetDate($request->arrival_date);
        $order->departure_date = resetDate($request->departure_date);
        $order->number_of_nights = $numberOfNights;
        $order->rooms = $listRoom;
        $order->price = $price;
        $order->number_of_adults = $request->number_of_adults;
        $order->package_id = $request->package_id;
        $order->package_price = $packagePrice ?? 0;
        $order->package_total = $request->package_total;
        $order->extra_bed = $request->extra_bed;
        $order->extra_bed_price = $extraBedPrice ?? 0;
        $order->note = $request->note;
        $order->discount = $request->discount;
        $order->discount_price = $discountPrice ?? 0;
        $order->fix_price = $fixPrice;
        $order->payment_method = $request->payment_method;
        $order->payment_detail = $request->payment_detail;
        $order->status = $request->status;
        $order->company_emergency_name = $request->company_emergency_name;
        $order->company_phone = $request->company_phone;
        $order->company_accomodation = $request->company_accomodation;
        $order->nationality_id = $request->nationality_id;
        $order->save();

        Alert::success('Success', 'Data Pemesanan berhasil disimpan');

        return redirect()->route('transactions.orders.index', ['filterHotel' => $request->hotel_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = HotelOrder::find($id);
        //RESET ROOM
        if(str_contains($order->rooms, ',')) {
            $rooms = explode(',', $order->rooms);
            foreach ($rooms as $key => $value) {
                $room = Room::find($value);
                $room->status_id = $this->getParameter('AVL');
                $room->save();
            }
        }else{
            $room = Room::find($order->rooms);
            $room->status_id = $this->getParameter('AVL');
            $room->save();
        }
        //DELETE ORDER
        $order->delete();

        Alert::success('Success', 'Data Pemesanan berhasil dihapus');

        return redirect()->back();
    }

    public function subMasters($id)
    {
        $cities = DB::table("app_masters")
            ->where("parent_id",$id)
            ->pluck("name","id");

        return json_encode($cities);
    }

    public function getAvailableRooms($hotelId, $startDate, $endDate, $id = ''){

        $rooms = DB::table('master_rooms as t1')->join('app_masters as t2', function ($join){
            $join->on('t1.type_id', 't2.id');
        })
            ->leftJoin('transaction_hotel_orders as t3', function ($join) use ($startDate, $endDate){
                $join->whereRaw('FIND_IN_SET(t1.id, t3.rooms)');
                $join->whereRaw("(arrival_date >= '".$startDate."' AND arrival_date <= '".$endDate."' 
                OR departure_date >= '".$startDate."' AND departure_date <= '".$endDate."'
                OR 
                '".$startDate."' BETWEEN arrival_date AND departure_date
                OR 
                '".$endDate."' BETWEEN arrival_date AND departure_date
                )");
            })
            ->select('t1.number', 't1.id', 't2.name')
            ->where('t1.hotel_id', $hotelId);
        if($id){
            $rooms = $rooms->whereRaw("(t3.id IS NULL OR t3.id = $id)");
        }else{
            $rooms = $rooms->where('t3.id', NULL);
        }
        $rooms = $rooms->get();

        foreach ($rooms as $key => $value){
            $listRooms[$value->name][$value->id] = $value->number;
        }

        return $listRooms;
    }

    public function getRoomPrices($hotelId, $listId){
        $arrList = explode(',', $listId);
        $rooms = DB::table('master_rooms as t1')->join('master_room_prices as t2', function ($join) use ($hotelId){
            $join->on('t1.type_id', 't2.type_id');
            $join->on('t2.hotel_id', DB::raw($hotelId));
        })
            ->whereIn('t1.id', $arrList)
            ->select('t1.id', 't2.price')
            ->pluck('t2.price', 't1.id')
            ->toArray();

        $totalHarga = array_sum($rooms);

        return $totalHarga;
    }

    public function getPackagePrices($id){
        $package = RoomPackage::find($id);

        return $package->price;
    }

    public function getExtraBedPrice($id){
        $extraBed = RoomAdditional::where('hotel_id', $id)
            ->where('name', 'Extra Bed')
            ->first();

        return $extraBed->price;
    }

    public function printBilling($id){
        $data['order'] = HotelOrder::find($id); // GET ORDER DETAIL
        $data['hotel'] = Hotel::find($data['order']->hotel_id);
        $getLastNumber = HotelOrder::orderBy('folio_number', 'desc')
                ->pluck('folio_number')
                ->first() ?? 0;
        $lastNumber = $data['order']->folio_number ?? Str::padLeft(intval(Str::substr($getLastNumber,0,5)) + 1, '5', '0');
        $data['order']->folio_number = $lastNumber;
        $data['order']->save(); //SET FOLIO NUMBER

        //GET DETAIL PACKAGE IF EXIST
        $detailPackage = RoomPackage::find($data['order']->package_id) ?? NULL;

        $listRooms = $data['order']->rooms;

        $queryRooms = DB::table('master_rooms as t1')
            ->select('t1.number', 't1.id', 't2.name', 't3.price')
            ->join('app_masters as t2', 't1.type_id', 't2.id')
            ->join('master_room_prices as t3', function ($join){
                $join->on('t1.type_id', 't3.type_id');
                $join->on('t1.hotel_id', 't3.hotel_id');
            })
            ->whereRaw('t1.id IN ('.$listRooms.')')
            ->get()
            ->toArray(); // GET ALL ROOM DETAIL

        foreach ($queryRooms as $key => $value){
            $listNumber[] = $value->number;
            $listTypes[] = $value->name;
            $detailRooms[$value->id]['number'] = $value->number;
            $detailRooms[$value->id]['price'] = $value->price;
        }

        $data['order']->roomNumbers = implode(', ', $listNumber);
        $data['order']->roomTypes = implode(', ', $listTypes);

        $period = CarbonPeriod::create($data['order']->arrival_date, $data['order']->departure_date);
        $lastPeriod = count($period); //GET TOTAL DATE

        $no = 0;
        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            $i= 0;
            $no++;
            if($no != $lastPeriod) { // SET LOOP EXCEPT LAST DAY, BECAUSE LAST DAY IS WHEN CUSTOMER CHECKOUT
                foreach ($detailRooms as $key => $value) { // SET VALUE BILLING FOR ROOM
                    $i++;
                    $data['listOrders'][$tanggal][$i]['transaction'] = 'Room Transient Charge';
                    $data['listOrders'][$tanggal][$i]['remark'] = 'Room Charge';
                    $data['listOrders'][$tanggal][$i]['number'] = $value['number'];
                    $data['listOrders'][$tanggal][$i]['debit'] = $value['price'];
                    $data['listOrders'][$tanggal][$i]['credit'] = '';

                    if($data['order']->discount != NULL) {
                        $i++;
                        $data['listOrders'][$tanggal][$i]['transaction'] = 'Discount';
                        $data['listOrders'][$tanggal][$i]['remark'] = 'Room Discount';
                        $data['listOrders'][$tanggal][$i]['number'] = $data['order']->discount.'%';
                        $data['listOrders'][$tanggal][$i]['debit'] = '';
                        $data['listOrders'][$tanggal][$i]['credit'] = $value['price'] * $data['order']->discount / 100;
                    }
                }

                //SET VALUE BILLING FOR EXTRA BED
                if($data['order']->extra_bed != NULL) {
                    $i++;
                    $data['listOrders'][$tanggal][$i]['transaction'] = 'Extra Bed';
                    $data['listOrders'][$tanggal][$i]['remark'] = 'Extra Bed Charge';
                    $data['listOrders'][$tanggal][$i]['number'] = $data['order']->extra_bed;
                    $data['listOrders'][$tanggal][$i]['debit'] = $data['order']->extra_bed_price / $data['order']->number_of_nights;
                    $data['listOrders'][$tanggal][$i]['credit'] = '';
                }

                //SET VALUE BILLING FOR PACKAGE
                if($detailPackage != NULL){
                    $i++;
                    $data['listOrders'][$tanggal][$i]['transaction'] = 'Room Package';
                    $data['listOrders'][$tanggal][$i]['remark'] = $detailPackage->name.' Charge';
                    $data['listOrders'][$tanggal][$i]['number'] = $data['order']->package_total;
                    $data['listOrders'][$tanggal][$i]['debit'] = $data['order']->package_price / $data['order']->number_of_nights;
                    $data['listOrders'][$tanggal][$i]['credit'] = '';
                }

            }
        }

        $pdf = PDF::loadView('transactions.orders.billing', $data);

        return $pdf->stream();
    }
}
