@extends('layouts.pengurusan.app')

@section('title', 'Senarai Landskap Lembut')

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
                    <h3 class="card-title my-1">Muka Surat Maklumat Landskap Lembut Mengikut Zon;<br>
					Zon A : 1 - 493 , Zon B : 493 - 857 , Zon C : 857 - 1820 , Zon D : 1820 - 2384 , Zon E : 2393 - 2394 , Zon F : 2385 - 2396</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Landskap Lembut','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.softscape.index')."'",'class'=>'btn
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
                                    <th>Nama Botani</th>
                                    <th>Nama Tempatan</th>
                                    <th>Nama Keluarga</th>
                                    <th class="text-center w-8">Tarikh Cerapan</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $softscapes->firstItem())
                                @forelse($softscapes as $softscape)
                                {{-- {{dd($softscape->gambar->keseluruhan)}} --}}
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        <div class="embed-responsive embed-responsive-4by3">
                                            @if ($softscape->gambar_p && Storage::disk('public')->exists('assets/softscape/'.$softscape->gambar_p))
                                            <img src="{{ asset('storage/assets/softscape/'.$softscape->gambar_p) }}" alt="gambar" class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item">
                                            @else
                                            <img src="{{ asset('img/default-150x150.png') }}" alt="gambar" class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $softscape->kod_tag }}</td>
                                    <td>{{ $softscape->jenis_kate }}</td>
                                    <td>{{ $softscape->nama_bot }}</td>
                                    <td>{{ $softscape->nama_temp }}</td>
                                    <td>{{ $softscape->nama_kel }}</td>
                                    <td class="text-center">{!! Html::datetime($softscape->tarikh_mas,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($softscape->updated_at,'d-m-Y') !!}
                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscape.show',$softscape)."'",
                                            //['data-href'=>''.route('pengurusan.softscape.show',$softscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapLembut',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Landskap Lembut')])
                                            !!}

                                            {!! Form::button('<i class="fas fa-qrcode"></i>',
                                            ['onclick'=>"window.open('".route('pengurusan.softscape.tagging',$softscape)."');",'class'=>'btn btn-secondary btn-sm',
                                            Html::tooltip('Tag')]) !!}

                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscape.edit',$softscape)."'",
                                            //['data-href'=>''.route('pengurusan.softscape.show',$softscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapLembut',
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Landskap Lembut')])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Landskap Lembut') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                
                @if(count($softscapes) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($softscapes) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@endsection
