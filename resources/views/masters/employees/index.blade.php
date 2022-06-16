@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('masters.employees.create', $filterHotel) }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Pegawai</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Name</th>
                    <th width="10%">NIK</th>
                    <th width="20%">Hotel</th>
                    <th width="15%">Position</th>
                    <th width="10%">Status</th>
                    <th style="text-align: center" width="10%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$employees->isEmpty())
                    @foreach($employees as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->employee_number }}</td>
                            <td>{{ $hotels[$r->hotel_id] }}</td>
                            <td>{{ $masters['MPP'][$r->position_id] }}</td>
                            <td>
                                <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('masters.employees.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('masters.employees.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($employees) }}
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
