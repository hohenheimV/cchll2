<div class="form-row">
    <div class="col-6">
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('lat', 'Koordinat X') }}
                    {{ Form::text('lat',null,['placeholder'=>'Sila masukkan Lokasi/Koordinat','class' => 'form-control '.Html::isInvalid($errors,'lat')]) }}
                    {!! Html::hasError($errors,'lat') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('zon', 'Zon') }}
                    {{ Form::text('zon',null,['placeholder'=>'Sila masukkan Zon','class' => 'form-control '.Html::isInvalid($errors,'zon')]) }}
                    {!! Html::hasError($errors,'zon') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('tarikh', 'Tarikh Ditanam') }}
                    {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Tarikh Ditanam','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
                    {!! Html::hasError($errors,'tarikh') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('umur_pokok', 'Umur Pokok') }}
                    {{ Form::text('umur_pokok',null,['placeholder'=>'Sila masukkan Umur Pokok','class' => 'form-control '.Html::isInvalid($errors,'umur_pokok')]) }}
                    {!! Html::hasError($errors,'umur_pokok') !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('lng', 'Koordinat Y') }}
                    {{ Form::text('lng',null,['placeholder'=>'Sila masukkan Lokasi/Koordinat','class' => 'form-control '.Html::isInvalid($errors,'lng')]) }}
                    {!! Html::hasError($errors,'lng') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('kod_tag', 'Kod Tag') }}
                    {{ Form::text('kod_tag',null,['placeholder'=>'Sila masukkan Kod Tag','class' => 'form-control '.Html::isInvalid($errors,'kod_tag')]) }}
                    {!! Html::hasError($errors,'kod_tag') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('tahun_tanam', 'Tahun Ditanam') }}
                    {{ Form::text('tahun_tanam',null,['placeholder'=>'Sila masukkan Tahun Ditanam','class' => 'form-control '.Html::isInvalid($errors,'tahun_tanam')]) }}
                    {!! Html::hasError($errors,'tahun_tanam') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('kos_perolehan', 'Kos Perolehan') }}
                    {{ Form::text('kos_perolehan',null,['placeholder'=>'Sila masukkan Kos Perolehan','class' => 'form-control '.Html::isInvalid($errors,'kos_perolehan')]) }}
                    {!! Html::hasError($errors,'kos_perolehan') !!}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('taman_persekutuan', 'Taman Persekutuan') }}
                    {{ Form::text('taman_persekutuan',null,['placeholder'=>'Sila masukkan Taman Persekutuan','class' => 'form-control '.Html::isInvalid($errors,'taman_persekutuan')]) }}
                    {!! Html::hasError($errors,'taman_persekutuan') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('jenis', 'Jenis/Kategori') }}
            {{ Form::text('jenis',null,['placeholder'=>'Sila masukkan Jenis/Kategori','class' => 'form-control '.Html::isInvalid($errors,'jenis')]) }}
            {!! Html::hasError($errors,'jenis') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nama_botani', 'Nama Botani') }}
            {{ Form::text('nama_botani',null,['placeholder'=>'Sila masukkan Nama Botani','class' => 'form-control '.Html::isInvalid($errors,'nama_botani')]) }}
            {!! Html::hasError($errors,'nama_botani') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nama_tempatan', 'Nama Tempatan') }}
            {{ Form::text('nama_tempatan',null,['placeholder'=>'Sila masukkan Nama Tempatan','class' => 'form-control '.Html::isInvalid($errors,'nama_tempatan')]) }}
            {!! Html::hasError($errors,'nama_tempatan') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nama_keluarga', 'Nama Keluarga/Asal') }}
            {{ Form::text('nama_keluarga',null,['placeholder'=>'Sila masukkan Nama Keluarga/Asal','class' => 'form-control '.Html::isInvalid($errors,'nama_keluarga')]) }}
            {!! Html::hasError($errors,'nama_keluarga') !!}
        </div>
        <div class="form-group">
            {{ Form::label('negara_asal', 'Negara Asal') }}
            {{ Form::text('negara_asal',null,['placeholder'=>'Sila masukkan Negara Asal','class' => 'form-control '.Html::isInvalid($errors,'negara_asal')]) }}
            {!! Html::hasError($errors,'negara_asal') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('sumber_benih', 'Sumber Anak Benih') }}
            {{ Form::text('sumber_benih',null,['placeholder'=>'Sila masukkan Sumber Anak Benih','class' => 'form-control '.Html::isInvalid($errors,'sumber_benih')]) }}
            {!! Html::hasError($errors,'sumber_benih') !!}
        </div>

        <div class="form-group">
            {{ Form::label('jenis_akar', 'Jenis Akar') }}
            {{ Form::text('jenis_akar',null,['placeholder'=>'Sila masukkan Jenis Akar','class' => 'form-control '.Html::isInvalid($errors,'jenis_akar')]) }}
            {!! Html::hasError($errors,'jenis_akar') !!}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('cara_pembiakan', 'Cara Pembiakan') }}
            {{ Form::text('cara_pembiakan',null,['placeholder'=>'Sila masukkan Cara Pembiakan','class' => 'form-control '.Html::isInvalid($errors,'cara_pembiakan')]) }}
            {!! Html::hasError($errors,'cara_pembiakan') !!}
        </div>
        <div class="form-group">
            {{ Form::label('kategori_tumbuhan', 'Kategori Tumbuhan') }}
            {{ Form::text('kategori_tumbuhan',null,['placeholder'=>'Sila masukkan Kategori Tumbuhan','class' => 'form-control '.Html::isInvalid($errors,'kategori_tumbuhan')]) }}
            {!! Html::hasError($errors,'kategori_tumbuhan') !!}
        </div>
    </div>
