@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumbalas')

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
                                    ['onclick'=>"window.location='".route('pengurusan.MIB.index')."'",'class'=>'btn
                                    btn-secondary']) !!}
                                    @can('role-edit')
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.MIB.edit',$MIB)."'"
                                    ]) !!}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" inert>
                        @include('pengurusan.MIB._form')


                        <!-- <div class="row">
                            <div class="col-6">
                                <dl class="row p-3">
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                                    <dt class='col-sm-4'>Tarikh Maklumbalas</dt>
                                    <dd class='col-sm-6'>
                                        <span class="badge badge-info">
                                            <h6 class="m-0">{!! $MIB->feedback_at->format('d-m-Y')!!}</h6>
                                        </span>
                                    </dd>

                                    <dt class='col-sm-4'>Rujukan Maklumbalas</dt>
                                    <dd class='col-sm-6 font-weight-bold'>{!! $MIB->ref_num ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Nama Pengguna</dt>
                                    <dd class='col-sm-6'>{!! $MIB->name ?? $null !!}</dd>

                                    <dt class='col-sm-4'>E-mel Pengguna</dt>
                                    <dd class='col-sm-6'>{!! $MIB->email ?? $null !!}</dd>

                                    <dt class='col-sm-4'>No Telefon Pengguna</dt>
                                    <dd class='col-sm-6'>{!! $MIB->phone ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Mesej</dt>
                                    <dd class='col-sm-6'>{!! $MIB->message ?? $null !!}</dd>

                                </dl>
                                <div class="bg-gray p-3">
                                    <dl class="row p-3">

                                        <dt class='col-sm-4'>Status</dt>
                                        <dd class='col-sm-6'>
                                            <span class="badge badge-info">
                                                <h6 class="m-0">{!! $MIB->status ?? $null !!}</h6>
                                            </span>
                                        </dd>

                                        <dt class='col-sm-4'>Tarikh Tindakan</dt>
                                        <dd class='col-sm-6'>{!! $MIB->response_at ? $MIB->response_at->format('d/m/Y') : $null !!}</dd>

                                        <dt class='col-sm-4'>Dokumen Tindakan</dt>
                                        <dd class='col-sm-6'>
                                            @if ($MIB->form_attachment)
                                            {!! Form::button('<i class="fas fa-file"></i> Dokumen Tindakan',
                                            ['onclick'=>"window.location='".route('pengurusan.MIB.download',['feedback'=>$MIB])."'",
                                            'class'=>'btn bg-purple']) !!}
                                            @else
                                            {!!  $null !!}
                                            @endif
                                        </dd>

                                        <dt class='col-sm-4'>Nama Pegawai</dt>
                                        <dd class='col-sm-6'>{!! $MIB->officer ?? $null !!}</dd>

                                        <dt class='col-sm-4'>Catatan</dt>
                                        <dd class='col-sm-6'>{!! $MIB->notes ?? $null !!}</dd>

                                        <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                                        <dd class='col-sm-6'>
                                            {{ $MIB->created_at ? $MIB->created_at->format('d/m/Y') : '-' }}
                                        </dd>
                                        <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                                        <dd class='col-sm-6'>
                                            {{ $MIB->updated_at ? $MIB->updated_at->format('d/m/Y') : '-' }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection
