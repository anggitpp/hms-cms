@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            &nbsp;
            <div>
                @if(empty($order) || $order->status != 'c')
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($order) ? route('transactions.orders.store') : route('transactions.orders.update', $order->id) }}">
                @csrf
                @if(!empty($order))
                    @method('PATCH')
                    @if($order->payment_method == 'm' || $order->payment_method == 'v')
                        @php
                            $displayCompany = 'block';
                        @endphp
                    @endif
                @endif
                <div class="card-title">
                    <h5>Data Tamu</h5>
                    <hr>
                </div>
                <input type="hidden" name="hotel_id" value="{{ $order->hotel_id ?? $_GET['hotelId'] }}">
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Nama Lengkap" name="name" required value="{{ $order->name ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Nomor Identitas" name="identity_number" required value="{{ $order->identity_number ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Nomor HP" name="phone_number" required numeric value="{{ $order->phone_number ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.textarea label="Alamat" name="address" value="{{ $order->address ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.select label="Provinsi" name="province_id" :datas="$masters['SPV']" event="getSub(this.value, 'city_id');" options="- Pilih Provinsi -" value="{{ $order->province_id ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.select label="Kota" name="city_id" :datas="$masters['SKT']" options="- Pilih Kota -" value="{{ $order->city_id ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Kode Pos" name="postal_code" numeric value="{{ $order->postal_code ?? '' }}"/>

                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Email" name="email" value="{{ $order->email ?? '' }}"/>

                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Perusahaan" name="company_name" value="{{ $order->company_name ?? '' }}"/>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.textarea label="Keterangan / Request" name="note" value="{{ $order->note ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.select label="Asal Negara" name="nationality_id" :datas="$masters['PAN']" options="- Pilih Asal Negara -" value="{{ $order->nationality_id ?? array_key_first($masters['PAN']) }}" />
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Pemesanan</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.datepicker label="Tanggal Masuk" class="col-md-4" onchange="getAvailableRooms();getTotalHari();" required name="arrival_date" value="{{ $order->arrival_date ?? $defaultSelected['tanggalMasuk'] ?? '' }}" />
                        <x-form.multiple-select label="Kamar (Pilih 1 atau lebih)" required name="rooms" :datas="$rooms ?? []" options="- Pilih Kamar -" value="{{ $order->rooms ?? $selectedRoom ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.datepicker label="Tanggal Keluar" class="col-md-4" onchange="getAvailableRooms();getTotalHari();" required name="departure_date" value="{{ $order->departure_date ?? $defaultSelected['tanggalKeluar'] ?? ''}}" />
                        <x-form.input label="Harga" name="price" currency readonly value="{{ $order->price ?? $defaultSelected['harga'] ?? 0 }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Total Hari" class="col-md-3" onchange="getTotalHarga();" name="number_of_nights" readonly value="{{ $order->number_of_nights ?? $defaultSelected['totalHari'] ?? '' }}"/>
                        <x-form.input label="Jumlah Orang Dewasa" class="col-md-3" numeric required name="number_of_adults" value="{{ $order->number_of_adults ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Diskon (%)" class="col-md-4" style="text-align: right" onkeyup="setNumber(this);" name="discount" value="{{ $order->discount ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Diskon (Rp)" name="discount_price" style="text-align: right" currency value="{{ $order->discount_price ?? 0 }}"/>
                        <input type="hidden" id="package_price" name="package_price" value="{{ $order->package_price ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Extra Bed (@ {{ setCurrency($order->extra_bed_piece_price ?? $extraBedPrice ?? 85000) }})" onkeyup="getTotalHarga();setNumber(this);" name="extra_bed" value="{{ $order->extra_bed ?? '' }}"/>
                        <input type="hidden" id="extra_bed_price" name="extra_bed_price" value="{{ $order->extra_bed_price ?? '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.select label="Paket Tersedia" name="package_id" :datas="$packages" options="- Pilih Paket -" value="{{ $order->package_id ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Jumlah Paket" class="col-md-4" numeric name="package_total" value="{{ $order->package_total ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Total Harga" name="fix_price" currency readonly value="{{ $order->fix_price ?? $defaultSelected['totalHarga'] ?? 0 }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.radio label="Metode Pembayaran" name="payment_method" event="setCompany();" :datas="$paymentOption" value="{{ $order->payment_method ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Detail Pembayaran" name="payment_detail" value="{{ $order->payment_detail ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $order->status ?? '' }}"/>
                    </div>
                </div>
                <div id="companySection" style="display: {{ $displayCompany ?? 'none' }}">
                    <div class="card-title">
                        <h5>Data Billing Company/Voucher</h5>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input label="Nama" name="company_emergency_name" value="{{ $order->company_emergency_name ?? '' }}"/>
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Nomor HP" numeric name="company_phone" value="{{ $order->company_phone ?? '' }}"/>
                        </div>
                        <div class="col-md-4">
                            <x-form.radio label="Akomodasi" name="company_accomodation" :datas="$accomodation" value="{{ $order->accomodation ?? '' }}"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function getTotalHari() {
            var tanggalMulai = $('#arrival_date').val();
            var tanggalSelesai = $('#departure_date').val();

            if(tanggalMulai != '' && tanggalSelesai != '') {
                var mulai = moment(tanggalMulai, "DD/MM/YYYY");
                var selesai = moment(tanggalSelesai, "DD/MM/YYYY");

                var totalHari = selesai.diff(mulai, 'days');

                if(totalHari <= 0){
                    alert('tanggal selesai harus lebih besar dari tanggal mulai');
                    $('#departure_date').val('');
                }

                $('#number_of_nights').val(totalHari);
                if($('#price').val() != '') {
                    $('#rooms').trigger('change');
                    $('#extra_bed').trigger('keyup');
                    $('#package_total').trigger('keyup');
                }
            }
        }

        function getAvailableRooms(){
            arrMulai = $('#arrival_date').val().split('/');
            arrSelesai = $('#departure_date').val().split('/');

            var tanggalMulai = arrMulai[2] + "-" + arrMulai[1] + "-" + arrMulai[0];
            var tanggalSelesai = arrSelesai[2] + "-" + arrSelesai[1] + "-" + arrSelesai[0];

            var url_string = '{{ Request::fullUrl() }}';
            var url = new URL(url_string);
            var hotelId = url.searchParams.get("hotelId");
            var id = '{{ request()->id }}';
            if($('#arrival_date').val() != '' && $('#departure_date').val() != ''){
                $.ajax({
                    url: id == '' || id == 'undefined' ? '/transactions/orders/getAvailableRooms/' + hotelId + '/' + tanggalMulai + '/' + tanggalSelesai : '/transactions/orders/getAvailableRooms/' + hotelId + '/' + tanggalMulai + '/' + tanggalSelesai + '/' + id,
                    method: "get",
                    success: function (data) {
                        $('select[name=rooms\\[\\]]').empty();
                        $('select[name=rooms\\[\\]]').append('<option value=""> - Pilih Kamar -</option>');
                        $.each(data, function (key, values) {
                            // $('select[name=rooms\\[\\]]').append('<optgroup label="'+ key +'">');
                            var optgroup = $("<optgroup>").prop("label", key);
                            $.each(values, function (k, value) {
                                    optgroup.append('<option value="' + k + '">' + value + '</option>');
                                });
                            $('select[name=rooms\\[\\]]').append(optgroup);
                        });
                        $('#price').val('');
                        $('#fix_price').val('');
                    },
                });
            }
        }

        function getTotalHarga(){
            price = $('#price').val();
            price = price.replaceAll(',',''); // GET PRICE AFTER BEING NUMERIC INSTEAD OF CURRENCY
            totalPrice = parseInt(price);
            discountPrice = $('#discount_price').val();
            discountPrice = discountPrice.replaceAll(',',''); // GET PRICE AFTER BEING NUMERIC INSTEAD OF CURRENCY
            if(discountPrice != '' || discountPrice != 0){
                totalPrice -= parseInt(discountPrice);
            }
            packagePrice = $('#package_price').val(); // GET TOTAL PRICE PACKAGE
            if(packagePrice != ''){
                totalPrice += parseInt(packagePrice);
            }
            extraBedPrice = $('#extra_bed_price').val(); // GET TOTAL PRICE PACKAGE
            if(extraBedPrice != ''){
                totalPrice += parseInt(extraBedPrice);
            }
            fixPrice = parseInt(totalPrice).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}) ?? 0;
            $('#fix_price').val(fixPrice);
        }

        $('#rooms').change(function (){ // GET PRICE ROOM + DAYS
            var url_string = '{{ Request::fullUrl() }}';
            var url = new URL(url_string);
            var hotelId = url.searchParams.get("hotelId");
            if($('#rooms').val() != ''){
                $.ajax({
                    url: '/transactions/orders/getRoomPrices/' + hotelId + '/' + $('#rooms').val(),
                    method: "get",
                    success: function (data) {
                        totalDays = $('#number_of_nights').val();
                        priceAfterDays = parseInt(totalDays ?? 1) * data;
                        price = parseInt(priceAfterDays).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
                        $('#price').val(price);
                        getTotalHarga();
                        $('#discount').trigger('keyup');
                    },
                });
            }
        });

        $('#package_total').keyup(function (){ // GET PACKAGE ROOM + TOTAL PACKAGE
            total = this.value;
            if($('#package_id').val() != '') {
                $.ajax({
                    url: '/transactions/orders/getPackagePrices/' + $('#package_id').val(),
                    method: "get",
                    success: function (data) {
                        totalHari = $('#number_of_nights').val();
                        $('#package_price').val(data * total * totalHari);
                        getTotalHarga();
                    },
                });
            }
        });

        $('#extra_bed').keyup(function (){  // GET PACKAGE ROOM + TOTAL PACKAGE
            extraBed = this.value;
            var url_string = '{{ Request::fullUrl() }}';
            var url = new URL(url_string);
            var hotelId = url.searchParams.get("hotelId");
            $.ajax({
                url: '/transactions/orders/getExtraBedPrice/' + hotelId,
                method: "get",
                success: function (data) {
                    totalHari = $('#number_of_nights').val();
                    extraBedPrice = parseInt(data * extraBed * totalHari);
                    $('#extra_bed_price').val(extraBedPrice);
                    getTotalHarga();
                },
            });
        });

        $('#discount').keyup(function (){  // GET ROOM DISCOUNT
            price = $('#price').val();
            price = price.replaceAll(',','');
            discountPrice = parseInt(price) * parseInt(this.value) / 100;
            discountPrice = discountPrice ? parseInt(discountPrice).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0}) : '';
            $('#discount_price').val(discountPrice);
            getTotalHarga();
        });

        $('#discount_price').keyup(function (){  // GET ROOM DISCOUNT
            price = $('#price').val();
            price = price.replaceAll(',','');
            discountPrice = $('#discount_price').val();
            discountPrice = discountPrice.replaceAll(',','');

            discount = parseInt(discountPrice) / parseInt(price) * 100;
            discount = $('#discount').val(discount);
            getTotalHarga();
            // $('#discount').trigger('keyup');
        });

        function setCompany(){
            val = document.querySelector('input[name="payment_method"]:checked').value;
            divCompany = document.getElementById('companySection');
            if(val == 'v' || val == 'm'){
                divCompany.style.display = 'block';
            }else{
                divCompany.style.display = 'none';
            }
        }
        $("#rooms").select2({matcher: modelMatcher});
    </script>
@endsection