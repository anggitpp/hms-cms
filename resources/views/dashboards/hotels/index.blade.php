@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <span style="font-size: 15px; margin-left: 10px;"><i>{{ $totalAvailable }} of {{ $totalRoom }} Room Available</i></span>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($rooms as $key => $r)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <a href="{{ route('masters.hotels.index') }}">
                        <div class="card text-center badge-{{ $arrStatus[$r->status_id] ?? 'success' }}" style="height: 135px;">
                            <div class="card-body">
                                <h1 class="fw-bolder" style="font-size: 50px; color: white">{{ $r->number }}</h1>
                                @if($r->status_id == $arr_parameter['OOF'] || $r->status_id == $arr_parameter['TOOF'])
                                    <h1 class="fw-bolder" style="font-size: 13px; color: white">{{ $masters['MSK'][$r->status_id] }}</h1>
                                    <h1 class="fw-bolder" style="font-size: 13px; color: white">{{ $r->inactive_reason }}</h1>
                                @else
                                    <h1 class="fw-bolder" style="font-size: 15px; color: white">{{ $masters['MSK'][$r->status_id] }}</h1>
                                @endif
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
{{--                <div class="col-xl-3 col-md-4 col-sm-6">--}}
{{--                    <div class="card text-center badge-warning" style="height: 135px;">--}}
{{--                        <div class="card-body">--}}
{{--                            <h1 class="fw-bolder" style="font-size: 50px; color: white">007</h1>--}}
{{--                            <h1 class="fw-bolder" style="font-size: 13px; color: white; text-align: center;">Ardy</h1>--}}
{{--                            <h1 class="fw-bolder" style="font-size: 13px; color: white; text-align: center;">2 Adults - 21/10/2021</h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-md-4 col-sm-6">--}}
{{--                    <div class="card text-center badge-danger" style="height: 135px;">--}}
{{--                        <div class="card-body">--}}
{{--                            <h1 class="fw-bolder" style="font-size: 50px; color: white">008</h1>--}}
{{--                            <h1 class="fw-bolder" style="font-size: 13px; color: white">Out of Order</h1>--}}
{{--                            <h1 class="fw-bolder" style="font-size: 13px; color: white">Perbaikan pada tempat tidur</h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
