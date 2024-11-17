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
                               <!-- {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                                <div class="input-group mr-2">
                                    {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Carian Pantas','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                    <div class="input-group-append">
                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                        'class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                        {!! Form::button('Reset',
                                        ['onclick'=>"window.location='".route('pengurusan.permissions.index')."'",
                                        'class'=>'btn btn-secondary btn-sm']) !!}
                                    </div>
                                </div>
                                {{ Form::close() }}
								</div>

                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                    'class'=>'btn btn-success btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.permissions.create')."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3">
                            @forelse($permissionsNew as $name => $permission)
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header bg-dark">
                                        <h5 class="card-title text-capitalize">{{$name}}</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        @foreach ($permission as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                                            <span>{{ $item->name }}</span>
                                            <!-- Default dropleft button -->
                                            <div class="btn-group dropleft">
                                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu">

                                                    <!-- Dropdown menu links -->
                                                    {!! Form::button('<i class="fas fa-search"></i> Butiran', [
                                                    'class'=>'dropdown-item btn btn-info btn-sm',
                                                    'onclick'=>"window.location='".route('pengurusan.permissions.show',$item)."'"
                                                    ]) !!}
                                                    @can('permission-edit')
                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                                    'class'=>'dropdown-item btn btn-warning btn-sm',
                                                    'onclick'=>"window.location='".route('pengurusan.permissions.edit',$item)."'"
                                                    ]) !!}
                                                    @endcan
                                                    @can('permission-delete')
                                                    {!! Form::button('<i class="fas fa-trash"></i> Hapus', [
                                                    'class'=>'dropdown-item btn btn-danger btn-sm',
                                                    'data-url'=>route('pengurusan.permissions.destroy',$item->id),
                                                    'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                                    @endcan
                                                </div>

                                            </div>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @empty
                            {!! Html::forelse_alert(request('keyword'),'Permissions') !!}
                            @endforelse
                        </div>
                    </div>
                    <!-- /.card-body -->
                    @if(count($permissions) > 0)
                    <div
                        class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                        {!! Html::pagination($permissions) !!}
                    </div>
                    <!-- /.card-footer -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection
