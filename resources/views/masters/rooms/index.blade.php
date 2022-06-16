@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <x-form.select name="filterTipe" class="mr-1" :datas="$masters['MTK']" value="{{ $filterTipe }}" options="- Pilih Tipe Kamar -" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('masters.rooms.create', $filterHotel) }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Kamar</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nomor</th>
                    <th width="15%">Tipe</th>
                    <th width="*">Keterangan</th>
                    <th width="18%">Status</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$rooms->isEmpty())
                    @foreach($rooms as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->number }}</td>
                            <td>{{ $masters['MTK'][$r->type_id] ?? '' }}</td>
                            <td>{{ $r->description }}</td>
                            <td>{{ $masters['MSK'][$r->status_id] ?? '' }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('masters.rooms.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('masters.rooms.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($rooms) }}
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
