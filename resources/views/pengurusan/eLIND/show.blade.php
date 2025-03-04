@extends('layouts.pengurusan.app')

@php
    $lastSegment = Request::segment(3);
    $capitalizedSegment = ucfirst($lastSegment);
    if ($capitalizedSegment == 'Pendidikan') {
        $capitalizedSegment = 'Institusi Pendidikan';
    }else if ($capitalizedSegment == 'Ngo') {
        $capitalizedSegment = 'NGO / Badan Ikhtisas';
    }else if ($capitalizedSegment == 'Antarabangsa') {
        $capitalizedSegment = 'Pertubuhan Antarabangsa';
    }
@endphp

@section('title', 'Lihat Maklumat ' . $capitalizedSegment)

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
                                    ['onclick'=>"window.location='".route('pengurusan.eLIND.index', ['type' => $lastSegment])."'",'class'=>'btn
                                    btn-secondary']) !!}
                                    @can('role-edit')
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.eLIND.edit', ['type' => $lastSegment, 'id' => $eLIND])."'"
                                    ]) !!}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <dl class="row p-3">
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                                    <dt class='col-sm-4'>Nama</dt>
                                    <dd class='col-sm-6'>{!! $eLIND->name ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Emel</dt>
                                    <dd class='col-sm-6'>{!! $eLIND->email ?? $null !!}</dd>

                                    <dt class='col-sm-4 text-capitalize'>Peranan</dt>
                                    <dd class='col-sm-6 text-capitalize'>
                                        @if(!empty($eLIND->getRoleNames()))
                                        @foreach($eLIND->getRoleNames() as $v)
                                        <label
                                            class="badge badge-success font-weight-normal">{{ $v }}</label>
                                        @endforeach
                                        @endif
                                    </dd>

                                    <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                                    <dd class='col-sm-6'>
                                        {{ $eLIND->created_at ? $eLIND->created_at->format('d/m/Y') : '-' }}</dd>

                                    <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                                    <dd class='col-sm-6'>
                                        {{ $eLIND->updated_at ? $eLIND->updated_at->format('d/m/Y') : '-' }}</dd>
                                </dl>
                            </div>
                        </div>

                    </div> -->
                    <div class="card-body table-hardscape form-hardscape text-sm">
                        <div >
                            @include('pengurusan.eLIND._form')
                        </div>
                        <!-- @include('pengurusan.eLIND._upload') -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection
