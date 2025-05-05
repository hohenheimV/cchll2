@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>

                    <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                        'onclick' => "window.location='" . route('pengurusan.ktp.edit', $ktp) . "'",
                                        'class' => 'btn bg-warning',
                                        Html::tooltip('Kemaskini'),
                                    ]) !!}
                                </div>
                                &nbsp;
                                <div class="btn-group" role="group" aria-label="First group">

                                    {!! Form::button('Kembali', [
                                        'onclick' => "window.location='" . route('pengurusan.ktp.index') . "'",
                                        'class' => 'btn bg-secondary',
                                        Html::tooltip('Kembali'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                </div>

                {!! Form::model($ktp, ['route' => ['pengurusan.ktp.update', $ktp], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    <!-- Nama Kempen and Lokasi -->
                    <div class="form-row">
                        <dl class="row">
                            <dt class="col-6">Tajuk</dt>
                            <dd class="col-6">{{ $ktp->tajuk }}</dd>

                            <!-- <dt class="col-6">Keterangan</dt>
                            <dd class="col-6">{{ $ktp->keterangan }}</dd> -->
                                
                            <dt class="col-6">Lokasi</dt>
                            <dd class="col-6">{{ $ktp->lokasi }}</dd>

                            <dt class="col-6">PBT</dt>
                            <dd class="col-6">{{ $ktp->pbt }}</dd>
                        </dl>
                    </div>

                    <!-- Spesis Pokok & Jumlah Pokok -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="table-responsive">
                                <table id="spesis-pokok-table" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="w-30">Spesis Pokok</th>
                                            <th class="w-15">Tinggi (m)</th>
                                            <th class="w-15">Diameter (cm)</th>
                                            <th class="w-15">Bilangan Pokok</th>
                                        </tr>
                                    </thead>
                                    <tbody id="spesis_pokok_container">
                                        @php
                                            $totalCarbon = 0;
                                        @endphp
                                        @foreach ($spesisPokokJumlahPairs as $pair)
                                        @php
                                            $diameter = $pair['diameter'] ?? 0;
                                            $height = $pair['tinggi'] ?? 0;
                                            $bilangan = $pair['bilangan'] ?? 0;
                                            $carbon = 0;

                                            if ($diameter < 28) {
                                                $carbon = (((0.0577 * pow($diameter, 2) * $height) * 0.5) * 0.5);
                                            } else {
                                                $carbon = (((0.0346 * pow($diameter, 2) * $height) * 0.5) * 0.5);
                                            }

                                            $totalCarbon += $carbon * $bilangan;
                                        @endphp
                                        <tr>
                                            <td>{{ $pair['spesis'] ?? 'N/A' }}</td>
                                            <td>{{ $height }}</td>
                                            <td>{{ $diameter }}</td>
                                            <td>{{ $bilangan }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="font-weight-bold">Jumlah Pokok Yang Ditanam</td>
                                            <td class="font-weight-bold">{{ $ktp->jumlah_pokok }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="font-weight-bold">
                                                Jumlah Karbon Yang Diserap <i class="fas fa-info-circle" data-tooltip="tooltip" title="Formula: Diameter < 28cm , K = (((0.0577 x diameter² x tinggi) x 0.5) x 0.5); Diameter > 28cm , K = (((0.0346 x diameter² x tinggi) x 0.5) x 0.5)"></i><br>
                                            </td>
                                            <td class="font-weight-bold">{{ number_format($totalCarbon, 2) }} Meterpadu <span>(m&sup3;)</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <!-- Hidden inputs to store serialized data (no need for user interaction) -->
                    <input type="hidden" name="serialized_spesis_pokok" id="serialized_spesis_pokok">
                    <input type="hidden" name="jumlah_tanam_pokok" id="jumlah_tanam_pokok">

                    <!-- @include('pengurusan.ktp._upload', ['inert' => true]) -->
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
