@extends('layouts.pengurusan.blank')

@section('title', 'Butiran Maklumat Asas')

@section('content')

<div class="modal-header card-olive card-outline d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
</div>
<!-- /.modal-header -->
<div class="modal-body">
    <dl class="row p-3">

        @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

        <dt class='col-sm-3'>Saiz Kanopi</dt>
        <dd class='col-sm-9'>{!! $record->saiz_kanopi ?? $null !!}</dd>

        <dt class='col-sm-3'>Keadaan Semasa</dt>
        <dd class='col-sm-9'>{!! $record->keadaan_semasa ?? $null !!}</dd>

        <dt class='col-sm-3'>Nilai Semasa</dt>
        <dd class='col-sm-9'>{!! $record->nilai_semasa ?? $null !!}</dd>

        <dt class='col-sm-3'>Status</dt>
        <dd class='col-sm-9'>{!! $record->status ?? $null !!}</dd>

        <dt class='col-sm-3'>Tarikh Daftarkan</dt>
        <dd class='col-sm-9'>{!! $record->created_at ? $record->created_at->format('d/m/Y') : '-' !!}</dd>

        <dt class='col-sm-3'>Tarikh Daftarkan</dt>
        <dd class='col-sm-9'>{!! $record->created_at ? $record->created_at->format('d/m/Y') : '-' !!}</dd>

        <dt class='col-sm-3'>Tarikh Dikemaskini</dt>
        <dd class='col-sm-9'>{!! $record->updated_at ? $record->updated_at->format('d/m/Y') : '-' !!}</dd>

    </dl>
</div>
<!-- /.modal-body -->
<div class="modal-footer">
    {!! Form::button('Batal', ['class'=>'btn btn-secondary','data-dismiss'=>'modal']) !!}
</div>
<!-- /.modal-footer -->
{!! Form::close() !!}
@endsection
