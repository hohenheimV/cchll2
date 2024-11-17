@extends('layouts.pengurusan.app')

@section('title', 'Senarai Landskap Kejur')

@section('content')
<style>
    a.rm-link {
        color: #e83e8c !important;
    }
</style>
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
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Landskap Kejur','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.hardscape.index')."'",'class'=>'btn
                                    btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                           
                           
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
                                    <th class="w-5">Gambar</th>
                                    <th class="w-10 text-center">Kod Tag</th>
                                    <th>Jenis</th>
                                    <th>Nama Struktur</th>
                                    <th class="text-center w-8">Tarikh Cerapan</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php($index = $hardscapes->firstItem())
                                @forelse($hardscapes as $hardscape)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        <div class="embed-responsive embed-responsive-4by3">
                                            @if ($hardscape->gambar && Storage::disk('public')->exists('assets/hardscape/'.$hardscape->gambar))
                                            <img src="{{ asset('storage/assets/hardscape/'.$hardscape->gambar) }}" alt="gambar" class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item">
                                            @else
                                            <img src="{{ asset('img/default-150x150.png') }}" alt="gambar" class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $hardscape->kod_tag }}</td>

                                    <td>{{ $hardscape->jenis ?? 'tiada maklumat' }}</td>
                                    <td>{{ $hardscape->nama_struk ?? 'tiada maklumat' }}</td>
                                    <td class="text-center">{!! Html::datetime($hardscape->tarikh,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($hardscape->updated_at,'d-m-Y') !!}
                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.hardscape.show',$hardscape)."'",
                                            //['data-href'=>''.route('pengurusan.hardscape.show',$hardscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapKejur',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Landskap Kejur')])
                                            !!}

                                            {!! Form::button('<i class="fas fa-qrcode"></i>',
                                            ['onclick'=>"window.open('".route('pengurusan.hardscape.tagging',$hardscape)."');",'class'=>'btn btn-secondary btn-sm',
                                            Html::tooltip('Tag')]) !!}

                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.hardscape.edit',$hardscape)."'",
                                            //['data-href'=>''.route('pengurusan.hardscape.show',$hardscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapKejur',
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Landskap Kejur')])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Landskap Kejur') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($hardscapes) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($hardscapes) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@endsection
