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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($room) ? route('masters.rooms.store', $id) : route('masters.rooms.update', $room->id) }}">
                @csrf
                @if(!empty($room))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Hotel</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="hotel_name" readonly value="{{ $hotel->name ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode" name="hotel_kode" class="col-md-2" readonly value="{{ $hotel->code ?? '' }}"/>
                    </div>
                </div>
                <div class="card-title">
                    <h5>Data Kamar</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor" name="number" required value="{{ $room->number ?? '' }}"/>
                        <x-form.textarea label="Deskripsi" name="description" value="{{ $room->description ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Tipe" required name="type_id" :datas="$masters['MTK']" options="- Pilih Tipe -" value="{{ $room->type_id ?? '' }}"/>
                        <x-form.select label="Status" required name="status_id" event="setReason(this.value);" :datas="$masters['MSK']" options="- Pilih Status -" value="{{ $room->status_id ?? '' }}"/>
                    </div>
                </div>
                <div id="reason" style="display: {{ $styleReason ?? 'none' }}">
                    <x-form.textarea label="Alasan" name="inactive_reason" value="{{ $room->inactive_reason ?? '' }}" />
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setReason(val){
            reason = document.getElementById('reason');
            if(val == {{ $arr_parameter['OOF'] }} || val == {{ $arr_parameter['TOOF'] }}){
                reason.style.display = 'block';
            }else{
                reason.style.display = 'none';
            }
        }
    </script>
@endsection