<style>
    .form-group label {
        margin-bottom: .1rem;
    }
    .input-group-text-sm{
        padding: .3rem .75rem !important;
    }
</style>

<h5 class="font-weight-bold border-bottom border-dark">Butiran</h6>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('tarikh', 'Tarikh Tanam') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        {{ Form::text('tarikh', isset($hardscape->tarikh) ? $hardscape->tarikh->format('d-m-Y') : null ,['placeholder'=>'Sila masukkan tarikh','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tarikh')]) }}
                    </div>
                    {!! Html::hasError($errors,'tarikh') !!}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('kos_pembinaan', 'Kos Pembinaan') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-text-sm"><small>RM</small></span>
                        </div>
                        {{ Form::text('kos_pembinaan',null,['placeholder'=>'Sila masukkan Kos Perolehan','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kos_pembinaan')]) }}
                    </div>
                    {!! Html::hasError($errors,'kos_pembinaan') !!}
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    {{ Form::label('no_rujukan', 'No Rujukan') }}
                    {{ Form::text('no_rujukan',null,['placeholder'=>'Sila masukkan No Rujukan','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'no_rujukan')]) }}
                    {!! Html::hasError($errors,'no_rujukan') !!}
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    {{ Form::label('kod_tag', 'Kod Tag') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        </div>
                        {{ Form::text('kod_tag',null,['placeholder'=>'Sila masukkan Kod Tag','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kod_tag')]) }}
                    </div>
                    {!! Html::hasError($errors,'kod_tag') !!}
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('lat', 'Koordinat X') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        {{ Form::text('lat',null,['placeholder'=>'Sila masukkan Koordinat X','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'lat')]) }}
                    </div>
                    {!! Html::hasError($errors,'lat') !!}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    {{ Form::label('lng', 'Koordinat Y') }}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        {{ Form::text('lng',null,['placeholder'=>'Sila masukkan Koordinat Y','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'lng')]) }}
                    </div>
                    {!! Html::hasError($errors,'lng') !!}
                </div>
            </div>
        </div>

    </div>
    <div class="col-12 col-md-6">
        <div class="col-12">
            <div class="col-4">
                <div class="card">
                    <div class="card-header p-0 text-center">
                    <small>Gambar Lengkap</small>
                    </div>
                    <div class="embed-responsive embed-responsive-4by3">
                    <img id="img-gambar_lengkap" class="card-img-top embed-responsive-item"
                            src="{{ isset($hardscape) ?  asset($hardscape->gambar_lengkap) : asset('img/default-150x150.png') }}" alt="gambar_lengkap">
                    </div>
                    <div class="card-footer p-0 d-flex justify-content-end">
                    <input type="hidden" name="{{'gambar_lengkap'}}" id="input-gambar_lengkap"
                        value="{{ isset($hardscape) ?  asset($hardscape->gambar_lengkap) : asset('img/default-150x150.png') }}">
                        <button id="btn-gambar_lengkap" data-type="gambar_lengkap" type="button"
                            class="btn btn-link btn-sm btn-file p-1 ckfinder">
                            <i class="fas fa-upload text-success "></i></button>
                        <button data-type="gambar_lengkap" id="trash-gambar_lengkap" type="button" class="btn btn-link btn-sm btn-file p-1 trash-gambar">
                            <i class="fas fa-trash text-danger"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('jenis_komponen', 'Jenis Komponen') }}
                {{ Form::text('jenis_komponen',null,['placeholder'=>'Sila masukkan Jenis Komponen','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_komponen')]) }}
                {!! Html::hasError($errors,'jenis_komponen') !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('nama_struktur', 'Nama Struktur') }}
                {{ Form::text('nama_struktur',null,['placeholder'=>'Sila masukkan Nama Struktur','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_struktur')]) }}
                {!! Html::hasError($errors,'nama_struktur') !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('keadaan_semasa', 'Keadaan Semasa') }}
                {{ Form::text('keadaan_semasa',null,['placeholder'=>'Sila masukkan Keadaan Semasa','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keadaan_semasa')]) }}
                {!! Html::hasError($errors,'keadaan_semasa') !!}
            </div>
        </div>

    </div>
    {{-- <div class="col-12">
        <div class="form-group">
            {{ Form::label('keterangan', 'Keterangan') }}
            {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan Keterangan','rows'=>3,'class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keterangan')]) }}
            {!! Html::hasError($errors,'keterangan') !!}
        </div>
    </div> --}}
    <div class="col-12">
        <h5 class="font-weight-bold border-bottom border-dark">Rekod {{ isset($record->tarikh) ? $record->tarikh->format('Y') : date('Y') }}</h6>
            {{ Form::hidden('Record.id',$record->id ?? null)}}
        <div class="form-group">
            <h6 class="font-weight-bold">Gambar Landskap Kejur</h6>
            <div class="row">
                <div class="col-2">
                    <div class="card">
                        <div class="card-header p-0 text-center">
                        <small>Gambar Baik Pulih</small>
                        </div>
                        <div class="embed-responsive embed-responsive-4by3">
                        <img id="img-baikpulih_satu" class="card-img-top embed-responsive-item"
                                src="{{ isset($record) ?  asset($record->gambar_baikpulih_satu) : asset('img/default-150x150.png') }}" alt="baikpulih_satu">
                        </div>
                        <div class="card-footer p-0 d-flex justify-content-end">
                        <input type="hidden" name="{{'Record.gambar_baikpulih_satu'}}" id="input-baikpulih_satu"
                            value="{{ isset($record) ?  asset($record->gambar_baikpulih_satu) : asset('img/default-150x150.png') }}">
                            <button id="btn-baikpulih_satu" data-type="baikpulih_satu" type="button"
                                class="btn btn-link btn-sm btn-file p-1 ckfinder">
                                <i class="fas fa-upload text-success "></i></button>
                            <button data-type="baikpulih_satu" id="trash-baikpulih_satu" type="button" class="btn btn-link btn-sm btn-file p-1 trash-gambar">
                                <i class="fas fa-trash text-danger"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card">
                        <div class="card-header p-0 text-center">
                            <small>Gambar Baik Pulih</small>
                        </div>
                        <div class="embed-responsive embed-responsive-4by3">
                        <img id="img-baikpulih_dua" class="card-img-top embed-responsive-item"
                                src="{{ isset($record) ?  asset($record->gambar_baikpulih_dua) : asset('img/default-150x150.png') }}" alt="baikpulih_dua">
                        </div>
                        <div class="card-footer p-0 d-flex justify-content-end">
                        <input type="hidden" name="{{'Record.gambar_baikpulih_dua'}}" id="input-baikpulih_dua"
                            value="{{ isset($record) ?  asset($record->gambar_baikpulih_dua) : asset('img/default-150x150.png') }}">
                            <button id="btn-baikpulih_dua" data-type="baikpulih_dua" type="button"
                                class="btn btn-link btn-sm btn-file p-1 ckfinder">
                                <i class="fas fa-upload text-success "></i></button>
                            <button data-type="baikpulih_dua" id="trash-baikpulih_dua" type="button" class="btn btn-link btn-sm btn-file p-1 trash-gambar">
                                <i class="fas fa-trash text-danger"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card">
                        <div class="card-header p-0 text-center">
                            <small>Gambar Baik Pulih</small>
                        </div>
                        <div class="embed-responsive embed-responsive-4by3">
                        <img id="img-baikpulih_tiga" class="card-img-top embed-responsive-item"
                                src="{{ isset($record) ?  asset($record->gambar_baikpulih_tiga) : asset('img/default-150x150.png') }}" alt="baikpulih_tiga">
                        </div>
                        <div class="card-footer p-0 d-flex justify-content-end">
                        <input type="hidden" name="{{'Record.gambar_baikpulih_tiga'}}" id="input-baikpulih_tiga"
                            value="{{ isset($record) ?  asset($record->gambar_baikpulih_dua) : asset('img/default-150x150.png') }}">
                            <button id="btn-baikpulih_tiga" data-type="baikpulih_tiga" type="button"
                                class="btn btn-link btn-sm btn-file p-1 ckfinder">
                                <i class="fas fa-upload text-success "></i></button>
                            <button data-type="baikpulih_tiga" id="trash-baikpulih_tiga" type="button" class="btn btn-link btn-sm btn-file p-1 trash-gambar">
                                <i class="fas fa-trash text-danger"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-3">
            <div class="form-group">
                {{ Form::label('tarikh', 'Tarikh') }}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    {{ Form::text('Record.tarikh',isset($record->tarikh) ? $record->tarikh->format('d-m-Y') : null,['placeholder'=>'Sila masukkan Tarikh','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tarikh')]) }}
                </div>
                {!! Html::hasError($errors,'tarikh') !!}
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                {{ Form::label('kos_baikpulih', 'Kos Baikpulih') }}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-text-sm"><small>RM</small></span>
                    </div>
                    {{ Form::text('kos_baikpulih',null,['placeholder'=>'Sila masukkan Kos Baikpulih','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kos_baikpulih')]) }}
                </div>
                {!! Html::hasError($errors,'kos_baikpulih') !!}
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                {{ Form::label('kos_selenggara', 'Kos Selenggara') }}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-text-sm"><small>RM</small></span>
                    </div>
                    {{ Form::text('kos_selenggara',null,['placeholder'=>'Sila masukkan Kos Selenggara','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kos_selenggara')]) }}
                </div>
                {!! Html::hasError($errors,'kos_selenggara') !!}
            </div>
        </div>
        <div class="w-100"></div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('catatan_baikpulih', 'Catatan Baikpulih') }}
                {{ Form::textarea('Record.catatan_baikpulih',$record->catatan_baikpulih ?? null,['placeholder'=>'Sila masukkan Catatan Baikpulih','rows'=>7,'class' => 'form-control form-control-sm '.Html::isInvalid($errors,'catatan_baikpulih')]) }}
                {!! Html::hasError($errors,'catatan_baikpulih') !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('catatan_selenggara', 'Catatan Selenggara') }}
                {{ Form::textarea('Record.catatan_selenggara',$record->catatan_selenggara ?? null,['placeholder'=>'Sila masukkan Catatan','rows'=>7,'class' => 'form-control form-control-sm '.Html::isInvalid($errors,'catatan_selenggara')]) }}
                {!! Html::hasError($errors,'catatan_selenggara') !!}
            </div>
        </div>
    </div>
</div>
