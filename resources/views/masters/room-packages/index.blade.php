@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter ?? '' }}" placeholder="Cari .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
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
                    <th width="15%">Nama Paket</th>
                    <th width="10%">Harga</th>
                    <th width="*">Keterangan</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$packages->isEmpty())
                    @foreach($packages as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td align="right">{{ setCurrency($r->price) ?? '' }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('masters.room-packages.edit', [$r->id, $filterHotel]) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('masters.room-packages.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
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
            {{ generatePagination($packages) }}
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
