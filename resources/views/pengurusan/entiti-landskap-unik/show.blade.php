@extends('layouts.pengurusan.app')

@section('title', 'Lihat Entiti Landskap Unik')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                {!! Form::model($entitiLandskapUnik, ['route' => ['pengurusan.entiti-landskap-unik.update', $entitiLandskapUnik], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    <!-- Nama Kempen and Lokasi -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('nama_kempen', 'Nama Pokok/ Kawasan Unik') }}
                            {{ Form::text('nama_kempen', 'Pokok Unik 1', ['placeholder' => 'Masukkan Nama Pokok/ Kawasan Unik', 'class' => 'form-control', 'inert' => true]) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('lokasi', 'Lokasi') }}
                            {{ Form::text('lokasi', 'Lokasi 1', ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control', 'inert' => true]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('keterangan', 'Keterangan') }}
                        {{ Form::textarea('keterangan','Pokok Unik 1 ini adalah pokok yang pertama... ',['placeholder'=>'Sila masukkan keterangan','rows'=>3, 'inert' => true,'class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
                        {!! Html::hasError($errors,'keterangan') !!}
                    </div>
                    <!-- PBT and Agensi -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            {{ Form::label('pbt', 'PBT') }}
                            {{ Form::text('pbt', 'PBT 1', ['placeholder' => 'Masukkan PBT', 'class' => 'form-control', 'inert' => true]) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('agensi', 'Agensi') }}
                            {{ Form::text('agensi', null, ['placeholder' => 'Masukkan Agensi', 'class' => 'form-control', 'inert' => true]) }}
                        </div>
                    </div>

                    <!-- Spesis Pokok & Jumlah Pokok -->
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <div class="table-responsive">
                                <table id="spesis-pokok-table" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="w-50">Entiti Unik</th>
                                            <th class="w-20">Anggaran Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spesis_pokok_container">
                                        @if(isset($spesisPokokJumlahPairs))
                                            @foreach ($spesisPokokJumlahPairs as $index => $pair)
                                            <tr>
                                                <td><input type="text" name="spesis_pokok[]" class="form-control" value="{{ $pair['spesis_pokok'] }}" placeholder="Masukkan Spesis Pokok" inert></td>
                                                <td><input type="text" name="jumlah_pokok[]" class="form-control" value="{{ $pair['jumlah_pokok'] }}" placeholder="Masukkan Jumlah Pokok" inert></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input type="text" name="spesis_pokok[]" class="form-control" placeholder="Masukkan Spesis Pokok" inert></td>
                                                <td><input type="number" name="jumlah_pokok[]" class="form-control" placeholder="Masukkan Jumlah Pokok" inert></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs to store serialized data (no need for user interaction) -->
                    <input type="hidden" name="serialized_spesis_pokok" id="serialized_spesis_pokok">
                    <input type="hidden" name="jumlah_tanam_pokok" id="jumlah_tanam_pokok">


                    <!-- @include('pengurusan.entiti-landskap-unik._upload', ['inert' => true]) -->
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.entiti-landskap-unik.index')."'", 'class' => 'btn btn-secondary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
