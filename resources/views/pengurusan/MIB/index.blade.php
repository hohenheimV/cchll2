@extends('layouts.pengurusan.app')

@section('title', 'Rakan Taman')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Carian Pantas','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.MIB.index')."'",'class'=>'btn
                                    btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                'class'=>'btn btn-success btn-sm',
                                'onclick'=>"window.location='".route('pengurusan.MIB.create')."'",
                                Html::tooltip('Daftar')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-5"></th>
                                    <th class="text-center align-middle w-8">No Permohonan</th>
                                    <th class="text-center align-middle w-8">Tarikh Mohon</th>
                                    <th class="text-center align-middle">Nama/E-Mel</th>
                                    <th class="text-center align-middle">Taman Perumahan</th>
                                    <th class="text-center align-middle wpx-7">Status</th>
                                    <th class="text-center align-middle w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                @php($index = $MIB->firstItem())
                                @forelse($MIB as $rakan_taman)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                        <span class="badge badge-dark">
                                            {!! $rakan_taman->ref_num ?? $null !!}
                                        </span>
                                    </td>
                                    <td class="text-center">{!! $rakan_taman->created_at->format('d-m-Y') !!}</td>
                                    <td>{!! $rakan_taman->name.'<br />'.$rakan_taman->email !!}</td>
                                    <td>{{ $rakan_taman->taman }}</td>
                                    <td>{!! '<span class="badge badge-primary">'.$rakan_taman->status.'</span>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>', [
                                            'class'=>'btn btn-info btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.MIB.show',$rakan_taman)."'"
                                            ]) !!}
                                            @can('rakan_taman-edit')
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                            'class'=>'btn btn-warning btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.MIB.edit',$rakan_taman)."'"
                                            ]) !!}
                                            @endcan
                                            @can('rakan_taman-delete')
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger
                                            btn-sm',
                                            'data-url'=>route('pengurusan.MIB.destroy',$rakan_taman->id),
                                            'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Kategori') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($MIB->count() > 0)
                <div
                    class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($MIB) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
