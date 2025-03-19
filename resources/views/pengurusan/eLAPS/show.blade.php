@extends('layouts.pengurusan.app')

@section('title', 'Lihat eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                    <!-- <div class="card-tools p-1 m-1 font-weight-bold">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Kemaskini?', 
                                    ['onclick'=>"window.location='".route('pengurusan.eLAPS.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar eLAPS')]) !!}
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="card-body table-hardscape form-hardscape text-sm">
                {!! Form::model($eLAPS, ['route' => ['pengurusan.eLAPS.update', $eLAPS], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div inert>
                        @include('pengurusan.eLAPS._form')
                    </div>

                    @if(isset($eLAPS->file_path) && auth()->user()->hasRole('Pentadbir Sistem|TKP/B JLN'))
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                @php
                                    $folderName = isset($eLAPS->file_path) ? 'eLAPS/'.str_replace('/', '', $eLAPS->referenceNumber).'/'.$eLAPS->file_path : null;
                                @endphp
                                
                                @if($folderName != null)
                                <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;" download>
                                    <div class="product-image">
                                        <img src="https://img.icons8.com/fluency/48/winrar.png" class="br-5" alt="" style="width: 48px; height: 48px; border-radius: 5px; margin-bottom: 10px;">
                                    </div>
                                    <div class="product-image">
                                        <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Dokumen Sokongan  <i class="fas fa-download"></i></span>
                                    </div>
                                    <div class="product-image">
                                        <span class="file-name-1">{{ $eLAPS->file_path }}</span>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- @include('pengurusan.eLAPS._upload') -->
                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && $eLAPS->status_permohonan >= 6)
                        @if($eLAPS->status_permohonan > 7) <div inert> @endif
                            {{ Form::label('ulasan_lawatan', 'KEGUNAAN JABATAN :', ['class' => 'col-form-label']) }}<br>
                            {{ Form::label('ulasan_lawatan', 'Ulasan Lawatan Kawasan Tapak :', ['class' => 'col-form-label']) }}
                        
                            {{ Form::textarea('ulasan_lawatan', $eLAPS->ulasan_lawatan, ['class' => 'form-control summernote', 'rows' => 3, 'cols' => 20, 'placeholder' => 'Masukkan butiran jika ada']) }}
                        @if($eLAPS->status_permohonan > 7) </div> @endif
                    @endif
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}
                    @if(auth()->user()->hasRole('Pentadbir Sistem|TKP/B JLN') && in_array($eLAPS->status_permohonan, [2, 3]))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Serah Permohonan ke Bahagian', [
                            'class' => 'btn btn-warning', 
                            'data-toggle'=>'modal', 
                            'data-target'=>'#modalSerahan', 
                            'data-elaps-id' => $eLAPS->id
                        ]) !!}
                    @else
                        {{--
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Simpan Draf Ulasan', [
                                'class' => 'btn btn-primary', 
                                'data-toggle'=>'modal', 'data-target'=>'#modalSerahan'
                            ]) !!}
                            
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Hantar Ulasan', [
                                'class' => 'btn btn-success', 
                                'data-toggle'=>'modal', 'data-target'=>'#modalSerahan'
                            ]) !!}
                        --}}
                    @endif

                    @if(($eLAPS->status_permohonan == 6 || $eLAPS->status_permohonan == 7) && auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Simpan Draf Ulasan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'ulasan', 
                            'value' => 'draf'
                        ]) !!}
                    @endif
                    @if($eLAPS->status_permohonan == 7 && auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Hantar Ulasan', [
                            'class' => 'btn btn-success', 
                            'type' => 'submit', 
                            'name' => 'ulasan', 
                            'value' => 'hantar'
                        ]) !!}
                    @endif

                    @if(($eLAPS->status_permohonan == 8 || $eLAPS->status_permohonan == 9) && auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini Status JPT', [
                            'class' => 'btn btn-warning', 
                            'data-toggle'=>'modal', 
                            'data-target'=>'#modalKeputusan', 
                            'data-elaps-id' => $eLAPS->id
                        ]) !!}
                    @endif

                    @if(($eLAPS->status_permohonan == 10 || $eLAPS->status_permohonan == 12) && (auth()->user()->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem')))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini Status Projek', [
                            'class' => 'btn btn-warning', 
                            'data-toggle'=>'modal', 
                            'data-target'=>'#modalStatusProjek', 
                            'data-text'=> $eLAPS->status_permohonan, 
                            'data-elaps-id' => $eLAPS->id
                        ]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
