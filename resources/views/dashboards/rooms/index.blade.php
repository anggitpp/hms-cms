@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Guest Name / Room Number .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <x-form.select name="filterType" class="mr-1" :datas="$masters['MTK']" value="{{ $filterType }}" options="- Pilih Tipe Kamar -" event="document.getElementById('form').submit();"/>
                <x-form.datepicker class="col-md-10 mr-1" name="filterDate" value="{{ $filterDate }}" />
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <span style="font-size: 15px; margin-left: 10px;"><i>{{ $totalAvailable }} of {{ $totalRoom }} Room Available</i></span>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($rooms as $key => $r)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        @if($r->roomStatus == '')
                            <a href="{{ route('transactions.orders.create', ['hotelId' => $r->hotel_id, 'roomId' => $r->id, 'selectedDate' => $filterDate]) }}">
                        @elseif($r->roomStatus == 's' || $r->roomStatus == 'r')
                            <a href="{{ route('transactions.orders.edit', [$r->idOrder, 'hotelId' => $r->hotel_id]) }}">
                        @endif
                            <div class="card text-center badge-{{ $arrStatus[$r->roomStatus] ?? 'success' }}" style="height: 135px;">
                                <div class="card-body">
                                    <h1 class="fw-bolder" style="font-size: 50px; color: white">{{ $r->number }}</h1>
                                    @if($r->roomStatus == 'o')
                                        <h1 class="fw-bolder" style="font-size: 13px; color: white">{{ 'Out of Order' }}</h1>
                                        <h1 class="fw-bolder" style="font-size: 13px; color: white">{{ $r->inactive_reason }}</h1>
                                    @elseif($r->roomStatus == 's' || $r->roomStatus == 'r')
                                        <h1 class="fw-bolder" style="font-size: 13px; color: white; text-align: center;">{{ $detail[$r->id]['name'] }}</h1>
                                        <h1 class="fw-bolder" style="font-size: 13px; color: white; text-align: center;">{{ $detail[$r->id]['number_of_adults'] }} Adults - {{ setDate($detail[$r->id]['departure_date']) }}</h1>
                                    @elseif($r->roomStatus == 'c')
                                        <h1 class="fw-bolder" style="font-size: 15px; color: white">Cleaning</h1>
                                    @else
                                        <h1 class="fw-bolder" style="font-size: 15px; color: white">Available</h1>
                                    @endif
                                </div>
                            </div>
                        @if($r->roomStatus == '')
                            </a>
                        @elseif($r->roomStatus == 's' || $r->roomStatus == 'r')
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
