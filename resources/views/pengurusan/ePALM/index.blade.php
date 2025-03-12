@extends('layouts.pengurusan.app')

@section('title', 'ePALM')

@section('content')

@php
    //dd(auth()->user()->roles, auth()->user()->permissions);
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem'))
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') [Paparan Pegawai JLN]</h3>
                    @elseif(Auth::user()->hasRole('TKP/B JLN|Pentadbir Sistem'))
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') [Paparan KP/TKP/B. Penilaian]</h3>
                    @elseif(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') [Paparan PBT]</h3>
                    @endif
                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.ePALM.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar ePALM')]) !!}
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
                                    <th>Nama Taman</th>
                                    <th class="text-center w-5">Kategori Taman</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|TKP/B JLN'))
                                        <th class="text-center w-10">PBT</th>
                                        <th class="text-center w-12">Paparan Portal</th>
                                    @endif
                                    
                                        <th class="text-center w-5">Tindakan</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|Pihak Berkuasa Tempatan|TKP/B JLN'))
                                    @php($index = $ePALM->firstItem())
                                    @php($jenis_pembangunan = [
                                        'Taman Awam',
                                        'Taman Botani',
                                        'Landskap Perbandaran',
                                        'Persekitaran Kehidupan',
                                        'Taman Persekutuan',
                                        'Lain-lain (sila nyatakan)'
                                    ])
                                    @php($jenis_count = count($jenis_pembangunan))
                                    @php($paparan_portal = [
                                        ['id' => 'Aktif', 'label' => 'bg-success'], // Green background for approved
                                        ['id' => 'Tidak Aktif', 'label' => 'bg-danger'], // Red background for failed
                                    ])
                                    @php($status_count = count($paparan_portal))
                                    @forelse($ePALM as $taman)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ strtoupper($taman->nama_taman) }}</td>
                                            <td>{!! ((!in_array($taman->kategori_taman, $jenis_pembangunan))) ? '<span class="badge bg-warning">'.$taman->kategori_taman.'</span>' : $taman->kategori_taman !!}</td>
                                            
                                            @if(Auth::user()->hasRole('TKP/B JLN|Pegawai|Pentadbir Sistem'))
                                            <td>
                                                {{ $taman->nama_pbt }}
                                            </td>
                                            <td>
                                                <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$taman->status == 'approved' ? 0 : 1]['label'] }}">{{ $paparan_portal[$taman->status == 'approved' ? 0 : 1]['id'] }}</span>
                                            </td>
                                            @endif
                                            
                                            <td>
                                                <div class="btn-group">
                                                    {!! 
                                                        Form::button('<i class="fas fa-search"></i>', ['onclick'=>"window.location='".route('pengurusan.ePALM.show',$taman)."'", 'class'=>'btn bg-info btn-sm', Html::tooltip('Lihat Taman')]); 
                                                    !!}
                                                    {!! 
                                                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePALM.edit',$taman)."'", 'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Taman')]); 
                                                    !!}
                                                    @if($taman->id_permohonan == null && ($taman->status == 'draft'))
                                                    {!! 
                                                        Form::button('<i class="fas fa-trash"></i>', 
                                                        [
                                                            'class' => 'btn btn-danger btn-sm',
                                                            'data-url' => route('pengurusan.ePALM.destroy', $taman),
                                                            'data-toggle' => 'modal',
                                                            'data-target' => '#modalDelete',
                                                            Html::tooltip('Padam Taman')
                                                        ])  
                                                    !!}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
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
                @if(count($ePALM) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($ePALM) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
