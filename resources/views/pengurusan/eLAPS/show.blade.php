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
                    @if(isset($eLAPS->file_path) && (auth()->user()->hasRole('Pentadbir Sistem|TKP/B JLN|Pihak Berkuasa Tempatan') || (Auth::user()->hasRole('Pegawai'))))
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
                    @else
                        @php
                            $folderName = isset($eLAPS->file_path) ? 'eLAPS/'.str_replace('/', '', $eLAPS->referenceNumber).'/'.$eLAPS->file_path : null;
                        @endphp
                        
                        @if($folderName == null)
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <a class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;">
                                    <div class="product-image">
                                        <img src="https://img.icons8.com/fluency/48/winrar.png" class="br-5" alt="" style="width: 48px; height: 48px; border-radius: 5px; margin-bottom: 10px;">
                                    </div>
                                    <div class="product-image">
                                        <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Tiada Dokumen</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                    @endif

                    @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan') || !(isset($eLAPS->status_permohonan)) || (isset($eLAPS->status_permohonan) && $eLAPS->status_permohonan < 3) || ( Auth::user()->id == $eLAPS->id_pemohon))
                        <div class="row">
                            <div class="form-group mb-6 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                                <label for="acknowledgement"><h4>Pengesahan dan pengakuan pemohon:</h4></label>
                                <div style="background-color: transparent; border: none; padding: 10px; width: 100%; font-size: 16px;">
                                    Dengan ini saya mengesahkan segala maklumat yang diberikan adalah <strong>betul, tepat, lengkap</strong> dan sebarang kesalahan dan percanggahan maklumat adalah dibawah tanggungan pihak saya sendiri. Diperakukan bahawa tapak cadangan ini tidak terlibat dengan pembangunan-pembangunan semasa dan pihak saya juga tidak mengemukakan apa-apa permohonan selain cadangan pembangunan yang dipohon untuk projek ini sahaja.
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="acknowledgement" name="acknowledgement" required {{ isset($eLAPS->created_at) ? 'checked inert' : '' }}>
                                    <label class="form-check-label" for="acknowledgement" {{ isset($eLAPS->created_at) ? 'inert' : '' }}>
                                        Saya mengakui dan bersetuju dengan pengesahan di atas. {{ isset($eLAPS->created_at) ? ' - [Pengesahan dan pengakuan pemohon pada ' . $eLAPS->created_at . ']' : '' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- @include('pengurusan.eLAPS._upload') -->
                     {{ ($eLAPS->status_permohonan == 5) }}
                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && $eLAPS->status_permohonan >= 6 && (Auth::user()->bahagian_jln == $eLAPS->bahagian_jln || Auth::user()->bahagian_jln == 6))
                        @if($eLAPS->status_permohonan > 7) <div inert> @endif
                            {{ Form::label('ulasan_lawatan', 'KEGUNAAN JABATAN :', ['class' => 'col-form-label']) }}<br>
                            {{ Form::label('ulasan_lawatan', 'Ulasan :', ['class' => 'col-form-label ulasan']) }}
                        
                            {{ Form::textarea('ulasan_lawatan', $eLAPS->ulasan_lawatan, ['class' => 'form-control summernote', 'rows' => 3, 'cols' => 20, 'placeholder' => 'Masukkan butiran jika ada', 'required' => true]) }}
                        @if($eLAPS->status_permohonan > 7) </div> @endif
                    @endif
                    <script>
                        @if($eLAPS->status_permohonan >= 5)
                        let firstError = document.querySelector('.ulasan');
                        if (firstError) {
                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                        @endif
                    </script>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}
                    @if((auth()->user()->hasRole('Pentadbir Sistem|TKP/B JLN') || (Auth::user()->hasRole('Pegawai') && Auth::user()->bahagian_jln == 6)) && in_array($eLAPS->status_permohonan, [2, 3]))
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

                    @if(($eLAPS->status_permohonan == 6 || $eLAPS->status_permohonan == 7) && (auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && Auth::user()->bahagian_jln == $eLAPS->bahagian_jln))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Simpan Draf Ulasan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'ulasan', 
                            'value' => 'draf'
                        ]) !!}
                    {{--@endif
                    @if($eLAPS->status_permohonan == 7 && (auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && Auth::user()->bahagian_jln == $eLAPS->bahagian_jln))--}}
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Hantar Ulasan', [
                            'class' => 'btn btn-success', 
                            'type' => 'submit', 
                            'name' => 'ulasan', 
                            'value' => 'hantar'
                        ]) !!}
                    @endif

                    @if(($eLAPS->status_permohonan == 8 || $eLAPS->status_permohonan == 9) && (auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && (Auth::user()->bahagian_jln == $eLAPS->bahagian_jln || Auth::user()->bahagian_jln == 6)))
                        {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini Status Permohonan', [
                            'class' => 'btn btn-warning', 
                            'data-toggle'=>'modal', 
                            'data-target'=>'#modalKeputusan', 
                            'data-elaps-id' => $eLAPS->id
                        ]) !!}
                    @endif

                    @if(($eLAPS->status_permohonan == 10 || $eLAPS->status_permohonan == 12) && (auth()->user()->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem') || Auth::user()->id == $eLAPS->id_pemohon || (auth()->user()->hasRole('Pegawai') && (Auth::user()->bahagian_jln == $eLAPS->bahagian_jln || Auth::user()->bahagian_jln == 6))))
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
