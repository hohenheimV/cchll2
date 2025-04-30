@extends('layouts.pengurusan.app')

@section('title', 'elind')

@section('content')
<section class="content">

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col">

                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                    </div>
                    <!-- /.card-header -->

                    {!! Form::open(['route' => 'pengurusan.users.store']) !!}

                    <div class="card-body">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @php
                            $arr = [
                                1 => 'Kontraktor',
                                2 => 'Agensi Pelaksana',
                                3 => 'NGO & Badan Ikhtisas',
                                4 => 'Institusi Pendidikan',
                                5 => 'Pertubuhan Antarabangsa',
                                6 => 'Pembekal Landskap',
                                7 => 'Perunding',
                                8 => 'Agensi Pelaksana',
                                9 => 'PBT',
                            ];
                        @endphp
                            @for ($i = 1; $i <= 9; $i++)
                                <li class="nav-item">
                                    <a class="nav-link {{ $i == 1 ? 'active' : '' }}" id="tab-{{ $i }}-tab" data-toggle="tab" href="#tab-{{ $i }}" role="tab" aria-controls="tab-{{ $i }}" aria-selected="{{ $i == 1 ? 'true' : 'false' }}">{{ $arr[$i] }}</a>
                                </li>
                            @endfor
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1-tab">
                                <form action="/elandskap/elind/contractors/add" class="form-horizontal" novalidate="novalidate" id="ContractorAddForm" method="post" accept-charset="utf-8">
                                    <div style="display:none;">
                                        <input type="hidden" name="_method" value="POST">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="form-group">
                                                <label class="col-xs-4 control-label"></label>
                                                <div class="col-xs-12">
                                                    <h4>Butiran Maklumat Kontraktor</h4>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorNama" class="col-md-4 control-label">Nama</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][nama]" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorIdKelas" class="col-md-4 control-label">Kelas Kontraktor</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][id_kelas]" class="form-control" id="ContractorIdKelas" required="required">
                                                        <option value="1">A</option>
                                                        <option value="2">B</option>
                                                        <option value="3">BX</option>
                                                        <option value="4">C</option>
                                                        <option value="5">D</option>
                                                        <option value="6">E</option>
                                                        <option value="7">EX</option>
                                                        <option value="8">F</option>
                                                        <option value="0">TIADA MAKLUMAT</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorIdBumi" class="col-md-4 control-label">Taraf Bumiputera</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][id_bumi]" class="form-control" id="ContractorIdBumi">
                                                        <option value="1">BUMIPUTERA</option>
                                                        <option value="2">BUKAN BUMIPUTERA</option>
                                                        <option value="0">TIADA MAKLUMAT</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorIdDaftar" class="col-md-4 control-label">Status e-Perunding</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][id_daftar]" class="form-control" id="ContractorIdDaftar" required="required">
                                                        <option value="0">Tiada Maklumat</option>
                                                        <option value="1">Berdaftar</option>
                                                        <option value="2">Tidak Berdaftar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorTngaMahir" class="col-md-4 control-label">Bil. Pekerja Mahir</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][tnga_mahir]" class="form-control" type="number" id="ContractorTngaMahir">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg">
                                            <div class="form-group">
                                                <label class="col-xs-4 control-label"></label>
                                                <div class="col-xs-12">
                                                    <h4>Alamat Kontraktor</h4>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorAlamat1" class="col-md-4 control-label">Alamat 1</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][alamat1]" class="form-control" maxlength="50" type="text" id="ContractorAlamat1" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorAlamat2" class="col-md-4 control-label">Alamat 2</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][alamat2]" class="form-control" maxlength="50" type="text" id="ContractorAlamat2">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorPoskod" class="col-md-4 control-label">Poskod</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][poskod]" class="form-control" type="char" id="ContractorPoskod" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorBandar" class="col-md-4 control-label">Bandar</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][bandar]" class="form-control" id="ContractorBandar">
                                                        <option value="">(choose one)</option>
                                                        <option value="7">Bukit Subang</option>
                                                        <option value="8">Kangar</option>
                                                        <option value="4">Johor Bahru</option>
                                                        <option value="5">Putrajaya</option>
                                                        <option value="6">Shah Alam</option>
                                                        <option value="11">Kulai</option>
                                                        <option value="12">Skudai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorNegeri" class="col-md-4 control-label">Negeri</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][negeri]" class="form-control" id="ContractorNegeri" required="required">
                                                        <option value="">(choose one)</option>
                                                        <option value="1">Johor</option>
                                                        <option value="2">Kedah</option>
                                                        <option value="3">Kelantan</option>
                                                        <option value="4">Malacca</option>
                                                        <option value="5">Negeri Sembilan</option>
                                                        <option value="6">Pahang</option>
                                                        <option value="7">Penang</option>
                                                        <option value="8">Perak</option>
                                                        <option value="9">Perlis</option>
                                                        <option value="10">Sabah</option>
                                                        <option value="11">Sarawak</option>
                                                        <option value="12">Selangor</option>
                                                        <option value="13">Terengganu</option>
                                                        <option value="14">Kuala Lumpur</option>
                                                        <option value="15">Putrajaya</option>
                                                        <option value="16">Labuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class=" col-lg-6">
                                                        <!-- <label class="col-xs-4 control-label"></label>
                                                        <div class="col-xs-12"> -->
                                                            <h4>Butiran Maklumat Kontraktor</h4>
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class=" col-lg-6">
                                                        <a id="adda" class="btn btn-success" style="color:white;">
                                                            <i class="fas fa-save"></i> Tambah
                                                        </a>
                                                        <a id="reseta" class="btn btn-success" style="color:white;">
                                                            <i class="fas fa-save"></i> Reset
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="inputContainer" style="border: 1px solid black;">
                                                <div class="inputGroup">
                                                    <h4>&nbsp;Projek</h4>
                                                    <div class="form-group required">
                                                        <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek</label>
                                                        <div class="col-md-12">
                                                            <input name="inputA1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label for="ContractorNama" class="col-md-4 control-label">Kos</label>
                                                        <div class="col-md-12">
                                                            <input name="inputB1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label for="ContractorNama" class="col-md-4 control-label">Tahun</label>
                                                        <div class="col-md-12">
                                                            <input name="data[Contractor][nama]" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                let count = 1;

                                                document.getElementById('adda').addEventListener('click', function() {
                                                    count++;
                                                    const inputContainer = document.getElementById('inputContainer');
                                                    const newInputGroup = document.createElement('div');
                                                    newInputGroup.className = 'inputGroup';
                                                    // newInputGroup.style.border = '1px solid black';
                                                    newInputGroup.innerHTML = `
                                                        <div style="border-bottom: 1px solid black; width: 100%; margin-bottom: 10px;"></div>
                                                        <h4>&nbsp;Projek ${count}</h4>
                                                        <div class="form-group required">
                                                            <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek${count}</label>
                                                            <div class="col-md-12">
                                                                <input name="inputA${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group required">
                                                            <label for="ContractorNama" class="col-md-4 control-label">Kos${count}</label>
                                                            <div class="col-md-12">
                                                                <input name="inputB${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group required">
                                                            <label for="ContractorNama" class="col-md-4 control-label">Kos${count}</label>
                                                            <div class="col-md-12">
                                                                <input name="inputC${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                            </div>
                                                        </div>
                                                    `;
                                                    inputContainer.appendChild(newInputGroup);
                                                });

                                                document.getElementById('reseta').addEventListener('click', function() {
                                                    const inputContainer = document.getElementById('inputContainer');
                                                    inputContainer.innerHTML = `
                                                        <div class="inputGroup" style="border: 1px solid black;">
                                                            <h4>Projek</h4>
                                                            <div class="form-group required">
                                                                <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek</label>
                                                                <div class="col-md-12">
                                                                    <input name="inputA1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                                </div>
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="ContractorNama" class="col-md-4 control-label">Kos</label>
                                                                <div class="col-md-12">
                                                                    <input name="inputB1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                                </div>
                                                            </div>
                                                            <div class="form-group required">
                                                                <label for="ContractorNama" class="col-md-4 control-label">Tahun</label>
                                                                <div class="col-md-12">
                                                                    <input name="inputC1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;
                                                    count = 1;
                                                });
                                            </script>


                                        </div>

                                        <div class="col-lg">
                                            <div class="form-group">
                                                <label class="col-xs-4 control-label"></label>
                                                <div class="col-xs-12">
                                                    <h4>Alamat Kontraktor</h4>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorAlamat1" class="col-md-4 control-label">Alamat 1</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][alamat1]" class="form-control" maxlength="50" type="text" id="ContractorAlamat1" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorAlamat2" class="col-md-4 control-label">Alamat 2</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][alamat2]" class="form-control" maxlength="50" type="text" id="ContractorAlamat2">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorPoskod" class="col-md-4 control-label">Poskod</label>
                                                <div class="col-md-12">
                                                    <input name="data[Contractor][poskod]" class="form-control" type="char" id="ContractorPoskod" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ContractorBandar" class="col-md-4 control-label">Bandar</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][bandar]" class="form-control" id="ContractorBandar">
                                                        <option value="">(choose one)</option>
                                                        <option value="7">Bukit Subang</option>
                                                        <option value="8">Kangar</option>
                                                        <option value="4">Johor Bahru</option>
                                                        <option value="5">Putrajaya</option>
                                                        <option value="6">Shah Alam</option>
                                                        <option value="11">Kulai</option>
                                                        <option value="12">Skudai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorNegeri" class="col-md-4 control-label">Negeri</label>
                                                <div class="col-md-12">
                                                    <select name="data[Contractor][negeri]" class="form-control" id="ContractorNegeri" required="required">
                                                        <option value="">(choose one)</option>
                                                        <option value="1">Johor</option>
                                                        <option value="2">Kedah</option>
                                                        <option value="3">Kelantan</option>
                                                        <option value="4">Malacca</option>
                                                        <option value="5">Negeri Sembilan</option>
                                                        <option value="6">Pahang</option>
                                                        <option value="7">Penang</option>
                                                        <option value="8">Perak</option>
                                                        <option value="9">Perlis</option>
                                                        <option value="10">Sabah</option>
                                                        <option value="11">Sarawak</option>
                                                        <option value="12">Selangor</option>
                                                        <option value="13">Terengganu</option>
                                                        <option value="14">Kuala Lumpur</option>
                                                        <option value="15">Putrajaya</option>
                                                        <option value="16">Labuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2-tab">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label"></label>
                                            <div class="col-xs-12">
                                                <h4>Butiran Maklumat Agensi Pelaksana</h4>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ImplementerIdKat" class="col-md-4 control-label">Kategori</label>
                                            <div class="col-md-12">
                                                <select name="data[Implementer][id_kat]" class="form-control" id="ImplementerIdKat" required="required">
                                                    <option value="0">Tiada Maklumat</option>
                                                    <option value="5">Persekutuan</option>
                                                    <option value="6">Negeri</option>
                                                    <option value="7">PBT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ImplementerNama" class="col-md-4 control-label">Nama Agensi</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][nama]" class="form-control" maxlength="50" type="text" id="ImplementerNama" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerJabatan" class="col-md-4 control-label">Nama Jabatan / Bahagian</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][jabatan]" class="form-control" maxlength="100" type="text" id="ImplementerJabatan">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerKetuaJbtn" class="col-md-4 control-label">Nama Ketua</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][ketua_jbtn]" class="form-control" maxlength="50" type="text" id="ImplementerKetuaJbtn">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerJawatan" class="col-md-4 control-label">Jawatan</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][jawatan]" class="form-control" maxlength="100" type="text" id="ImplementerJawatan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label"></label>
                                            <div class="col-xs-12">
                                                <h4>Butiran Maklumat Agensi Pelaksana</h4>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ImplementerIdKat2" class="col-md-4 control-label">Kategori</label>
                                            <div class="col-md-12">
                                                <select name="data[Implementer][id_kat2]" class="form-control" id="ImplementerIdKat2" required="required">
                                                    <option value="0">Tiada Maklumat</option>
                                                    <option value="5">Persekutuan</option>
                                                    <option value="6">Negeri</option>
                                                    <option value="7">PBT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ImplementerNama2" class="col-md-4 control-label">Nama Agensi</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][nama2]" class="form-control" maxlength="50" type="text" id="ImplementerNama2" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerJabatan2" class="col-md-4 control-label">Nama Jabatan / Bahagian</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][jabatan2]" class="form-control" maxlength="100" type="text" id="ImplementerJabatan2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerKetuaJbtn2" class="col-md-4 control-label">Nama Ketua</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][ketua_jbtn2]" class="form-control" maxlength="50" type="text" id="ImplementerKetuaJbtn2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ImplementerJawatan2" class="col-md-4 control-label">Jawatan</label>
                                            <div class="col-md-12">
                                                <input name="data[Implementer][jawatan2]" class="form-control" maxlength="100" type="text" id="ImplementerJawatan2">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- Add other tabs here -->
                            <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3-tab">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label"></label>
                                            <div class="col-xs-12">
                                                <h4>Maklumat Permohonan Projek</h4>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ManageprojectIdJenispermohonan" class="col-md-4 control-label">Jenis Permohonan</label>
                                            <div class="col-md-12">
                                                <select name="data[Manageproject][id_jenispermohonan]" class="form-control" id="ManageprojectIdJenispermohonan" required>
                                                    <option value="">(choose one)</option>
                                                    <option value="8">Taman Botani</option>
                                                    <option value="9">Taman Arboretum</option>
                                                    <option value="10">Taman Kejiranan</option>
                                                    <option value="12">Landskap Jalan Protokol</option>
                                                    <option value="2">Naik Taraf Taman Awam</option>
                                                    <option value="3">Pembangunan Landskap</option>
                                                    <option value="4">Landskap Perbandaran</option>
                                                    <option value="7">Legaran Bandaran</option>
                                                    <option value="5">Infrastruktur Hijau</option>
                                                    <option value="13">Promenade / Waterfront</option>
                                                    <option value="6">Pembangunan Persekitaran Kehidupan</option>
                                                    <option value="14">Taman Poket</option>
                                                    <option value="11">Taman Permainan</option>
                                                    <option value="1">Taman Awam</option>
                                                    <option value="16">Hutan Bandar</option>
                                                    <option value="17">Taman Bandaran</option>
                                                    <option value="19">Taman Persekutuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ManageprojectTajukPembangunan" class="col-md-4 control-label">1. TAJUK PEMBANGUNAN</label>
                                            <div class="col-md-12">
                                                <textarea name="data[Manageproject][tajuk_pembangunan]" class="form-control" rows="3" maxlength="255" id="ManageprojectTajukPembangunan" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ManageprojectNoRujukan" class="col-md-4 control-label">2. RUJUKAN PERMOHONAN</label>
                                            <div class="col-md-12">
                                                <input name="data[Manageproject][no_rujukan]" class="form-control" maxlength="150" type="text" id="ManageprojectNoRujukan" required>
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ManageprojectKosPembangunan" class="col-md-4 control-label">ANGGARAN KOS PEMBANGUNAN (RM)</label>
                                            <div class="col-md-12">
                                                <input name="data[Manageproject][kos_pembangunan]" class="form-control" style="width: 100px" maxlength="12" type="text" id="ManageprojectKosPembangunan" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label"></label>
                                            <div class="col-xs-12">
                                                <h4>Rancangan Pembangunan</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><small>Adakah tapak cadangan berasaskan kepada Rancangan Pembangunan tersebut:</small></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkbox clearfix">
                                                        <label class="col-xs-12">
                                                            <input type="hidden" name="data[Manageproject][flag_pil]" id="ManageprojectFlagPil_" value="0">
                                                            <input type="checkbox" name="data[Manageproject][flag_pil]" value="1" id="ManageprojectFlagPil">Pelan Induk Landskap:
                                                        </label>
                                                        <input name="data[Manageproject][nama_pil]" class="form-control" maxlength="255" type="text" id="ManageprojectNamaPil">
                                                    </div>
                                                    <div class="checkbox clearfix">
                                                        <label class="col-xs-12">
                                                            <input type="hidden" name="data[Manageproject][flag_tempatan]" id="ManageprojectFlagTempatan_" value="0">
                                                            <input type="checkbox" name="data[Manageproject][flag_tempatan]" value="1" id="ManageprojectFlagTempatan">Rancangan Tempatan:
                                                        </label>
                                                        <input name="data[Manageproject][nama_tempatan]" class="form-control" maxlength="255" type="text" id="ManageprojectNamaTempatan">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="checkbox clearfix">
                                                        <label class="col-xs-12">
                                                            <input type="hidden" name="data[Manageproject][flag_struktur]" id="ManageprojectFlagStruktur_" value="0">
                                                            <input type="checkbox" name="data[Manageproject][flag_struktur]" value="1" id="ManageprojectFlagStruktur">Rancangan Struktur:
                                                        </label>
                                                        <input name="data[Manageproject][nama_struktur]" class="form-control" maxlength="255" type="text" id="ManageprojectNamaStruktur">
                                                    </div>
                                                    <div class="checkbox clearfix">
                                                        <label class="col-xs-12">
                                                            <input type="hidden" name="data[Manageproject][flag_kaw_khas]" id="ManageprojectFlagKawKhas_" value="0">
                                                            <input type="checkbox" name="data[Manageproject][flag_kaw_khas]" value="1" id="ManageprojectFlagKawKhas">Rancangan Kawasan Khas:
                                                        </label>
                                                        <input name="data[Manageproject][nama_kaw_khas]" class="form-control" maxlength="255" type="text" id="ManageprojectNamaKawKhas">
                                                    </div>
                                                    <div class="checkbox clearfix">
                                                        <label class="col-xs-12">
                                                            <input type="hidden" name="data[Manageproject][flag_lain_rancangan]" id="ManageprojectFlagLainRancangan_" value="0">
                                                            <input type="checkbox" name="data[Manageproject][flag_lain_rancangan]" value="1" id="ManageprojectFlagLainRancangan">Lain-Lain Pelan Pembangunan (Nyatakan):
                                                        </label>
                                                        <input name="data[Manageproject][nama_lain_rancangan]" class="form-control" maxlength="255" type="text" id="ManageprojectNamaLainRancangan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label class="col-xs-4 control-label"></label>
                                            <div class="col-xs-12">
                                                <h4>Maklumat Sokongan</h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="clearfix">
                                                <label class="col-xs-10">1. Surat Permohonan Beserta Cop Pengesahan Datuk Bandar/YDP/SU<font style="color:red;"><strong>*</strong></font></label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">2. Pelan ukur terkini (dalam tempoh 3 tahun) yang telah disahkan oleh juruukur bertauliah</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">3. Pelan guna tanah bagi kawasan tapak cadangan dan sekitarnya</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">4. Pelan kontur kawasan tapak cadangan dan sekitarnya</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">5. Gambar foto tapak cadangan</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">6. Gambar foto kawasan sekitar tapak cadangan</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">7. Salinan surat hakmilik tanah untuk setiap lot yang terlibat</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">8. Salinan surat pewartaan untuk setiap lot yang terlibat</label>
                                            </div>
                                            <div class="clearfix">
                                                <label class="col-xs-10">9. Lain-lain gambar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="tab-4-tab">
                                <!-- Form for tab 4 -->
                            </div>
                            <div class="tab-pane fade" id="tab-5" role="tabpanel" aria-labelledby="tab-5-tab">
                                <!-- Form for tab 5 -->
                            </div>
                            <div class="tab-pane fade" id="tab-6" role="tabpanel" aria-labelledby="tab-6-tab">
                                <!-- Form for tab 6 -->
                            </div>
                            <div class="tab-pane fade" id="tab-7" role="tabpanel" aria-labelledby="tab-7-tab">
                                <!-- Form for tab 7 -->
                            </div>
                            <div class="tab-pane fade" id="tab-8" role="tabpanel" aria-labelledby="tab-8-tab">
                                <!-- Form for tab 8 -->
                            </div>
                            <div class="tab-pane fade" id="tab-9" role="tabpanel" aria-labelledby="tab-9-tab">
                                <!-- Form for tab 9 -->
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.users.index')."'",'class'=>'btn btn-secondary']) !!}
                        {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                    </div>
                    <!-- /.card-footer -->

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>
    <!--/. container-fluid -->

</section>

@endsection
