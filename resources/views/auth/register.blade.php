@extends('layouts.pengurusan.auth')

@section('title', 'Daftar Akaun')
@section('content')
    <section class="content">
        @include('layouts.pengurusan.notification')
    </section>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        /* Basic reset for body */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .card-body {
                width: 100%; /* Use full width on smaller screens */
                padding: 20px; /* Add padding */
            }

        /* Dot Dot Dot Preloader */
        .dot-dot-dot {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            width: 100px;
            height: 100px;
        }

        .dot-dot-dot span {
            display: block;
            width: 15px;
            height: 15px;
            margin: 0 10px;
            background-color: #3498db;
            border-radius: 50%;
            animation: dot-blink 1.4s infinite both;
        }

        .dot-dot-dot span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot-dot-dot span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes dot-blink {
            0%, 20%, 80%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        /* Optional: Adding a background overlay */
        .preloader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 999;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .card-body {
                width: 100%; /* Use full width on smaller screens */
                padding: 20px; /* Add padding */
            }

            .input-group {
                flex-direction: column; /* Stack elements vertically */
                width: 100%;
            }

            .input-group .form-control {
                width: 100%; /* Ensure inputs are full width */
            }
        }

        @media (min-width: 992px) {
            .card-body {
                width: 400px; /* Fixed width for larger screens */
            }    
            .mobile-label {
            display: block; /* Make sure it's a block element */
            margin-right: 15px; /* Space between label and input */
        }
        }
        
    </style>
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da; /* Match the default Bootstrap border */
            border-radius: 0.25rem; /* Match the default Bootstrap border radius */
            height: calc(2.25rem + 2px); /* Match the height */
            padding: 0.375rem 0.75rem; /* Match the padding */
            font-size: 1rem; /* Match the font size */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem; /* Align text vertically */
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d; /* Match the placeholder color */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 2.25rem; /* Match arrow height */
            top: 50%; /* Center the arrow */
            transform: translateY(-50%); /* Center the arrow */
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            color: #dc3545; /* Clear button color */
        }

    </style>
    <!-- Preloader overlay -->
    <div class="preloader-overlay" id="loading-spinner" style="display: none;">
        <!-- Dot Dot Dot Preloader -->
        <div id="loading-spinnerX" class="dot-dot-dot">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <label for="roles">Roles</label><br>
                            <input type="checkbox" name="roles[]" value="Penggiat Industri"> Penggiat Industri<br>
                            <input type="checkbox" name="roles[]" value="Admin"> Admin<br>
                            <input type="checkbox" name="roles[]" value="User"> User<br>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <br>
    <br>
    <div class="row">
        <div class="col-lg-12 col-12 rounded-right bg-white">
            <div class="card-body">
                <div class="text-center d-lg-none">
                    <img height="96" src="{{ asset('img/logo-jln.png') }}" />
                    <h3><span class="font-weight-bold">{{ config('app.name_short') }}</span> {{ config('app.agency_short') }}</h3>
                </div>
                <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
                    {{ config('app.name_short') }}
                </div>

                <!-- Registration form Input Fields -->
                <form id="myForm" method="POST" action="{{ route('register') }}" class="m-lg-5">
                    @csrf
                    <h4 class="login-box-msg text-dark">@yield('title')</h4>

                    <!-- Dropdown Selection -->
                    <!-- <div class="form-group mb-3">
                        {{ Form::label('roles', 'Jenis Akaun') }}
                        <select id="roles" class="form-control select2" name="roles" onchange="updateFields()">
                            <option value="" selected>Pilih Jenis Akaun</option>
                            <option value="Pihak Berkuasa Tempatan">Pihak Berkuasa Tempatan</option>
                            <option value="Penggiat Industri">Penggiat Industri</option>
                        </select>
                    </div> -->
                    <div class="form-group mb-3">
                        {{ Form::label('roles', 'Jenis Akaun') }}
                        <select id="roles" class="form-control select2" name="roles" onchange="updateFields()">
                            <option value="" selected>Pilih Jenis Akaun</option>
                            <option value="Pihak Berkuasa Tempatan" {{ old('roles', session('roles')) == 'Pihak Berkuasa Tempatan' ? 'selected' : '' }}>Pihak Berkuasa Tempatan</option>
                            <option value="Penggiat Industri" {{ old('roles', session('roles')) == 'Penggiat Industri' ? 'selected' : '' }}>Penggiat Industri</option>
                        </select>
                    </div>

                    <div id="user_details" style="display: none;">
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('name', 'Nama Pemohon') }}
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('email', 'Emel Pemohon') }}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Emel" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('password', 'Katalaluan') }}
                                <!-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Katalaluan" required> -->
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Katalaluan" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor: pointer; background-color: transparent;">
                                            <i id="toggle-password-visibility" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('password_confirmation', 'Pengesahan Katalaluan') }}
                                <!-- <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Sahkan Katalaluan" required> -->
                                <div class="input-group">
                                    <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Sahkan Katalaluan" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" style="cursor: pointer; background-color: transparent;">
                                            <i id="toggle-passwordC-visibility" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <script>
                            document.getElementById('toggle-password-visibility').addEventListener('click', function() {
                                const passwordField = document.getElementById('password');
                                const icon = this;
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            document.getElementById('toggle-passwordC-visibility').addEventListener('click', function() {
                                const passwordField = document.getElementById('password_confirmation');
                                const icon = this;
                                if (passwordField.type === 'password') {
                                    passwordField.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordField.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                        </script>
                    </div>

                    <!-- Fields for PBT Account Type -->
                    <div id="pbt_fields" style="display: none;">
                        <div class="form-group mb-3">
                            {{ Form::label('negeri', 'Negeri') }}
                            <br>
                            <select id="negeri" class="form-control select2" name="negeri" onchange="updatePBT()" required>
                                <option value="">Pilih Negeri</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
                            <input type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" onchange="updatePBTaddress()" class="form-control" required>
                            <datalist id="data_pbt">
                            </datalist>
                        </div>
                        <!-- <div class="input-group mb-3">
                            <select id="pbt" class="form-control select2" name="pbt" onchange="updatePBTaddress()">
                                <option value="">Pilih PBT</option>
                            </select>
                        </div> -->

                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                {{ Form::label('department', 'Unit / Jabatan / Bahagian') }}
                                <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" placeholder="Contoh: Jabatan Kejuruteraan" value="{{ old('department') }}" required>
                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('phone', 'No. Telefon Pemohon') }}
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Contoh: 012-3456789" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('position', 'Jawatan Pemohon') }}
                                <input id="" type="text" class="form-control @error('position') is-invalid @enderror" name="position" placeholder="Contoh: Penolong Jurutera" value="{{ old('position') }}" required>
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('sv_name', 'Nama Penyelia') }}
                                <input id="sv_name" type="text" class="form-control @error('sv_name') is-invalid @enderror" name="sv_name" placeholder="Nama Penyelia" value="{{ old('sv_name') }}" required>
                                @error('sv_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('sv_email', 'Email Penyelia') }}
                                <input id="sv_email" type="email" class="form-control @error('sv_email') is-invalid @enderror" name="sv_email" placeholder="contoh@email.com" value="{{ old('sv_email') }}" required>
                                @error('sv_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Fields for Penggiat Account Type -->
                    <div id="penggiat_fields" style="display: none;">
                        <!-- Jenis Penggiat Dropdown -->
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('jenis_penggiat', 'Jenis Industri') }}
                                <select id="jenis_penggiat" class="form-control select2" name="jenis_penggiat" onchange="updateJenisIndustri()" required>
                                    <option value="">Pilih Jenis Industri</option>
                                    <option value="Pembekal">Pembekal Landskap</option>
                                    <option value="Perunding">Perunding</option>
                                    <option value="Kontraktor">Kontraktor</option>
                                </select>
                                @error('jenis_penggiat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('no_ssm', 'No. Pendaftaran SSM') }}
                                <input id="no_ssm" type="text" class="form-control" name="no_ssm" placeholder="No. Pendaftaran SSM" required>
                                
                                <script>
                                    $(document).ready(function() {
                                        $('#no_ssm').on('blur', function() {
                                            let no_ssm = $(this).val().trim();

                                            if (no_ssm.length === 0) return;
                                            if (no_ssm.length !== 12 /* || !/^\d{12}$/.test(no_ssm) */) {
                                                alert('No. Pendaftaran SSM mestilah tepat 12 digit.');
                                                // $('#no_ssm').val('');
                                                return;
                                            }

                                            $.get(`/XyZ83hQ2d8A9/${no_ssm}`, function(response) {
                                                // console.log(response);
                                                if (Array.isArray(response) && response.length > 0) {
                                                    const company = response[0];
                                                    // alert('No. Pendaftaran SSM telah wujud dalam sistem.');
                                                    $('#nama_syarikat').val(company.name);
                                                    $('#address1').val(company.address1);
                                                    $('#address2').val(company.address2);
                                                    $('#postcode').val(company.postcode);
                                                    $('#locality').val(company.locality);
                                                    $('#state_PI').val(company.state);
                                                    // $('#no_ssm')[0].setCustomValidity('No SSM already exists.');
                                                }
                                            }).fail(function() {
                                                console.error('Request failed or no data found');
                                                alert('You are making requests too quickly. Please wait a moment before trying again.');
                                                // $('#no_ssm').val('');
                                            });
                                        });
                                    });
                                </script>
                                @error('no_ssm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                {{ Form::label('nama_syarikat', 'Nama Syarikat') }}
                                <input id="nama_syarikat" type="text" class="form-control" name="nama_syarikat" placeholder="Nama Syarikat" required>
                                @error('nama_syarikat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="input-group mb-3">
                            <select id="jenis_penggiat" class="form-control select2" name="jenis_penggiat" onchange="updateJenisIndustri()">
                                <option value="">Pilih Jenis Penggiat</option>
                                <option value="Pembekal Landskap">Pembekal Landskap</option>
                                <option value="Perunding">Perunding</option>
                                <option value="Kontraktor">Kontraktor</option>
                            </select>
                        </div> -->

                        <!-- Kontraktor Specific Fields -->
                        <!-- <div id="kontraktor_fields" style="display: none;">
                            <div class="row">
                                <div class="input-group mb-3 col-md-6">
                                    <select id="kelas-kontraktor" class="form-control select2" name="kelas_kontraktor" required>
                                        <option value="" selected>Pilih Kelas Kontraktor</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="BX">BX</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="EX">EX</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>

                                <div class="input-group mb-3 col-md-6">
                                    <select id="taraf-bumiputera" class="form-control select2" name="taraf_bumiputera" required>
                                        <option value="" selected>Pilih Taraf Bumiputera</option>
                                        <option value="bumiputera">Bumiputera</option>
                                        <option value="bukan bumiputera">Bukan Bumiputera</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group mb-3 col-md-6">
                                    <input id="no-pendaftaran-pkk-cidb" type="text" class="form-control" name="no_pendaftaran_pkk_cidb" placeholder="No. Pendaftaran PKK/ CIDB" required>
                                </div>

                                <div class="input-group mb-3 col-md-6">
                                    <input id="no-pendaftaran-mof" type="text" class="form-control" name="no_pendaftaran_mof" placeholder="No. Pendaftaran SSM" required>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    

                    <div id="user_address" style="display: none;">
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('address1', 'Alamat 1') }}
                                <input id="address1" type="text" class="form-control" name="address1" placeholder="Address 1 (House No./Lot No./Floor and Building Name)" required>
                                @error('address1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('address2', 'Alamat 2') }}
                                <input id="address2" type="text" class="form-control" name="address2" placeholder="Address 2 (Number, Street Name/District)">
                                @error('address2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-2">
                                {{ Form::label('postcode', 'Poskod') }}
                                <input id="postcode" type="text" maxlength="5" class="form-control" name="postcode" placeholder="Postcode" required oninput="updatePostcode()">
                                @error('postcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                {{ Form::label('locality', 'Bandar') }}
                                <input id="locality" type="text" class="form-control" name="locality" placeholder="Locality Name" required>
                                @error('locality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6" id="negeri_pbt">
                                {{ Form::label('state', 'Negeri') }}
                                <input id="state_PBT" type="text" class="form-control" name="state" placeholder="State">
                                {{ Form::select('state', [], null, ['class' => 'form-control', 'id' => 'state_PI']) }}
                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- <input id="namaYDP" type="text" class="form-control" name="namaYDP">
                            <input id="emailYDP" type="text" class="form-control" name="emailYDP"> -->
                        </div>
                    </div>

                    <div id="pengesahan" style="display: none;">
                        <div class="row">
                            <div class="form-group mb-3 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                                <textarea style="background-color: transparent; border: none; outline: none; padding: 10px; width: 100%; resize: none; font-weight: bold;" rows="3" class="form-control" readonly disabled>Paparan maklumat adalah bertujuan mempromosikan syarikat/entiti penggiat industri. Oleh itu, nombor telefon, laman web, dan media sosial adalah perlu untuk dipaparkan.</textarea>
                                
                                <br>
                                <div class="form-check ml-4"> <!-- or ms-4 -->
                                    <input class="form-check-input" type="checkbox" id="acknowledgement" name="acknowledgement" required>
                                    <label class="form-check-label" for="acknowledgement">
                                        Dengan mendaftar, anda mengakui dan bersetuju dengan perkara di atas.
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="row" style="display: none;" id="daftar">
                        <div class="col-12">
                            <button type="submit" class="btn bg-olive btn-block btn-flat">Daftar</button>
                        </div>
                    </div>
                </form>

                <!-- Optional -->
                <p class="my-3 text-center">
                    <a href="{{ route('login') }}" class="btn btn-link btn-sm">Sudah ada akaun? Log Masuk</a>
                </p>
            </div>
        </div>
    </div>
    
@endsection
@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateFields() {
            $('.card-body').css('width', '100%');
            var accountType = $('#roles').val();
            var $pbtFields = $('#pbt_fields');
            var $penggiatFields = $('#penggiat_fields');
            var $kontraktorFields = $('#kontraktor_fields');
            var $passwordField = $('#password-field');
            var $passwordConfirmField = $('#password-confirm-field');
            var $daftarButton = $('#daftar');
            var $address = $('#address-fields');

            $('#user_details').show();
            $('#user_address').show();
            // Show/Hide fields based on account type
            if (accountType === 'Pihak Berkuasa Tempatan') {
                $pbtFields.show();
                $pbtFields.find('input, select').prop('disabled', false);
                $penggiatFields.hide();
                $penggiatFields.find('input, select').prop('disabled', true);
                $kontraktorFields.hide();
                $address.show();
                $passwordField.show();
                $passwordConfirmField.show();
                $daftarButton.show();
                var $negeri = $('#negeri');
                // Disable the PBT dropdown and show the spinner
                // $negeri.prop('disabled', true);
                // $('#loading-spinner').show(); // Show the spinner
                // Load Negeri options
                // $.getJSON('/data/negeri', function(data) {
                    
                //     $.each(data, function(index, negeri) {
                //         let pname = negeri.name;
                //         $negeri.append($('<option>', {
                //             value: negeri.id,
                //             text: negeri.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                //         }));
                //     });
                //     // Re-enable the negeri dropdown and hide the spinner
                //     $negeri.prop('disabled', false);
                //     $('#loading-spinner').hide(); // Hide the spinner

                //     // Initialize Select2
                //     $negeri.select2({
                //         // placeholder: 'Pilih Negeri',
                //         allowClear: false
                //     });
                // }).fail(function() {
                //     // Handle errors if needed
                //     $negeri.prop('disabled', false);
                //     $('#loading-spinner').hide(); // Hide the spinner in case of error
                //     alert('Failed to load data');
                // });

                $.ajax({
                    url: '/get-negeri', // API endpoint to get negeri data
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Populate the Negeri dropdown with the data
                        $('#negeri').empty(); // Clear current options
                        $('#negeri').append('<option value="">Pilih Negeri</option>');

                        $.each(data, function(key, value) {
                            // Add each Negeri to the dropdown
                            $('#negeri').append('<option value="' + value.nama_negeri + '">' + value.nama_negeri + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching Negeri data: ", error);
                    }
                });
                // $('#address1').val('');
                // $('#address2').val('');
                // $('#postcode').val('');
                // $('#locality').val('');
                // $('#state').val('');
                $('#state_PBT').show();
                $('#state_PI').hide();
                $('#negeri_pbt').hide();
                $('#pengesahan').hide();
                $('#acknowledgement').prop('disabled', true);
            } else if (accountType === 'Penggiat Industri') {
                $pbtFields.hide();
                $pbtFields.find('input, select').prop('disabled', true);
                $penggiatFields.show();
                $penggiatFields.find('input, select').prop('disabled', false);
                $kontraktorFields.hide();
                $passwordField.show();
                $passwordConfirmField.show();
                $address.show();
                $daftarButton.show();
                $('#state_PBT').hide();
                $('#state_PI').show();
                $('#negeri_pbt').show();
                $('#pengesahan').show();
                $('#acknowledgement').prop('disabled', false);
                $.ajax({
                    url: '/get-negeri',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#state_PI').empty();
                        $('#state_PI').append('<option value="">Pilih Negeri</option>');

                        $.each(data, function(key, value) {
                            var capitalizedNamaNegeri = value.nama_negeri
                            .toLowerCase()
                            .replace(/\b\w/g, function(char) {
                                return char.toUpperCase();
                            });
                            $('#state_PI').append('<option value="' + value.kod_negeri + '">' + capitalizedNamaNegeri + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching Negeri data: ", error);
                    }
                });
                // $('#address1').val('');
                // $('#address2').val('');
                // $('#postcode').val('');
                // $('#locality').val('');
                // $('#state').val('');
            } else {
                $pbtFields.hide();
                $penggiatFields.hide();
                $kontraktorFields.hide();
                $passwordField.hide();
                $passwordConfirmField.hide();
                $address.hide();
                $daftarButton.hide();
            }
        }

        function updateJenisIndustri() {
            var jenisPenggiat = $('#jenis_penggiat').val();
            var $kontraktorFields = $('#kontraktor_fields');
            // var $perundingFields = $('#perunding_fields');
            // var $pembekalFields = $('#pembekal_fields');
            var $countryField = $('#country-field');
            
            if (jenisPenggiat !== 'Pertubuhan Antarabangsa') {
                $('#state-field').removeClass('col-md-3').addClass('col-md-6');
                $countryField.hide();
                if (jenisPenggiat === 'Kontraktor') {
                    $kontraktorFields.show();
                    $kontraktorFields.find('input, select').prop('disabled', false);
                    // $perundingFields.hide();
                    // $perundingFields.find('input, select').prop('disabled', true);
                    // $pembekalFields.hide();
                    // $pembekalFields.find('input, select').prop('disabled', true);
                } else if (jenisPenggiat === 'Pembekal Landskap') {
                    $kontraktorFields.hide();
                    $kontraktorFields.find('input, select').prop('disabled', true);
                    // $perundingFields.hide();
                    // $perundingFields.find('input, select').prop('disabled', true);
                    // $pembekalFields.show();
                    // $pembekalFields.find('input, select').prop('disabled', false);
                } else if (jenisPenggiat === 'Perunding') {
                    $kontraktorFields.hide();
                    $kontraktorFields.find('input, select').prop('disabled', true);
                    // $perundingFields.show();
                    // $perundingFields.find('input, select').prop('disabled', false);
                    // $pembekalFields.hide();
                    // $pembekalFields.find('input, select').prop('disabled', true);
                } else {
                    $kontraktorFields.hide();
                }
            } else {
                $('#state-field').removeClass('col-md-6').addClass('col-md-3');
                $countryField.show();
            }
        }

        function updatePostcode() {
            var postcode = $('#postcode').val();
            var locality = $('#locality');
            var state = $('#state_PI');
            var country = $('#country');

            // Check if the input has exactly 5 digits
            if (postcode.length === 5 && /^\d+$/.test(postcode) && $('#roles').val() === 'Penggiat Industri') {
                // Disable the PBT dropdown and show the spinner
                // $pbt.prop('disabled', true);
                $('#loading-spinner').show(); // Show the spinner

                $.getJSON('/data/postcode/' + postcode, function(data) {
                    if(data != null && data != ''){
                        // console.log(data);
                        locality.val(data.locality);
                        // Check if the dropdown contains a matching value
                        var stateValue = data.state;
                        
                        var $negeri = $('#state_PI');
                        // Disable the PBT dropdown and show the spinner
                        // $negeri.prop('disabled', true);
                        // $('#loading-spinner').show(); // Show the spinner
                        // Load Negeri options
                        $.getJSON('/data/negeri/'+stateValue, function(data) {
                            state.val(data.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '));
                            // Re-enable the negeri dropdown and hide the spinner
                            // $negeri.prop('disabled', false);
                            $('#loading-spinner').hide(); // Hide the spinner
                        }).fail(function() {
                            // Handle errors if needed
                            $negeri.prop('disabled', false);
                            $('#loading-spinner').hide(); // Hide the spinner in case of error
                            alert('Failed to load data');
                        });
                        country.val(data.country);
                    }else{
                        // console.log("data");
                        locality.val('');
                        state.val('');
                        country.val('');
                        $('#loading-spinner').hide(); // Hide the spinner in case of error
                        alert('Failed to load data');
                    }
                    // Re-enable the PBT dropdown and hide the spinner
                    // $pbt.prop('disabled', false);
                    // $('#loading-spinner').hide(); // Hide the spinner
                }).fail(function() {
                    // Handle errors if needed
                    // $pbt.prop('disabled', false);
                    $('#loading-spinner').hide(); // Hide the spinner in case of error
                    alert('Failed to load data');
                });
            }
        }

        // function updatePBT() {
        //     const negeriId = $('#negeri').val();
        //     const $pbt = $('#pbt');
            
        //     // Disable the PBT dropdown and show the spinner
        //     $pbt.prop('disabled', true);
        //     $('#loading-spinner').show(); // Show the spinner

        //     $.getJSON('/data/pbt/' + negeriId, function(data) {
        //         $pbt.empty().append('<option value="">Pilih PBT</option>');

        //         $.each(data, function(index, pbt) {
        //             $pbt.append($('<option>', {
        //                 value: pbt.id,
        //                 text: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        //             }));
        //         });

        //         // Re-enable the PBT dropdown and hide the spinner
        //         $pbt.prop('disabled', false);
        //         $('#loading-spinner').hide(); // Hide the spinner
        //         $pbt.select2({
        //             // placeholder: 'Pilih PBT',
        //             allowClear: false
        //         });
        //     }).fail(function() {
        //         // Handle errors if needed
        //         $pbt.prop('disabled', false);
        //         $('#loading-spinner').hide(); // Hide the spinner in case of error
        //         alert('Failed to load data');
        //     });
        // }

        function updatePBT() {
            $('#pbt').val('');
            $('#user_address input').val('');
            const negeriId = $('#negeri').val();
            const $datalist = $('#data_pbt');  // Target the datalist element
            
            // Clear previous options in the datalist
            $datalist.empty();
            
            // Show the spinner while loading
            $('#loading-spinner').show(); 

            $.getJSON('/data/pbt/' + negeriId, function(data) {
                // Loop through the data and populate the datalist
                $.each(data, function(index, pbt) {
                    // Create a new option element for the datalist
                    $datalist.append($('<option>', {
                        // value: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                        // text: pbt.id,
                        value: pbt.name,
                        'data-id': pbt.id,
                    }));
                });

                // Hide the spinner once the data is loaded
                $('#loading-spinner').hide(); 
            }).fail(function() {
                // Hide the spinner in case of error
                $('#loading-spinner').hide();
                alert('Failed to load data. Sila isi Nama Pihak Berkuasa Tempatan.');
            });
        }

        function updatePBTaddress() {
            const negeriId = $('#negeri').val();

            const selectedValue = $('#pbt').val();
            var selectedOption = $('#data_pbt option[value="' + selectedValue + '"]');
            const pbtId = selectedOption.data('id');

            var address1	 = $('#address1');
            var address2	 = $('#address2');
            var postcode = $('#postcode');
            var locality = $('#locality');
            var state = $('#state_PBT');
            var country = $('#country');
            // var mysms_code = $('#mysms_code');
            // var emailYDP = $('#emailYDP');

            // Check if the input has exactly 5 digits
            // if (postcode.length === 5 && /^\d+$/.test(postcode)) {
                // Disable the PBT dropdown and show the spinner
                // $pbt.prop('disabled', true);
                $('#loading-spinner').show(); // Show the spinner

                $.getJSON('/data/pbt/' + negeriId + '/' + pbtId, function(data) {//console.log(data);
                    if(data != null && data != '' && (typeof data === "object" && !Array.isArray(data))){
                        // console.log(data);
                        // address1.val(data.alamat1.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '));
                        // postcode.val(data.poskod);
                        // locality.val(data.kawasan.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '));
                        // // Check if the dropdown contains a matching value
                        // var stateValue = data.negeri;
                        // state.val(stateValue.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '));
                        // console.log(data.address1);
                        // console.log(data.address2);
                        address1.val(data.address1);
                        address2.val(data.address2);
                        postcode.val(data.postcode);
                        locality.val(data.locality);
                        state.val(data.state);
                        // mysms_code.val(data.name_short);
                        // emailYDP.val(data.emailYDP);
                        // country.val(data.country);
                        $('#loading-spinner').hide();
                    }else{
                        // console.log("data");
                        locality.val('');
                        state.val('');
                        country.val('');
                        $('#loading-spinner').hide(); // Hide the spinner in case of error
                        alert('Failed to load data');
                    }
                    // Re-enable the PBT dropdown and hide the spinner
                    // $pbt.prop('disabled', false);
                    // $('#loading-spinner').hide(); // Hide the spinner
                }).fail(function() {
                    // Handle errors if needed
                    // $pbt.prop('disabled', false);
                    $('#loading-spinner').hide(); // Hide the spinner in case of error
                    alert('Failed to load data. Sila isi Alamat Pihak Berkuasa Tempatan.');
                });
            // }
        }
        // Initialize fields based on the default dropdown value
        $(document).ready(function() {
            $('#myForm')[0].reset();
            // $('#roles').val('');
            if($('#roles').val() != ''){
                updateFields();
            }
            // updateFields(); // Set initial visibility of fields
            
        });
    </script>
@endsection

