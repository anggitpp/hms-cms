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
            <a href="{{ route('reports.daily-occupancy.exportExcel', ['filter' => $filter, 'filterHotel' => $filterHotel, 'filterDate' => $filterDate]) }}" class="btn btn-success"><i data-feather='file'></i> Export Data</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Room Number</th>
                        <th style="text-align: center" width="20%">Check In Date</th>
                        <th style="text-align: center" width="20%">Check Out Date</th>
                        <th width="*">Remark</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $totalOccupied = 0;
                @endphp
                @if(!$orders->isEmpty())
                    @foreach($orders as $key => $r)
                        @php
                            $totalOccupied++;
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->number }}</td>
                            <td align="center">{{ setDate($r->arrival_date, 't') }}</td>
                            <td align="center">{{ setDate($r->departure_date, 't') }}</td>
                            <td>{{ $r->note }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                @php
                    $occupancy = 0;
                    if($totalOccupied > 0)
                        $occupancy = $totalOccupied / $totalAvailable * 100;
                @endphp
                <tfoot>
                    <tr>
                        <td colspan="4" align="right"><b><i>Room Occupancy (%)</i></b></td>
                        <td><b>{{ floor($occupancy) }} %</b></td>
                    </tr>
                </tfoot>
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
