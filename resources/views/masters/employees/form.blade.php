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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($emp) ? route('masters.employees.store', $id) : route('masters.employees.update', $emp->id) }}">
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
                        <x-form.select label="Tempat Lahir" required name="birth_place" :datas="$cities" options="- Pilih Tempat Lahir -" value="{{ $emp->birth_place ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="NIK Pegawai" name="employee_number" required value="{{ $emp->employee_number ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Lahir" name="birth_date" value="{{ $emp->birth_date ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.radio label="Jenis Kelamin" name="gender" :datas="$gender" value="{{ $emp->gender ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Agama" name="religion_id" :datas="$masters['SAG']" options="- Pilih Agama -" value="{{ $emp->religion_id ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Hotel" name="hotel_id" required :datas="$hotels" options="- Pilih Hotel -" value="{{ $emp->hotel_id ?? $id }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Posisi" name="position_id" required :datas="$masters['MPP']" options="- Pilih Posisi -" value="{{ $emp->position_id ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor HP" name="phone_number" maxlength="15" value="{{ $emp->phone_number ?? '' }}"/>
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $emp->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.file label="Foto" imageOnly name="photo" value="{{ $emp->photo ?? '' }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection