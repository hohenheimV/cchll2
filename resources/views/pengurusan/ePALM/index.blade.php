@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Taman & Landskap')

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
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan Pegawai JLN] --}}</h3>
                    @elseif(Auth::user()->hasRole('KP/ TKP JLN|Pentadbir Sistem'))
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan KP/TKP/B. Penilaian] --}}</h3>
                    @elseif(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan PBT] --}}</h3>
                    @endif
                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{-- {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                <select id="negeri" name="negeri" style="
                                    height: calc(1.8125rem + 2px) !important;
                                    padding: 0.25rem 0.5rem !important;
                                    font-size: 0.875rem !important;
                                    line-height: 1.5 !important;
                                    border-radius: 0.2rem !important;
                                    border: 1px solid #ced4da !important;
                                ">
                                    <option value="">Papar Semua Negeri</option>
                                    @foreach(App\Model\Negeri::orderBy('nama_negeri')->get() as $n)
                                        <option value="{{ $n->kod_negeri }}" {{ request('negeri') == $n->kod_negeri ? 'selected' : '' }}>
                                            {{ ucwords(strtolower($n->nama_negeri)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="negeriX" style="display: none;">
                                </select>
                            </div>
                                <div class="input-group mr-2">
                                    {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Carian Pantas','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                    <div class="input-group-append">
                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                        'class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                        {!! Form::button('Reset',
                                        ['onclick'=>"window.location='".route('pengurusan.ePALM.index')."'",
                                        'class'=>'btn btn-secondary btn-sm']) !!}
                                    </div>
                                </div>
                            {{ Form::close() }} --}}
                             <div class="btn-group" role="group" aria-label="First group">
                                {{ Form::open(['class'=>'form-inline', 'method' => 'get']) }}

                                <style>
                                    .gyrodrop{
                                        height: calc(1.8125rem + 2px) !important;
                                        padding: 0.25rem 0.5rem !important;
                                        font-size: 0.875rem !important;
                                        line-height: 1.5 !important;
                                        border-radius: 0.2rem !important;
                                        border: 1px solid #ced4da !important;
                                    }
                                </style>
                                    {{-- Negeri Dropdown --}}
                                    <div class="input-group mr-2">
                                        <select id="negeri" name="negeri" class="gyrodrop">
                                            <option value="">Papar Semua Negeri</option>
                                            @foreach(App\Model\Negeri::orderBy('nama_negeri')->get() as $negeri)
                                                <option value="{{ $negeri->kod_negeri }}" {{ request('negeri') == $negeri->kod_negeri ? 'selected' : '' }}>
                                                    {{ ucwords(strtolower($negeri->nama_negeri)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="input-group" style="display: none;">
                                        <select id="negeri" name="negeriX">
                                        </select>
                                    </div>

                                    @php
                                        $options = [
                                            '' => 'Papar Semua Kategori',
                                            'Taman Awam' => 'Taman Awam',
                                            'Taman Botani' => 'Taman Botani',
                                            'Landskap Perbandaran' => 'Landskap Perbandaran',
                                            'Persekitaran Kehidupan' => 'Persekitaran Kehidupan',
                                            'Taman Persekutuan' => 'Taman Persekutuan',
                                            'Taman Wilayah' => 'Taman Wilayah',
                                            'Taman Bandaran' => 'Taman Bandaran',
                                            'Taman Tempatan' => 'Taman Tempatan',
                                            'Padang Kejiranan' => 'Padang Kejiranan',
                                            'Padang Permainan' => 'Padang Permainan',
                                            'Lot Permainan' => 'Lot Permainan',
                                        ];
                                    @endphp

                                    <div class="input-group mr-2">
                                        {!! Form::select('kategori', $options, request('kategori'), ['class' => 'gyrodrop', 'id' => 'kategori']) !!}
                                    </div>

                                    <div class="input-group" style="display: none;">
                                        <select id="kategori" name="kategoriX">
                                        </select>
                                    </div>

                                    {{-- Keyword Search --}}
                                    <div class="input-group mr-2">
                                        {{ Form::search('keyword', request('keyword'), [
                                            'aria-label' => 'Search',
                                            'placeholder' => 'Carian Pantas',
                                            'class' => 'form-control form-control-sm ' . Html::isInvalid($errors, 'keyword')
                                        ]) }}
                                        <div class="input-group-append">
                                            {!! Form::button('<i class="fas fa-search"></i>', [
                                                'class' => 'btn btn-default btn-sm',
                                                'type' => 'submit'
                                            ]) !!}
                                            {!! Form::button('Reset', [
                                                'onclick'=>"window.location='".route('pengurusan.ePALM.index')."'", 'class'=>'btn btn-secondary btn-sm'
                                            ]) !!}
                                        </div>
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.ePALM.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Taman')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="dt-buttons">
                            <a class="dt-button buttons-csv buttons-html5" href="{{ route('pengurusan.ePALM.export', [
                                'format' => 'csv',
                                'negeri' => request('negeri'),
                                'keyword' => request('keyword'),
                                'kategori' => request('kategori')
                            ]) }}">
                                <span>CSV</span>
                            </a>

                            <a class="dt-button buttons-excel buttons-html5" href="{{ route('pengurusan.ePALM.export', [
                                'format' => 'excel',
                                'negeri' => request('negeri'),
                                'keyword' => request('keyword'),
                                'kategori' => request('kategori')
                            ]) }}">
                                <span>Excel</span>
                            </a>
                        </div>
                        <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <th>Nama Taman</th>
                                    <th class="text-center w-5">Kategori Taman</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                        <th class="text-center w-10">PBT</th>
                                    @endif
                                        <th class="text-center w-12">Paparan Portal</th>
                                    
                                        <th class="text-center w-5">Tindakan</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|Pihak Berkuasa Tempatan|KP/ TKP JLN'))
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
                                        ['id' => 'Papar', 'label' => 'bg-success'], // Green background for approved
                                        ['id' => 'Tidak Papar', 'label' => 'bg-danger'], // Red background for failed
                                    ])
                                    @php($status_count = count($paparan_portal))
                                    @forelse($ePALM as $taman)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ strtoupper($taman->nama_taman) }}</td>
                                            <td>{!! ((!in_array($taman->kategori_taman, $jenis_pembangunan))) ? '<span class="badge bg-warning">'.strtoupper($taman->kategori_taman).'</span>' : strtoupper($taman->kategori_taman) !!}</td>
                                            
                                            @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem'))
                                            <td>
                                                {{ strtoupper($taman->nama_pbt) }}
                                            </td>
                                            @endif
                                            <td>
                                                @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                                                    <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$taman->status == 'approved' ? 0 : 1]['label'] }}">{{ $taman->status == 'approved' ? 'Perubahan telah disahkan' : 'Perubahan belum disahkan' }}</span>
                                                @else
                                                    <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$taman->status == 'approved' ? 0 : 1]['label'] }}">{{ $paparan_portal[$taman->status == 'approved' ? 0 : 1]['id'] }}</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                    {!! 
                                                        Form::button('<i class="fas fa-search"></i>', ['onclick'=>"window.location='".route('pengurusan.ePALM.show',$taman)."'", 'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Taman')]); 
                                                    !!}
                                                    {!! 
                                                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePALM.edit',$taman)."'", 'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Taman')]); 
                                                    !!}
                                                    @if($taman->id_permohonan == null || (Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem') && $taman->status == 'draft'))
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
                {{-- @if(count($ePALM) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($ePALM) !!}
                </div>
                <!-- /.card-footer -->
                @endif --}}
                @if ($ePALM->total() > 0)
                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                        <div class="text-muted mx-2">
                            <small>
                                Laman {{ $ePALM->currentPage() }} daripada {{ $ePALM->lastPage() }},
                                menunjukkan {{ $ePALM->count() }} data daripada {{ $ePALM->total() }} jumlah data,
                                bermula pada baris {{ $ePALM->firstItem() }},
                                berakhir pada baris {{ $ePALM->lastItem() }}
                            </small>
                        </div>
                        <div>
                            {!! $ePALM->appends(request()->query())->links() !!}
                        </div>
                    </div>
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
