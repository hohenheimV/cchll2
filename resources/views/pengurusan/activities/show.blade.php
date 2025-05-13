@extends('layouts.pengurusan.app')

@section('title', 'Butiran Permohonan Aktiviti')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('Kembali',
                                    ['onclick'=>"window.location='".route('pengurusan.activities.index')."'",'class'=>'btn
                                    btn-secondary']) !!}
                                    @can('role-edit')
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.activities.edit',$activity)."'"
                                    ]) !!}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        @php
                        $path = 'files/activity/' . $activity->id . '/';
                        @endphp
                        <div class="row">
                            <div class="col-6">
                                <dl class="row p-3">
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                                    <dt class='col-sm-4'>Rujukan Permohonan</dt>
                                    <dd class='col-sm-6 font-weight-bold'>{!! $activity->ref_num ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Nama Pemohon</dt>
                                    <dd class='col-sm-6'>{!! $activity->name ?? $null !!}</dd>

                                    <dt class='col-sm-4'>E-mel Pemohon</dt>
                                    <dd class='col-sm-6'>{!! $activity->email ?? $null !!}</dd>

                                    <dt class='col-sm-4'>No Telefon Pemohon</dt>
                                    <dd class='col-sm-6'>{!! $activity->phone ?? $null !!}</dd>

                                    <!--<dt class='col-sm-4'>No Fax Pemohon</dt>
                                    <dd class='col-sm-6'>{!! $activity->fax ?? $null !!}</dd>-->

                                    <dt class='col-sm-4'>Nama Penganjur</dt>
                                    <dd class='col-sm-6'>{!! $activity->organizer ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Tarikh Mohon</dt>
                                    <dd class='col-sm-6'>
                                        <span class="badge badge-info">
                                            <h6 class="m-0">{!! $activity->created_at->format('d-m-Y')!!}</h6>
                                        </span>
                                    </dd>

                                    <dt class='col-sm-4'>Tarikh Mula-Tamat</dt>
                                    <dd class='col-sm-6'>
                                        <span class="badge badge-info">
                                            <h6 class="m-0">{!! $activity->start_at->format('d-m-Y')!!}</h6>
                                        </span>
                                        {{'hingga'}}
                                        <span class="badge badge-info">
                                            <h6 class="m-0">{!! $activity->end_at->format('d-m-Y')!!}</h6>
                                        </span>
                                    </dd>

                                    <dt class='col-sm-4'>Masa</dt>
                                    <dd class='col-sm-6'>
                                        <span class="badge badge-primary">
                                            <h6 class="m-0">{!! $activity->tempoh_id ? $activity->slot : 'Tiada Maklumat' !!}</h6>
                                        </span>
                                    </dd>

                                    <dt class='col-sm-4'>Lokasi</dt>
                                    <dd class='col-sm-6'>
                                        <p class="text-uppercase font-weight-bold m-0">{!! $activity->lokasi ? $activity->zon : 'Tiada Maklumat' !!}</p>
                                        <p class="m-0">{!! $activity->zones['label'] !!}</p>
                                        <p>{!! $activity->zones['text'] !!}</p>
                                    </dd>

                                    <dt class='col-sm-4'>Nama Program/Aktiviti</dt>
                                    <dd class='col-sm-6'>{!! $activity->title ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Ringkasan Aktiviti</dt>
                                    <dd class='col-sm-6'>{!! $activity->description ?? $null !!}</dd>

                                   
                                    <dt class='col-sm-4'>Surat Permohonan Rasmi</dt>
                                    <dd class='col-sm-6'>
                                        @if ($activity->form_surat && Storage::disk('public')->exists($path . $activity->form_surat))
                                        {!! Form::button('<i class="fas fa-file"></i> Surat',
                                        ['onclick'=>"window.location='".route('pengurusan.activities.download',[
                                        'type' => 'surat','activity'=>$activity])."'",
                                        'class'=>'btn bg-indigo']) !!}
                                        @else
                                        {!! $null !!}
                                        @endif
                                    </dd>
                                    <dt class='col-sm-4'>Jadual Program/Aktiviti</dt>
                                    <dd class='col-sm-6'>
                                        @if ($activity->form_jadual && Storage::disk('public')->exists($path . $activity->form_jadual))
                                        {!! Form::button('<i class="fas fa-file"></i> Jadual',
                                        ['onclick'=>"window.location='".route('pengurusan.activities.download',[
                                        'type' => 'jadual','activity'=>$activity])."'",
                                        'class'=>'btn bg-indigo']) !!}
                                        @else
                                        {!! $null !!}
                                        @endif
                                    </dd>
									<dt class='col-sm-4'>Senarai Maklumat Peserta</dt>
                                    <dd class='col-sm-6'>
                                        @if ($activity->form_attachment && Storage::disk('public')->exists($path . $activity->form_attachment))
                                        {!! Form::button('<i class="fas fa-file"></i> Senarai',
                                        ['onclick'=>"window.location='".route('pengurusan.activities.download',[
                                        'type' => 'borang','activity'=>$activity])."'",
                                        'class'=>'btn bg-indigo']) !!}
                                        @else
                                        {!! $null !!}
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-6">
                                <div class="bg-gray p-3">
                                    <dl class="row p-3">

                                        <dt class='col-sm-4'>Status</dt>
                                        <dd class='col-sm-6'>
                                            <span class="badge badge-info">
                                                <h6 class="m-0">{!! $activity->status ?? $null !!}</h6>
                                            </span>
                                        </dd>

                                        <dt class='col-sm-4'>Tarikh Kelulusan</dt>
                                        <dd class='col-sm-6'>{!! $activity->approved_at ? $activity->approved_at->format('d/m/Y') : $null !!}</dd>

                                        <dt class='col-sm-4'>Dokumen Diluluskan</dt>
                                        <dd class='col-sm-6'>

                                            @if ($activity->approved_attachment && Storage::disk('public')->exists($path . $activity->approved_attachment))
                                            {!! Form::button('<i class="fas fa-file"></i> Dokumen Kelulusan',
                                            ['onclick'=>"window.location='".route('pengurusan.activities.download',[
                                            'type' => 'kelulusan','activity'=>$activity])."'",
                                            'class'=>'btn bg-purple']) !!}
                                            @else
                                            {!! $null !!}
                                            @endif
                                        </dd>

                                        <dt class='col-sm-4'>Nama Pegawai</dt>
                                        <dd class='col-sm-6'>{!! $activity->officer ?? $null !!}</dd>

                                        <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                                        <dd class='col-sm-6'>
                                            {{ $activity->created_at ? $activity->created_at->format('d/m/Y') : '-' }}
                                        </dd>

                                        <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                                        <dd class='col-sm-6'>
                                            {{ $activity->updated_at ? $activity->updated_at->format('d/m/Y') : '-' }}
                                        </dd>
                                    </dl>
                                </div>
                                <div class="bg-gray my-3">
                                    <dl class="row p-3">
                                        <dt class='col-sm-4'>Catatan Pengurus Taman</dt>
                                        <dd class='col-sm-6'>{!! $activity->note_officer_lvl_1 ?? $null !!}</dd>

                                    </dl>
                                </div>

                                <div class="bg-gray my-3">
                                    <dl class="row p-3">

                                        <dt class='col-sm-4'>Catatan Pengarah Taman</dt>
                                        <dd class='col-sm-6'>{!! $activity->note_officer_lvl_2 ?? $null !!}</dd>

                                    </dl>
                                </div>

                                <div class="bg-gray my-3">
                                    <dl class="row p-3">

                                        <dt class='col-sm-4'>Catatan KP/ TKP JLN</dt>
                                        <dd class='col-sm-6'>{!! $activity->note_officer_lvl_3 ?? $null !!}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection
