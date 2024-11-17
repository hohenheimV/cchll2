@extends('layouts.pengurusan.app')

@section('title', 'Butiran Peranan')

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
                                    ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",'class'=>'btn
                                    btn-secondary']) !!}
                                    @can('role-edit')
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.roles.edit',$role)."'"
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
                                    <dd class='col-sm-6'>{!! $role->name? ucwords(str_replace('-', ' ',$role->name)) : null !!}</dd>

                                    <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                                    <dd class='col-sm-6'>
                                        {{ $role->created_at ? $role->created_at->format('d/m/Y') : '-' }}</dd>

                                    <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                                    <dd class='col-sm-6'>
                                        {{ $role->updated_at ? $role->updated_at->format('d/m/Y') : '-' }}</dd>
                                </dl>
                                <p class="font-weight-bold">Kawalan</p>
                                <dl class="row p-3">
                                    @foreach($permissions as $name => $permission)
                                    <dt class='col-sm-4 text-capitalize border-top'>{{$name}}</dt>
                                    <dd class='col-sm-6 text-capitalize border-top'>
                                        @foreach ($permission as $item)
                                        <label class="badge badge-success font-weight-normal">
                                                {{ preg_replace("/^(\w+\s)/", "", str_replace('-',' ',$item->name)) }}
                                        </label>
                                        @endforeach
                                    </dd>
                                    @endforeach
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
