@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Permohonan Projek Landskap')

@section('content')

@php
    //dd(auth()->user()->roles, auth()->user()->permissions);
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                @if(Auth::user()->hasRole('KP/ TKP JLN|Pentadbir Sistem') || (Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 6))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan KP/TKP/B. Penilaian] --}}</h3>
                
                @elseif(Auth::user()->hasRole('Pegawai|Pentadbir Sistem'))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan Pegawai JLN] --}}</h3>
                @elseif(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan PBT] --}}</h3>
                @endif
                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.eLAPS.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Permohonan Projek Landskap')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <th>Tajuk Permohonan</th>
                                    <th class="w-15">Jenis Permohonan</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                        <th class="text-center w-10">PBT</th>
                                    @endif
                                    <th class="text-center w-5">Tarikh Permohonan</th>
                                    <th class="text-center w-12">Status</th>
                                    <th class="text-center w-5">Tindakan</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php($jenis_pembangunan = [
                                    'Taman Awam',
                                    'Taman Botani',
                                    'Pemuliharaan Dan Penyelidikan Landskap',
                                    'Landskap Perbandaran',
                                    'Persekitaran Kehidupan',
                                    'Penyelenggaraan Landskap',
                                    'Taman Persekutuan',
                                    'Naik Taraf Taman Awam',
                                    'Pelan Induk Landskap',
                                    'Lain-lain (sila nyatakan)'
                                ])
                                @php($jenis_count = count($jenis_pembangunan))
                                @php($index = $eLAPS->firstItem())
                                @php($status_pembangunan = [
                                    ['id' => 'Draf Permohonan', 'label' => 'bg-warning'], //1
                                    ['id' => 'Permohonan diterima', 'label' => 'bg-info'], //2
                                    ['id' => 'Pengesahan Permohonan', 'label' => 'bg-primary'], //3
                                    ['id' => 'Permohonan ditolak', 'label' => 'bg-danger'], //4
                                    ['id' => 'Serahan Permohonan ke Bahagian', 'label' => 'bg-secondary'], //5
                                    ['id' => 'Lawatan Kawasan Tapak', 'label' => 'bg-success'], //6
                                    ['id' => 'Draf Ulasan', 'label' => 'bg-warning'], //7
                                    ['id' => 'Ulasan diterima', 'label' => 'bg-info'], //8
                                    ['id' => 'Permohonan dalam pertimbangan', 'label' => 'bg-primary'], //9
                                    ['id' => 'Permohonan Lengkap', 'label' => 'bg-success'], //10
                                    ['id' => 'Permohonan Tidak Lengkap', 'label' => 'bg-danger'], //11
                                    ['id' => 'Projek Dalam Pelaksanaan', 'label' => 'bg-secondary'], //12
                                    ['id' => 'Projek Batal', 'label' => 'bg-dark'], //13
                                    ['id' => 'Projek Siap', 'label' => 'bg-success'] //14
                                ])
                                @php($status_count = count($status_pembangunan))

                                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|Pihak Berkuasa Tempatan|KP/ TKP JLN'))
                                    @forelse($eLAPS as $permohonan)
                                        @if(!($permohonan->status_permohonan == 1 && ((Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 6) || Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))))
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ strtoupper($permohonan->projectTitle) }}</td>
                                            
                                            <td>
                                            {!! 
                                                in_array($permohonan->category, $jenis_pembangunan) ? strtoupper($permohonan->category) : '<span class="badge bg-warning">' . strtoupper($permohonan->category) . '</span>'
                                            !!}
                                            </td>
                                            @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem'))
                                            <td>
                                                {{ strtoupper($permohonan->pbt_name) }}
                                            </td>
                                            @endif
                                            <td class="text-center">
                                                {!! Html::datetime($permohonan->created_at, 'd-m-Y') ? Html::datetime($permohonan->created_at, 'd-m-Y') : '-' !!}
                                            </td>
                                            <td> 
                                                @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                                                    @php($currentStatus = ($permohonan->status_permohonan <= 8 && $permohonan->status_permohonan > 3) ? 3 : $permohonan->status_permohonan)
                                                @else
                                                    @php($currentStatus = $permohonan->status_permohonan)
                                                @endif
                                                <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $status_pembangunan[($currentStatus - 1) % $status_count]['label'] }}">{{ $status_pembangunan[($currentStatus - 1) % $status_count]['id'] }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    
                                                    @if($permohonan->status_permohonan >= 2)
                                                        {!! Form::button('<i class="fas fa-search"></i>',
                                                            ['onclick'=>"window.location='".route('pengurusan.eLAPS.show',$permohonan)."'",
                                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran permohonan')
                                                        ]) !!}
                                                    @endif

                                                    @if($permohonan->status_permohonan == 1 && (Auth::user()->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem') || Auth::user()->id == $permohonan->id_pemohon ))
                                                        {!! 
                                                            Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                                'onclick' => "window.location='".route('pengurusan.eLAPS.edit', $permohonan)."'",
                                                                'class' => 'btn bg-warning btn-sm',
                                                                'data-toggle' => 'tooltip',
                                                                Html::tooltip('Kemaskini Draf Permohonan')
                                                            ]) 
                                                            .
                                                            Form::button('<i class="fas fa-trash"></i>', [
                                                                'class' => 'btn btn-danger btn-sm',
                                                                'data-url' => route('pengurusan.eLAPS.destroy', $permohonan),
                                                                'data-toggle' => 'modal',
                                                                'data-target' => '#modalDelete',
                                                                Html::tooltip('Padam Draf Permohonan')
                                                            ]) 
                                                        !!}
                                                    {{-- @elseif(($permohonan->status_permohonan == 3 && (Auth::user()->hasRole('KP/ TKP JLN') || (Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 6))) || (Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 7 && $permohonan->status_permohonan >= 3))
                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                            'class' => 'btn btn-warning btn-sm', 
                                                            'data-toggle'=>'modal', 
                                                            'data-target'=>'#modalSerahan', 
                                                            'data-elaps-id' => $permohonan->id, 
                                                            Html::tooltip('Serahan kepada bahagian')
                                                        ]) !!} --}}
                                                    @elseif(($permohonan->status_permohonan == 8 || $permohonan->status_permohonan == 9) && (Auth::user()->hasRole('Pentadbir Sistem|Pegawai')))
                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', 
                                                            ['class'=>'btn btn-warning btn-sm', Html::tooltip('Kemaskini Status Permohonan'),
                                                            'data-toggle'=>'modal', 
                                                            'data-target'=>'#modalKeputusan', 
                                                            'data-elaps-id' => $permohonan->id
                                                        ]) !!}
                                                    @elseif(($permohonan->status_permohonan == 10 || $permohonan->status_permohonan == 12) && ((Auth::user()->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem') || Auth::user()->id == $permohonan->id_pemohon) || (Auth::user()->hasRole('Pegawai') && (Auth::user()->bahagian_jln == 6 || Auth::user()->bahagian_jln == $permohonan->bahagian_jln))))
                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', 
                                                            ['class' => 'btn btn-warning btn-sm', 
                                                            'data-elaps-id' => $permohonan->id,
                                                            'data-text'=> $permohonan->status_permohonan, 
                                                            'data-toggle' => 'modal', 
                                                            'data-target' => '#modalStatusProjek', 
                                                            Html::tooltip('Kemaskini Status Projek')
                                                        ])  !!}
                                                    {{--@elseif($permohonan->status_permohonan == 14 && (Auth::user()->hasRole('Pentadbir Sistem|Pegawai')))
                                                        @if(in_array($permohonan->category, [$jenis_pembangunan[0],$jenis_pembangunan[1],$jenis_pembangunan[3],$jenis_pembangunan[4],$jenis_pembangunan[6]]))
                                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', 
                                                                ['class'=>'btn btn-warning btn-sm', Html::tooltip('Eksport Taman Awam'),
                                                                'data-url'=>route('pengurusan.eLAPS.destroy', $permohonan),
                                                                'data-text'=>'Kempen : '.$permohonan->tajuk,
                                                                'data-toggle'=>'modal', 'data-target'=>'#modalKeputusan']) !!}

                                                        @elseif(in_array($permohonan->category, [$jenis_pembangunan[8]]))
                                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', 
                                                                ['class'=>'btn btn-warning btn-sm', Html::tooltip('Eksport PIL'),
                                                                'data-url'=>route('pengurusan.eLAPS.destroy', $permohonan),
                                                                'data-text'=>'Kempen : '.$permohonan->tajuk,
                                                                'data-toggle'=>'modal', 'data-target'=>'#modalKeputusan']) !!}
                                                        @endif
                                                    --}}
                                                    @endif
                                                    @if(($permohonan->status_permohonan == 3 && (Auth::user()->hasRole('KP/ TKP JLN') || (Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 6))) || ((Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 7 || Auth::user()->hasRole('Pentadbir Sistem')) && $permohonan->status_permohonan >= 3))
                                                        {!! Form::button('<i class="fas fa-tasks"></i>', [
                                                            'class' => 'btn btn-success btn-sm', 
                                                            'data-toggle'=>'modal', 
                                                            'data-target'=>'#modalSerahan', 
                                                            'data-elaps-id' => $permohonan->id, 
                                                            Html::tooltip('Serahan kepada bahagian')
                                                        ]) !!}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @empty
                                        <tr><td colspan="7" class="text-center">No data available</td></tr>
                                    @endforelse
                                
                                @else
                                    <tr><td colspan="6" class="text-center">You do not have the necessary permissions to view this data.</td></tr>
                                @endif
                                
                            </tbody>

                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($eLAPS) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($eLAPS) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
