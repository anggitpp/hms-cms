@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            &nbsp;
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($package) ? route('masters.room-additionals.store', $id) : route('masters.room-additionals.update', $package->id) }}">
                @csrf
                @if(!empty($package))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Harga</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama Hotel" name="hotel_name" readonly value="{{ $hotel->name ?? '' }}"/>
                        <x-form.input label="Nama Paket" required name="name" value="{{ $package->name ?? '' }}"/>
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $package->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode Hotel" name="hotel_code" readonly value="{{ $hotel->code ?? '' }}"/>
                        <x-form.input label="Harga" class="col-md-4" currency name="price" required value="{{ $package->price ?? 0 }}"/>
                        <x-form.input label="Deskripsi" name="description" value="{{ $package->description ?? '' }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection