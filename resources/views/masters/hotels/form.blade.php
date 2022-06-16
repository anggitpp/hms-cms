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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($hotel) ? route('masters.hotels.store') : route('masters.hotels.update', $hotel->id) }}">
                @csrf
                @if(!empty($hotel))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Hotel</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="name" required placeholder="Nama" value="{{ $hotel->name ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode" required name="code" class="col-md-2" readonly value="{{ $hotel->code ?? $lastCode }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.textarea label="Alamat" name="address" value="{{ $hotel->address ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Tipe" required name="type_id" :datas="$masters['MTH']" options="- Pilih Tipe -" value="{{ $hotel->type_id ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Provinsi" name="province_id" :datas="$masters['SPV']" event="getSub(this.value, 'city_id');" options="- Pilih Provinsi -" value="{{ $hotel->province_id ?? '' }}"/>
                        <x-form.input label="No. Telp" name="phone_number" placeholder="No. Telp" value="{{ $hotel->phone_number ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Kota" name="city_id" :datas="$masters['SKT']" options="- Pilih Kota -" value="{{ $hotel->city_id ?? '' }}"/>
                        <x-form.input label="Email" name="email" placeholder="Email" value="{{ $hotel->email ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.textarea label="Deskripsi" name="description" value="{{ $hotel->description ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode Pos" numeric name="postal_code" placeholder="Kode Pos" class="col-md-2" value="{{ $hotel->postal_code ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.file label="Foto" imageOnly name="photo" value="{{ $hotel->photo ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $hotel->status ?? '' }}" />
                    </div>
                </div>
                <br/>
                <div class="card-title">
                    <h5>Lokasi Hotel</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <div class="leaflet-map" id="hotel-map"></div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Latitude" onkeyup="setMap();" name="latitude" placeholder="Nama" value="{{ $hotel->latitude ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Longitude" onkeyup="setMap();" name="longitude" placeholder="Nama" value="{{ $hotel->longitude ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
    if ($('#hotel-map').length) {
        var map = L.map('hotel-map').setView([{{ $hotel->latitude ?? $defaultLatitude }}, {{ $hotel->longitude ?? $defaultLongitude }}], 15);
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 18
        }).addTo(map);

        function setMap(){
            lat = document.getElementById('latitude').value;
            lon = document.getElementById('longitude').value;
            marker.setLatLng([lat, lon]);
        }

        map.on('click', function(e) {
            var popLocation= e.latlng;
            marker.setLatLng([e.latlng.lat, e.latlng.lng]);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        var lat = {{ $hotel->latitude ?? $defaultLatitude }};
        var lon = {{ $hotel->longitude ?? $defaultLongitude }};
        var marker;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
        marker = L.marker([lat, lon], {draggable: true}).addTo(map);

        var onDrag = function (e) {
            var latlng = marker.getLatLng();
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        };

        marker.on('drag', onDrag);


    }
</script>
@endsection
