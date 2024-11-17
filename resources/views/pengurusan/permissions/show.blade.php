@extends('layouts.pengurusan.app')

@section('title', 'Kawalan Capaian')

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
                                    ['onclick'=>"window.location='".route('pengurusan.permissions.index')."'",'class'=>'btn
                                    btn-secondary']) !!}
                                    @can('role-edit')
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.permissions.edit',$permission)."'"
                                    ]) !!}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <dl class="row p-3">
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                                    <dt class='col-sm-4'>Nama</dt>
                                    <dd class='col-sm-6'>{!! $permission->name ?? $null !!}</dd>

                                    <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                                    <dd class='col-sm-6'>
                                        {{ $permission->created_at ? $permission->created_at->format('d/m/Y') : '-' }}
                                    </dd>

                                    <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                                    <dd class='col-sm-6'>
                                        {{ $permission->updated_at ? $permission->updated_at->format('d/m/Y') : '-' }}
                                    </dd>
                                </dl>
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
