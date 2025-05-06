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
                                {{-- Form::open(['class'=>'form-inline','method' => 'get']) }}
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
                                {{ Form::close() --}}
                                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|TKP/B JLN'))
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                    'class'=>'btn btn-success btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.eLIND.create', ['type' => strtolower($lastSegment)])."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center w-1">No</th>
                                        <th class="text-center w-15">Nama</th>
                                        <th class="text-center w-10">Emel</th>
                                        @if(Auth::user()->hasRole('TKP/B JLN|Pegawai|Pentadbir Sistem'))
                                        <th class="text-center w-5" style="display: none;">Tarikh Daftar</th>
                                        <th class="text-center w-5">Prestasi</th>
                                        @endif
                                        <th class="text-center w-5">Paparan Portal</th>
                                        <th class="text-center w-5">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|Penggiat Industri|TKP/B JLN'))
                                        @php
                                            //dd($eLIND[0]->getRoleNames());
                                        @endphp
                                        @php($prestasi = [
                                            ['id' => 'Sangat Baik', 'label' => 'bg-success'],
                                            ['id' => 'Baik', 'label' => 'bg-primary'],
                                            ['id' => 'Sederhana', 'label' => 'bg-warning'],
                                            ['id' => 'Lemah', 'label' => 'bg-danger'],
                                            ['id' => 'Tiada Maklumat', 'label' => 'bg-danger']
                                        ])
                                        @php($prestasi_count = count($prestasi))

                                        @php($paparan_portal = [
                                            ['id' => 'Aktif', 'label' => 'bg-success'], // Green background for approved
                                            ['id' => 'Tidak Aktif', 'label' => 'bg-danger'], // Red background for failed
                                        ])
                                        @php($status_count = count($paparan_portal))

                                        @php($index = $eLIND->firstItem() ?? $eLIND->first())
                                        @forelse($eLIND as $user)
                                        <tr>
                                            <td class="text-center">{{ $index++ }}</td>
                                            <td>{{ strtoupper($user->name) }}</td>
                                            <td>{{ $user->email }}</td>
                                            @if(Auth::user()->hasRole('TKP/B JLN|Pegawai|Pentadbir Sistem'))
                                                <td style="display: none;" class="text-center">{!! Html::datetime($user->created_at,'d-m-Y') !!}
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        if($user->prestasi != null){
                                                            $dataprestasi = json_decode($user->prestasi, true);
                                                            $prestasiDB = end($dataprestasi)['prestasi'] ?? 5;
                                                        }else{
                                                            $prestasiDB = 5;
                                                        }

                                                        if($user->komen != null){
                                                            $datakomen = json_decode($user->komen, true);
                                                            $komenDB = end($datakomen)['komen'] ?? null;
                                                        }else{
                                                            $komenDB = null;
                                                        }
                                                    ?>
                                                    <span  class="badge {{ $prestasi[$prestasiDB-1 ?? '4']['label'] }}" style="white-space: normal; text-align: centre;width: 100%;" data-toggle="tooltip" data-tooltip="tooltip" data-placement="top" data-original-title="{{ $komenDB ?? 'Tiada Komen' }}">
                                                        {{ $prestasi[$prestasiDB-1 ?? '4']['id'] }}
                                                    </span>
                                                </td>
                                            @endif
                                                <td>
                                                    @if(Auth::user()->hasRole('Penggiat Industri'))
                                                        <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$user->status == 'approved' ? 0 : 1]['label'] }}">{{ $user->status == 'approved' ? 'Perubahan telah disahkan' : 'Perubahan belum disahkan' }}</span>
                                                    @else
                                                        <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$user->status == 'approved' ? 0 : 1]['label'] }}">{{ $paparan_portal[$user->status == 'approved' ? 0 : 1]['id'] }}</span>
                                                    @endif
                                                </td>
                                            <td>
                                                <div class="btn-group">
                                                {{-- $eLIND[0] --}}

                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                    'class'=>'btn btn-info btn-sm',
                                                    'onclick'=>"window.location='".route('pengurusan.eLIND.show', ['type' => $lastSegment, 'id' => $user])."'"
                                                    ]) !!}

                                                    @if((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN|Penggiat Industri')))
                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'class'=>'btn btn-warning btn-sm',
                                                        'onclick'=>"window.location='".route('pengurusan.eLIND.edit', ['type' => $lastSegment, 'id' => $user])."'"
                                                        ]) !!}
                                                    @endif

                                                    @if((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN')))
                                                        {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                                        'data-url'=>route('pengurusan.eLIND.destroy', ['type' => $lastSegment, 'id' => $user]),
                                                        'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                                    @endif

                                                    @if((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN|Pegawai')))
                                                        {!! Form::button('<i class="fas fa-sticky-note"></i>', 
                                                            ['class' => 'btn btn-success btn-sm', 
                                                            'data-elind-id' => $user->id_elind,
                                                            'data-toggle' => 'modal', 
                                                            'data-target' => '#modalKomenPrestasi', 
                                                        ])  !!}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        {!! Html::forelse_alert(request('keyword'),'Penggiat Industri') !!}
                                        @endforelse
                                    @endif
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
