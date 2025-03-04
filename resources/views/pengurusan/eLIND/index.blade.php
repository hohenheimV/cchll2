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

@section('title', $capitalizedSegment)

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col">
                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                                <div class="input-group mr-2">
                                    {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Carian Pantas','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                    <div class="input-group-append">
                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                        'class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                        {!! Form::button('Reset',
                                        ['onclick'=>"window.location='".route('pengurusan.eLIND.index', ['type' => '' . strtolower($lastSegment) . ''])."'",
                                        'class'=>'btn btn-secondary btn-sm']) !!}
                                    </div>
                                </div>
                                {{ Form::close() }}

                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                    'class'=>'btn btn-success btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.eLIND.create', ['type' => strtolower($lastSegment)])."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle text-center wpx-50">No</th>
                                        <th class="align-middle">Nama</th>
                                        <th class="align-middle">Emel</th>
                                        <th class="align-middle">Peranan</th>
                                        <th class="text-center align-middle wpx-100" style="display: none;">Tarikh Daftar</th>
                                        <th class="text-center align-middle wpx-100">Prestasi</th>
                                        <th class="align-middle text-center wpx-100">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        //dd($eLIND[0]->getRoleNames());
                                    @endphp
                                    @php($prestasi = [
                                        ['id' => 'Sangat Baik', 'label' => 'bg-success'],
                                        ['id' => 'Baik', 'label' => 'bg-primary'],
                                        ['id' => 'Sederhana', 'label' => 'bg-warning'],
                                        ['id' => 'Lemah', 'label' => 'bg-danger']
                                    ])
                                    @php($prestasi_count = count($prestasi))

                                    @php($index = $eLIND->firstItem() ?? $eLIND->first())
                                    @forelse($eLIND as $user)
                                    <tr>
                                        <td class="text-center">{{ $index++ }}</td>
                                        <td>{{ $capitalizedSegment. ' ' . ($index - 1) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $capitalizedSegment }}</span>
                                        </td>
                                        <td style="display: none;" class="text-center">{!! Html::datetime($user->created_at,'d-m-Y') !!}
                                        </td>
                                        <td class="text-center">
                                            <span  class="badge {{ $prestasi[($index - 2) % $prestasi_count]['label'] }}" style="white-space: normal; text-align: centre;width: 100%;">
                                                {{ $prestasi[($index - 2) % $prestasi_count]['id'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                            {{-- $eLIND[0] --}}
                                                {!! Form::button('<i class="fas fa-search"></i>', [
                                                'class'=>'btn btn-info btn-sm',
                                                'onclick'=>"window.location='".route('pengurusan.eLIND.show', ['type' => $lastSegment, 'id' => $user])."'"
                                                ]) !!}
                                                @can('user-edit')
                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                'class'=>'btn btn-warning btn-sm',
                                                'onclick'=>"window.location='".route('pengurusan.eLIND.edit', ['type' => $lastSegment, 'id' => $user])."'"
                                                ]) !!}
                                                @endcan
                                                @can('user-delete')
                                                {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                                'data-url'=>route('pengurusan.eLIND.destroy', ['type' => $lastSegment, 'id' => $user]),
                                                'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                                @endcan
                                                {!! Form::button('<i class="fas fa-sticky-note"></i>', ['class'=>'btn btn-success btn-sm',
                                                'data-url'=>route('pengurusan.eLIND.destroy', ['type' => $lastSegment, 'id' => $user]),
                                                'data-toggle'=>'modal','data-target'=>'#modalKomenPrestasi']) !!}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    {!! Html::forelse_alert(request('keyword'),'User') !!}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    @if(count($eLIND) > 0)
                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                        {!! Html::pagination($eLIND) !!}
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
