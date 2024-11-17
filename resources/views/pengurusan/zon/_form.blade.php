<div class="form-group">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
            style="width: 0%"></div>
    </div>
</div>
<div class="form-group">
    {{ Form::label('tajuk', 'Maklumat Zon') }}
    {{ Form::text('tajuk', null, ['placeholder' => 'Sila masukkan Maklumat Zon', 'class' => 'form-control ' . Html::isInvalid($errors, 'tajuk')]) }}
    {!! Html::hasError($errors, 'tajuk') !!}
</div>
<div class="form-group">
    {{ Form::label('lokasi', 'Lokasi') }}
    {{ Form::select('lokasi', [
    'zona_a_0' => 'Tempat Letak Kereta',
    'zona_a_1' => 'Kawasan Open Plaza 2nd Ent',
    'zona_a_2' => 'Kawasan Lapang Signage Zon Rekreasi Keluarga',
    'zona_b_0' => 'Kawasan 1st Gazebo Di Kiri Jalan',
    'zona_b_1' => 'Kawasan Sebelah 1st Gazebo Kawasan Lapang',
    'zona_c_0' => 'Dataran Plaza',
    'zona_c_1' => 'Kawasan Tepi Sungai',
    'zona_c_2' => 'Kawasan Permainan Kanak-kanak',
    'zona_c_3' => 'Kawasan Exercise Decking Platform',
    'zona_c_4' => 'Kawasan Family Timber Decking',
    'zona_c_5' => 'Kawasan Viewing Deck Small Space',
    'zona_c_6' => 'Kawasan Gazebo Sebelah Permainan Kanak-Kanak',
    'zonc_a_0' => 'Kawasan Laluan Jungle Trekking',
    'zonc_a_1' => 'Laluan Aktiviti Basikal. Mountain Bike Race Route',
    'zonc_a_2' => 'Kawasan Laluan Trek Denai Keladi',
    'zonc_a_3' => 'Kawasan Taman Hawa',
    'zonc_a_4' => 'Kawasan Viewing Area From Top',
    'zonc_a_5' => 'Kawasan Laluan Trail Trekking Pos B',
    ], 'lokasi', ['class' => 'form-control ' . Html::isInvalid($errors, 'lokasi')]) }}
    {!! Html::hasError($errors,'lokasi') !!}
</div>
<div class="form-group">
    {{ Form::label('tarikh', 'Tarikh Imej Diambil') }}
    {{ Form::text('tarikh', null, ['autocomplete'=>'off','placeholder' => 'Sila masukkan tarikh', 'class' => 'form-control tarikh ' . Html::isInvalid($errors, 'tarikh')]) }}
    {!! Html::hasError($errors, 'tarikh') !!}
</div>