</div>






<div class="form-group">
    {{ Form::label('fungsi_pokok', 'Fungsi Pokok') }}
    {{ Form::text('fungsi_pokok',null,['placeholder'=>'Sila masukkan Fungsi Pokok','class' => 'form-control '.Html::isInvalid($errors,'fungsi_pokok')]) }}
    {!! Html::hasError($errors,'fungsi_pokok') !!}
</div>
<div class="form-group">
    {{ Form::label('kegunaan_pokok', 'Kegunaan Pokok') }}
    {{ Form::text('kegunaan_pokok',null,['placeholder'=>'Sila masukkan Kegunaan Pokok','class' => 'form-control '.Html::isInvalid($errors,'kegunaan_pokok')]) }}
    {!! Html::hasError($errors,'kegunaan_pokok') !!}
</div>
<div class="form-group">
    {{ Form::label('keterangan', 'Keterangan Pokok') }}
    {{ Form::textarea('keterangan',null,['id'=>'summernote','placeholder'=>'Sila masukkan Keterangan Pokok','class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
    {!! Html::hasError($errors,'keterangan') !!}
</div>



@section('page-js-script')

<script>
    $(document).ready(function () {

        //Date picker
        $('input[name="tarikh"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
            maxDate: moment().endOf('month').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "up",
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('#modalFormSoftscape').validate({ //sets up the validator
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'lat' : 'required',
                'lng' : 'required',
                'kod_tag' : 'required',
                'zon' : 'required',
                'jenis' : 'required',
                'nama_botani' : 'required',
                'nama_tempatan' : 'required',
                'nama_keluarga' : 'required',
                'negara_asal' : 'required',
                'sumber_benih' : 'required',
                'taman_persekutuan' : 'required',
                'keterangan' : 'required',
                'tarikh' : 'required',
                'tahun_tanam' : 'required',
                'kos_perolehan' : 'required',
                'kategori_tumbuhan' : 'required',
                'umur_pokok' : 'required',
                'fungsi_pokok' : 'required',
                'kegunaan_pokok' : 'required',
                'cara_pembiakan' : 'required',
                'jenis_akar' : 'required',
                'tarikh_masa' : 'required',
            }
        });

    });

</script>


@endsection
