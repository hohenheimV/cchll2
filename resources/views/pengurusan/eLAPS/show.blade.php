@extends('layouts.pengurusan.app')

@section('title', 'Lihat eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                    <div class="card-tools p-1 m-1 font-weight-bold">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Kemaskini?', 
                                    ['onclick'=>"window.location='".route('pengurusan.eLAPS.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar eLAPS')]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-hardscape form-hardscape text-sm">
                {!! Form::model($eLAPS, ['route' => ['pengurusan.eLAPS.update', $eLAPS], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div inert>
                        @include('pengurusan.eLAPS._form')
                    </div>
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
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
