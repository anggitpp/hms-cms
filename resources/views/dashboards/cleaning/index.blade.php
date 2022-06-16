@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Guest Name / Room Number .."/>
                @if(strlen(Auth::user()->hotel_access) != 1)
                    <x-form.select name="filterHotel" class="mr-1" :datas="$hotels" value="{{ $filterHotel }}" event="document.getElementById('form').submit();"/>
                @endif
                <x-form.select name="filterType" class="mr-1" :datas="$masters['MTK']" value="{{ $filterType }}" options="- Pilih Tipe Kamar -" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <span style="font-size: 15px; margin-left: 10px;"><i>{{ $total }} Rooms Remaining</i></span>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($rooms as $key => $r)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <buton href="{{ route('dashboards.dashboard-cleaning.update', $r->id) }}" class="box-cleaning">
                            <div class="card text-center badge-warning" style="height: 135px;">
                                <div class="card-body">
                                    <h1 class="fw-bolder" style="font-size: 50px; color: white">{{ $r->number }}</h1>
                                    <h1 class="fw-bolder" style="font-size: 15px; color: white">Cleaning</h1>
                                </div>
                            </div>
                        </buton>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <form action="" id="formUpdate" method="POST">
        @csrf
        @method('POST')
        <input type="submit" style="display: none">
    </form>
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $('.box-cleaning').on('click', function (){
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Update this room to Available?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formUpdate').action = link;
                    document.getElementById('formUpdate').submit();
                }

            })
        });
    </script>
@endsection
