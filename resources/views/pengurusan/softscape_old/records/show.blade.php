@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat Asas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    @include('pengurusan.softscape._pill_nav')
                </div>

                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('title') </h5>
                        <div class="py-1">
                            {!! Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.softscapes.record.index',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.softscapes.record.edit',$record)."'",'class'=>'btn btn-warning']) !!}
                        </div>
                    </div>

                    <dl class="row p-3">
                        @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                        <dt class='col-sm-3'>Saiz Kanopi</dt>
                        <dd class='col-sm-9'>{!! $record->saiz_kanopi ?? $null !!}</dd>

                        <dt class='col-sm-3'>Nilai Semasa</dt>
                        <dd class='col-sm-9'>{!! $record->nilai_semasa ?? $null !!}</dd>

                        <dt class='col-sm-3'>Keadaan Semasa</dt>
                        <dd class='col-sm-9'>{!! $record->keadaan_semasa ?? $null !!}</dd>

                        <dt class='col-sm-3'>Tarikh Rekod</dt>
                        <dd class='col-sm-9'>{!! $record->tarikh ? $record->tarikh : '-' !!}</dd>

                        <dt class='col-sm-3'>Tarikh Daftarkan</dt>
                        <dd class='col-sm-9'>{!! $record->created_at ? $record->created_at->format('d/m/Y') : '-' !!}</dd>

                        <dt class='col-sm-3'>Tarikh Daftarkan</dt>
                        <dd class='col-sm-9'>{!! $record->created_at ? $record->created_at->format('d/m/Y') : '-' !!}</dd>

                        <dt class='col-sm-3'>Tarikh Dikemaskini</dt>
                        <dd class='col-sm-9'>{!! $record->updated_at ? $record->updated_at->format('d/m/Y') : '-' !!}</dd>

                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

