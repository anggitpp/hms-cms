@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <x-form.datepicker class="col-md-10 mr-1" name="filterDate" value="{{ $filterDate }}" />
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <a href="{{ route('reports.room-number.exportExcel', ['filter' => $filter, 'filterHotel' => $filterHotel, 'filterDate' => $filterDate]) }}" class="btn btn-success"><i data-feather='file'></i> Export Data</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th style="min-width: 20px;">No</th>
                    <th style="min-width: 170px;">Room Number</th>
                    <th style="text-align:center;min-width: 200px;">Check In Date</th>
                    <th style="text-align:center;min-width: 200px;">Check Out Date</th>
                    <th style="min-width: 200px;">Number of Pax</th>
                    <th style="min-width: 200px;">Package</th>
                    <th style="min-width: 140px;">Extra Bed</th>
                    <th style="min-width: 300px;">Remark</th>
                </tr>
                </thead>
                <tbody>
                @if(!$orders->isEmpty())
                    @foreach($orders as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->number }}</td>
                            <td align="center">{{ setDate($r->arrival_date) }}</td>
                            <td align="center">{{ setDate($r->departure_date) }}</td>
                            <td>{{ $r->number_of_adults }}</td>
                            <td>{{ $r->package_id ? $arrPackage[$r->package_id] : '' }}</td>
                            <td>{{ $r->extra_bed }}</td>
                            <td>{{ $r->note }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ generatePagination($orders) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
