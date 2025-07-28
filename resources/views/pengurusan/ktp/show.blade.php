<style>
 body 
        .has-tooltip {
            -webkit-transform: translateZ(0); 
            -webkit-font-smoothing: antialiased; 
        }

        .has-tooltip .tooltip {
            background: #31D5C8;
            color: #fff;
            display: block;                      
            opacity: 0;
            padding: 0.3em;
            position: absolute;
            visibility: hidden;
            width: auto;                
            max-width: 100%;
            word-break: break-word;    
            -webkit-transition: all .25s ease-out;
               -moz-transition: all .25s ease-out;
                -ms-transition: all .25s ease-out;
                 -o-transition: all .25s ease-out;
                    transition: all .25s ease-out;
            -webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
               -moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                -ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                 -o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
        }

        /* This bridges the gap so you can mouse into the tooltip without it disappearing */
        .has-tooltip .tooltip:before {
            content: " ";
            display: block;
            height: 1em;
            position: absolute;
            width: 100%;
        }  

        .has-tooltip:hover .tooltip {
            opacity: 1;
            visibility: visible;
            -webkit-transform: translateX(0px) translateY(0px) !important;
               -moz-transform: translateX(0px) translateY(0px) !important;
                -ms-transform: translateX(0px) translateY(0px) !important;
                 -o-transform: translateX(0px) translateY(0px) !important;
                    transform: translateX(0px) translateY(0px) !important;
        }

       
        
        /* TOOLTIPS 'EAST' VERSION */
        .has-tooltip.east .tooltip {
            left: 30%;
            right: auto;
            bottom: auto;
            top: -2em;
            margin-top: 0%;
            margin-left: 0.6em;
            margin-bottom: auto;
            -webkit-transform: translateX(-10px) translateY(0px);
               -moz-transform: translateX(-10px) translateY(0px);
                -ms-transform: translateX(-10px) translateY(0px);
                 -o-transform: translateX(-10px) translateY(0px);
                    transform: translateX(-10px) translateY(0px);
        }

        .has-tooltip.east .tooltip:before {
            left: -1em;
            height: 100%;
            top: 0;
            width: 1em;
        } 

        @media print {
            .card-tools {
                display: none !important;
            }
            header, footer {
                display: block;
                position: fixed;
                width: 100%;
            }
            header {
                top: 0;
            }
            footer {
                bottom: 0;
            }
             body {
                font-size: 12pt;
                color: #000;
                background: #fff;
            }
            .card {
                border: none;
                box-shadow: none;
            }
            @page {
                size: A4 portrait;
                margin: 1cm;
            }
        }
</style>
    
@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat Kempen Tanaman Pokok')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>

                    <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Print group">
                                    <button type="button" class="btn bg-info" onclick="window.print()" title="Cetak">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                </div>
                                &nbsp;
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
                    <div class="form-row col-md-6">
                        <dl class="row">
                            <dt class="col-4">Tahun:</dt>
                            <dd class="col-8">{{ $ktp->tajuk }}</dd>

                            <!-- <dt class="col-6">Keterangan</dt>
                            <dd class="col-6">{{ $ktp->keterangan }}</dd> -->
                                
                            <dt class="col-4">Suku Tahun:</dt>
                            <?php
                                $quarters = [
                                    1 => 'Jan - Mac',
                                    2 => 'Apr - Jun',
                                    3 => 'Jul - Sep',
                                    4 => 'Okt - Dis',
                                ];
                            ?>
                            <dd class="col-8">{{ $quarters[$ktp->lokasi] ?? 'N/A' }}</dd>

                            <dt class="col-4">Negeri:</dt>
                            <dd class="col-8">{{ isset($negeriMap[$ktp->negeri]) ? ucwords(strtolower($negeriMap[$ktp->negeri])) : 'N/A' }}</dd>

                            <dt class="col-4">PBT:</dt>
                            <dd class="col-8">{{ $ktp->pbt }}</dd>
                        </dl>
                    </div>

                    <!-- Spesis Pokok & Jumlah Pokok -->
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="table-responsive">
                                <table id="spesis-pokok-table" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="w-5">Bil</th>
                                            <th class="w-50">Spesis Pokok</th>
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
                                            //dd $totalCarbon;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pair['spesis'] ?? 'N/A' }}</td>
                                            <td>{{ $height }}</td>
                                            <td>{{ $diameter }}</td>
                                            <td>{{ $bilangan }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="font-weight-bold">Jumlah Pokok Yang Ditanam</td>
                                            <td class="font-weight-bold">{{ $ktp->jumlah_pokok }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="font-weight-bold">

                                                <div class="has-tooltip east">
                                                    Jumlah Karbon Yang Diserap <i class="fas fa-info-circle"></i>
                                                    <span class="tooltip">Formula: <br> Diameter < 28cm , Karbon = (((0.0577 x diameter² x tinggi) x 0.5) x 0.5) <br> Diameter > 28cm , Karbon = (((0.0346 x diameter² x tinggi) x 0.5) x 0.5)</span>
                                                </div>
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
