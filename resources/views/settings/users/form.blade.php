<div class="alert alert-danger" style="display:none"></div>
<form id="form-edit" method="POST"
      action="{{ empty($user) ? route('settings.users.store') : route('settings.users.update', $user->id) }}
          " enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($user))
        @method('PATCH')
    @endif
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: 1px solid; color: #DFDFDF;">
        <li class="nav-item">
            <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" aria-controls="user" role="tab" aria-selected="true">Data User</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="hotel-tab" data-toggle="tab" href="#hotel" aria-controls="hotel" role="tab" aria-selected="true">Akses User</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="user" aria-labelledby="user-tab" role="tabpanel">
            <input type="hidden" id="id" value="{{ $user->id ?? '' }}"/>
            <x-form.input label="Username" nospacing name="username" placeholder="Username" value="{{ $user->username ?? '' }}" />
            <x-form.select label="Pegawai" name="employee_id" :datas="$employees" options="- Pilih Pegawai -" value="{{ $user->employee_id ?? '' }}"/>
            <x-form.input label="Name" name="name" id="name" placeholder="Name" value="{{ $user->name ?? '' }}" />
            <x-form.input label="Phone Number" name="phone_number" placeholder="Phone Number" numeric value="{{ $user->phone_number ?? '' }}" />
            <x-form.select label="Group" name="group_id" options="- Select Group -" :datas="$groups" value="{{ $user->group_id ?? '' }}" />
            @if(empty($user))
                <x-form.input label="Password" name="password" placeholder="*******" password />
                <x-form.input label="Confirm Password" name="confirm-password" placeholder="*******" password />
            @endif
            <x-form.textarea label="Description" name="description" value="{{ $user->description ?? '' }}"/>
            <x-form.file label="Picture" name="picture" value="{{ $user->picture ?? '' }}"/>
            <x-form.radio label="Status" name="status" :datas="$status" value="{{ $user->status ?? '' }}"/>
        </div>
        <div class="tab-pane" id="hotel" aria-labelledby="hotel-tab" role="tabpanel">
            <table class="table table-striped table-borderless">
                <thead class="thead-light">
                <tr>
                    <th>Hotel</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($hotels as $key => $hotel)
                    @php
                        $checked = "";
                        if(!empty($user->hotel_access)){
                            if(in_array($hotel->id,$selectedHotels))
                                $checked = "checked";
                        }
                    @endphp
                    <tr>
                        <td>{{ $hotel->name }}</td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="{{ $hotel->id }}" name="hotels[{{ $hotel->id }}]" id="hotels[{{ $hotel->id }}]"
                                        {!! $checked !!}
                                />
                                <label class="custom-control-label" for="hotels[{{ $hotel->id }}]"></label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
    </div>
</form>
<br/>
<script>
    $('#employee_id').change(function (){  // GET PACKAGE ROOM + TOTAL PACKAGE
        $.ajax({
            url: '/settings/users/getEmployeeDetail/' + this.value,
            method: "get",
            dataType: "json",
            success: function (data) {
                $('#name').val(data['name']);
                $('#phone_number').val(data['phone_number'] ?? '');
            },
        });
    });
</script>
