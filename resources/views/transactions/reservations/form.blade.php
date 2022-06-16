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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($emp) ? route('transactions.orders.store') : route('masters.orders.update', $emp->id) }}">
                @csrf
                @if(!empty($emp))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Pegawai</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="name" required value="{{ $emp->name ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Masuk" required name="arrival_date" value="{{ $emp->arrival_date }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Nomor Identitas" name="identity_number" required value="{{ $emp->identity_number ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Keluar" required name="arrival_date" value="{{ $emp->arrival_date }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.textarea label="Alamat" name="address" value="{{ $emp->address ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode Pos" name="postal_code" required value="{{ $emp->postal_code ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Provinsi" name="province_id" :datas="$masters['MPP']" options="- Pilih Provinsi -" value="{{ $emp->province_id ?? '' }}" />
                        <x-form.input label="Nomor HP" name="phone_number" required value="{{ $emp->phone_number ?? '' }}"/>
                        <x-form.input label="Total Hari" name="number_of_nights" readonly value="{{ $emp->number_of_nights ?? '' }}"/>
                        <x-form.select label="Kamar (Pilih 1 atau lebih)" name="rooms" :datas="$masters['MPP']" options="- Pilih Kamar -" value="{{ $emp->rooms ?? '' }}" />
                        <x-form.input label="Harga" name="price" readonly value="{{ $emp->price ?? '' }}"/>
                        <x-form.select label="Paket Tersedia" name="package_id" :datas="$masters['MPP']" options="- Pilih Paket -" value="{{ $emp->package_id ?? '' }}" />
                        <x-form.input label="Diskon (%)" name="discount" readonly value="{{ $emp->discount ?? '' }}"/>
                        <x-form.input label="Total Harga" name="fix_price" readonly value="{{ $emp->fix_price ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Kota" name="position_id" :datas="$masters['MPP']" options="- Pilih Posisi -" value="{{ $emp->position_id ?? '' }}" />
                        <x-form.input label="Email" name="email" value="{{ $emp->email ?? '' }}"/>
                        <x-form.input label="Jumlah Orang Dewasa" name="number_of_adults" readonly value="{{ $emp->number_of_adults ?? '' }}"/>
                        <x-form.input label="Harga" name="price" readonly value="{{ $emp->price ?? '' }}"/>
                        <x-form.input label="Extra Bed" name="extra_bed" readonly value="{{ $emp->extra_bed ?? '' }}"/>
                        <x-form.input label="Diskon (Rp)" name="discount_price" readonly value="{{ $emp->discount_price ?? '' }}"/>
                        <x-form.textarea label="Keterangan / Request" name="note" value="{{ $emp->note ?? '' }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection