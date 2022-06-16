@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter ?? '' }}" placeholder="Cari .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <x-form.datepicker class="col-md-10 mr-1" name="filterDate" value="{{ $filterDate }}" />
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('masters.room-packages.create', $filterHotel) }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Paket</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="20%">Room</th>
                    <th width="10%">Nomor HP</th>
                    <th style="text-align: center" width="15%">Tgl Keluar</th>
                    <th width="10%">Harga</th>
                    <th style="text-align: center" width="15%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$orders->isEmpty())
                    @foreach($orders as $key => $r)
                        @php
                            if(str_contains($r->rooms, ',')){
                                $rooms = explode(',',$r->rooms);
                                foreach ($rooms as $k => $v){
                                    $listRoom[] = $arrRoom[trim($v)];
                                }
                                $rooms = implode(', ', $listRoom);
                            }else{
                                $rooms = $arrRoom[$r->rooms];
                            }
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $rooms }}</td>
                            <td>{{ $r->phone_number }}</td>
                            <td align="center">{{ setDate($r->departure_date) }}</td>
                            <td align="right">{{ setCurrency($r->fix_price) }}</td>
                            <td align="center">
                                <a href="{{ route('transactions.orders.printBilling', $r->id) }}" class="btn btn-icon btn-info" target="_blank"><i data-feather="printer"></i></a>
                                <a href="{{ route('transactions.orders.edit', ['hotelId' => $r->hotel_id,$r->id]) }}" target="_blank" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            {{ generatePagination($orders) }}
        </div>
    </div>
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
