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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('masters.room-prices.update', [$master->id, $hotel->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-title">
                    <h5>Data Harga</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="hotel_name" readonly value="{{ $hotel->name ?? '' }}"/>
                        <x-form.input label="Tipe" name="master_name" readonly value="{{ $master->name ?? '' }}"/>
                        <x-form.input label="Harga" class="col-md-4" currency name="price" required value="{{ $price->price ?? 0 }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode" name="hotel_code" readonly value="{{ $hotel->code ?? '' }}"/>
                        <x-form.input label="Keterangan" name="master_description" readonly value="{{ $master->description ?? '' }}"/>
                        <x-form.input label="Deskripsi" name="description" value="{{ $price->description ?? '' }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection