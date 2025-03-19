<div class="form-row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('name', 'Nama') }}
            {{ Form::text('name', null, ['placeholder' => 'Sila Masukkan Nama', 'class' => 'form-control']) }}
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('email', 'Emel') }}
            {{ Form::email('email', null, ['placeholder' => 'Sila Masukkan Emel', 'class' => 'form-control']) }}
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('password', 'Kata Laluan') }}
            {{ Form::password('password', ['placeholder' => 'Sila Masukkan Kata Laluan', 'class' => 'form-control']) }}
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('confirm-password', 'Pengesahan Kata Laluan') }}
            {{ Form::password('confirm-password', ['placeholder' => 'Sila Masukkan Pengesahan Kata Laluan', 'class' => 'form-control']) }}
            @error('confirm-password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <h6 class="font-weight-bold">Peranan</h6>
            @foreach ($roles as $key => $role)
                @if(isset($userRole["Penggiat Industri"]))
                    @if($role == "Penggiat Industri")
                    <div inert class="custom-control custom-checkbox custom-control-inline">
                        {{ Form::checkbox('roles[]', $role, in_array($role, $userRole), ['class' => 'custom-control-input', 'id' => "checkbox-" . $key]) }}
                        <label class="custom-control-label" for="checkbox-{{ $key }}">
                            {{ ucwords(str_replace('-', ' ', $role)) }}
                        </label>
                    </div>
                    @endif
                @elseif(isset($userRole["Pihak Berkuasa Tempatan"]))
                    @if($role == "Pihak Berkuasa Tempatan")
                    <div inert class="custom-control custom-checkbox custom-control-inline">
                        {{ Form::checkbox('roles[]', $role, in_array($role, $userRole), ['class' => 'custom-control-input', 'id' => "checkbox-" . $key]) }}
                        <label class="custom-control-label" for="checkbox-{{ $key }}">
                            {{ ucwords(str_replace('-', ' ', $role)) }}
                        </label>
                    </div>
                    @endif
                @else
                    @if($role != "Pihak Berkuasa Tempatan" && $role != "Penggiat Industri")
                    <div class="custom-control custom-checkbox custom-control-inline">
                        {{ Form::checkbox('roles[]', $role, in_array($role, $userRole), ['class' => 'custom-control-input', 'id' => "checkbox-" . $key]) }}
                        <label class="custom-control-label" for="checkbox-{{ $key }}">
                            {{ ucwords(str_replace('-', ' ', $role)) }}
                        </label>
                    </div>
                    @endif
                @endif
            @endforeach
            @error('roles')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('is_active', 'Status Aktif') }}
            {{ Form::select('is_active', [1 => 'Aktif', 0 => 'Tidak Aktif'], null, ['class' => 'form-control']) }}
            @error('is_active')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if(isset($userRole["Penggiat Industri"]))
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('bahagian_jln', 'Syarikat - Penggiat Industri') }}
            {!! Form::select('bahagian_jln', [], null, ['class' => 'form-control']) !!}
            @error('bahagian_jln')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '/get-penggiat-industri',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#bahagian_jln').empty();
                            $('#bahagian_jln').append('<option value="">Pilih Syarikat</option>');

                            $.each(data, function(key, value) {
                                $('#bahagian_jln').append('<option value="' + value.id_elind + '">' + value.name + '</option>');
                            });
                            var bahagianSelected = "{{ isset($user->bahagian_jln) ? $user->bahagian_jln : '' }}";
                            if (bahagianSelected) {
                                $('#bahagian_jln').val(bahagianSelected);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching Bahagian data: ", error);
                        }
                    });
                });
            </script>
        </div>
    </div>
    @elseif(isset($userRole["Pihak Berkuasa Tempatan"]))
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('bahagian_jln', 'Pihak Berkuasa Tempatan - berdaftar dengan eLANDSKAP') }}
            {!! Form::select('bahagian_jln', [], null, ['class' => 'form-control']) !!}
            @error('bahagian_jln')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '/get-pbt',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#bahagian_jln').empty();
                            $('#bahagian_jln').append('<option value="">Pilih Pihak Berkuasa Tempatan</option>');

                            $.each(data, function(key, value) {
                                $('#bahagian_jln').append('<option value="' + value.id + '">' + value.pbt_name + '</option>');
                            });
                            var bahagianSelected = "{{ isset($user->bahagian_jln) ? $user->bahagian_jln : '' }}";
                            if (bahagianSelected) {
                                $('#bahagian_jln').val(bahagianSelected);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching Bahagian data: ", error);
                        }
                    });
                });
            </script>
        </div>
    </div>
    @else
    <div class="col-12 col-md-6">
        <div class="form-group">
            {{ Form::label('bahagian_jln', 'Bahagian - Jabatan Landskap Negara') }}
            {!! Form::select('bahagian_jln', [
                '0' => 'Tiada Maklumat',
                '1' => 'Bahagian Pengurusan Landskap',
                '2' => 'Bahagian Taman Awam',
                '3' => 'Bahagian Pembangunan Landskap',
                '4' => 'Bahagian Khidmat Teknikal',
                '5' => 'Bahagian Penyelidikan & Pemulihan',
                '6' => 'Bahagian Penilaian & Penyelenggaraan',
                '7' => 'Bahagian Teknologi Maklumat',
                '8' => 'Bahagian Promosi & Industri Landskap',
                '9' => 'Bahagian Dasar & Pengurusan Korporat',
                '10' => 'Bahagian Kontrak & Ukur Bahan',
            ], null, ['class' => 'form-control']) !!}
            @error('bahagian_jln')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @endif
</div>
