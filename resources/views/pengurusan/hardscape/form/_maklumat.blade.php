<table id="example" class="responsive table table-bordered table-sm mb-3">
    @if(isset($hardscape->kod_tag) && $hardscape->hardscape_qrcode)
    <tr>
        <th class="table-secondary">Kod</th>
        <td colspan="2">{!! $hardscape->kod_tag ?? $blank !!}</td>
        <td rowspan="5" class="align-middle text-center">

            <img class="img-thumbnail m-1"
                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(0)->size(120)->errorCorrection('Q')->generate($hardscape->hardscape_qrcode)) !!}"
                alt="qr">
        </td>
    </tr>
    @endif
    <tr>
        <th class="table-secondary">Koordinat</th>
        <td colspan="2">

            {{ Form::label('x', 'Koordinat X',['class'=>'sr-only']) }}
            {{ Form::text('x',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'x')]) }}
            {!! Html::hasError($errors,'x') !!}

            {{ Form::label('y', 'Koordinat Y',['class'=>'sr-only']) }}
            {{ Form::text('y',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'y')]) }}
            {!! Html::hasError($errors,'y') !!}
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Zon</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('zon', 'Zon',['class'=>'sr-only']) }}
                {{ Form::text('zon',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'zon')]) }}
                {!! Html::hasError($errors,'zon') !!}
            </div>
        </td>
    </tr>

    <tr>
        <th class="table-secondary">Jenis/Kategori</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('jenis', 'jenis',['class'=>'sr-only']) }}
                {{ Form::text('jenis',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'jenis')]) }}
                {!! Html::hasError($errors,'jenis') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Struktur</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('nama_struk', 'nama_struk',['class'=>'sr-only']) }}
                {{ Form::text('nama_struk',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'nama_struk')]) }}
                {!! Html::hasError($errors,'nama_struk') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Keadaan</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('keadaan', 'jenis_akar',['class'=>'sr-only']) }}
                {{ Form::text('keadaan',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'keadaan')]) }}
                {!! Html::hasError($errors,'keadaan') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Selenggara</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('selenggara', 'selenggara',['class'=>'sr-only']) }}
                {{ Form::text('selenggara',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'selenggara')]) }}
                {!! Html::hasError($errors,'selenggara') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Baik Pulih</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('baik_pulih', 'baik_pulih',['class'=>'sr-only']) }}
                {{ Form::text('baik_pulih',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'baik_pulih')]) }}
                {!! Html::hasError($errors,'baik_pulih') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Kos Bina (RM)</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('kos_bina', 'kos_bina',['class'=>'sr-only']) }}
                {{ Form::text('kos_bina',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'kos_bina')]) }}
                {!! Html::hasError($errors,'kos_bina') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Tarikh</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('tarikh', 'tarikh',['class'=>'sr-only']) }}
                {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
                {!! Html::hasError($errors,'tarikh') !!}
            </div>
        </td>
    </tr>


</table>
