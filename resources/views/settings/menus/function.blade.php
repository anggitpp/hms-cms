@extends('app')
@section('content')
    @php
        $url = '/settings/menus/function/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-end">
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-action="create" data-id="{{ $id }}" data-url="{{ $url }}">
                <i data-feather='plus'></i> Add Function
            </button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Name</th>
                    <th width="10%">Method</th>
                    <th width="5%">Param</th>
                    <th width="10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$accesses->isEmpty())
                    @foreach($accesses as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->method }}</td>
                            <td>{{ $r->param }}</td>
                            <td align="center">
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.menus.function.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Menu"/>
@endsection
