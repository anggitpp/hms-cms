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
            <a href="{{ route('reports.daily-average-rate.exportExcel', ['filter' => $filter, 'filterHotel' => $filterHotel, 'filterDate' => $filterDate]) }}" class="btn btn-success"><i data-feather='file'></i> Export Data</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Room Number</th>
                    <th style="text-align: right" width="25%">Room Rate</th>
                    <th style="text-align: right" width="15%">Discount (%)</th>
                    <th style="text-align: right" width="25%">Revenue</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $totalRevenue = 0;
                    $no = 0;
                    $averageRoomRate = 0;
                @endphp
                @if(!$orders->isEmpty())
                    @foreach($orders as $key => $r)
                        @php
                            $revenue = $r->price;
                            if($r->discount > 0)
                                $revenue = $r->price - ($r->price * $r->discount / 100);
                            $totalRevenue += $revenue;
                            $no++;
                        @endphp
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->number }}</td>
                            <td align="right">{{ setCurrency($r->price) }}</td>
                            <td align="right">{{ $r->discount }}</td>
                            <td align="right">{{ setCurrency($revenue) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                @php
                    if($no > 0)
                        $averageRoomRate = $totalRevenue / $no;
                @endphp
                <tfoot>
                    <tr>
                        <td colspan="4" align="right"><b><i>Average Room Rate</i></b></td>
                        <td align="right"><b>{{ setCurrency($averageRoomRate) }}</b></td>
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
