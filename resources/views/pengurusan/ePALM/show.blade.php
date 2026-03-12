@extends('layouts.pengurusan.app')

@section('title', 'Lihat Maklumat Taman & Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($ePALM, ['route' => ['pengurusan.ePALM.update', $ePALM], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    
                    

                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        <div class="row" style="max-height: 40px; display: flex; justify-content: flex-end;">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    {{ Form::label('', 'Paparan Portal&nbsp;:&nbsp;', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                                </div>
                                <div class="col-auto">
                                    <label class="switch">
                                        <input type="checkbox" name="status" {{ isset($status) && $status == 'approved' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <style>
                        .showButton{
                            display: none;
                        }
                        .inertShow {
                            pointer-events: none;
                        }

                        .inertShow input,
                        .inertShow span:not(.parks span),
                        .inertShow textarea,
                        .inertShow select {
                            background-color: rgb(241, 241, 241);
                            color: rgb(65, 60, 60);
                            cursor: not-allowed;
                            pointer-events: none;
                        }
                        #projek_table th:last-child, #projek_table td:last-child {
                            display: none;
                        }
                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }
                            50% {
                                opacity: 0;
                            }
                            100% {
                                opacity: 1;
                            }
                        }

                        .newC {
                            animation: blink 3s infinite;
                            background-color: rgb(255, 255, 255) !important;
                        }
                    </style>
                    <div>
                        @include('pengurusan.ePALM._form')
                    </div>
                    <div class="col-lg showButton">
                        <div inert class="form-group required">
                            <label for="keterangan_taman" class="col-md-12 control-label">Keterangan Taman</label>
                            <div class="col-md-12">
                                <textarea name="keterangan_taman" class="form-control" rows="5" id="keterangan_taman" >{{ isset($ePALM->keterangan_taman) ? $ePALM->keterangan_taman : '' }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group required col-md-9">
                                <label for="fail_konsep" class="col-md-12 control-label">Konsep Rekabentuk</label>
                                <div class="col-md-12 ">
                                    @if(isset($ePALM->fail_konsep))
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $folderName = isset($ePALM->fail_konsep) ? 'ePALM/'.str_replace(' ', '_', $ePALM->nama_taman).'/'.$ePALM->fail_konsep : null;

                                                    $fileExtension = isset($ePALM->fail_konsep) ? pathinfo($ePALM->fail_konsep, PATHINFO_EXTENSION) : '';
                                                    $extensionIcon = null;
                                                    if ($fileExtension === 'pdf') {
                                                        $extensionIcon = "https://img.icons8.com/plasticine/100/pdf-2.png";
                                                    } elseif ($fileExtension === 'docx') {
                                                        $extensionIcon = "https://img.icons8.com/plasticine/100/google-docs--v2.png";
                                                    } elseif ($fileExtension === 'pptx') {
                                                        $extensionIcon = "https://img.icons8.com/plasticine/100/google-slides.png";
                                                    }
                                                @endphp
                                                
                                                @if($folderName != null)
                                                    <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;" download>
                                                        <div class="product-image">
                                                            <img src="{{ $extensionIcon }}" class="br-5" alt="" style="width: 100px; height: 100px; border-radius: 5px; margin-bottom: 10px;">
                                                        </div>
                                                        <div class="product-image">
                                                            <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Konsep Rekabentuk <i class="fas fa-download"></i></span>
                                                        </div>
                                                        <div class="product-image">
                                                            <span class="file-name-1">{{ $ePALM->fail_konsep ?? '' }}</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div inert class="form-group required col-md-3">
                                <div>
                                    <label for="tarikh_siapBina_taman" class="col-md-12 control-label">Tarikh Siap Bina</label>
                                    <div class="col-md-12">
                                        {{ Form::date('tarikh_siapBina_taman', isset($ePALM->tarikh_siapBina_taman) ? $ePALM->tarikh_siapBina_taman : '', ['class' => 'form-control d-inline-block ms-2', 'id' => 'tarikh_siapBina_taman']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- @include('pengurusan.ePALM._upload') -->
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePALM.index')."'", 'class' => 'btn btn-secondary']) !!}
                    
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePALM.edit',$ePALM->id_taman)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini Taman')]); 
                    !!}
                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-save"></i> Pengesahan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'id' => 'pengesahan', 
                            'style' => 'display: none;', 
                            'value' => 'approve'
                        ]) !!}
                    @endif
                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        <button type="button" class="btn btn-primary" id="triggerApprovalModal">
                            <i class="fas fa-save"></i> Pengesahan
                        </button>
                    @endif

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmApprovalModal" tabindex="-1" aria-labelledby="confirmApprovalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmApprovalLabel">Pengesahan Perubahan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">x</button>
      </div>
      <div class="modal-body">
        <!-- <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="modalToggleStatus">
          <label class="form-check-label" for="modalToggleStatus">Paparan ke portal</label>
        </div> -->
        <div class="row" style="max-height: 40px; display: flex; justify-content: flex-start;">
            <div class="row align-items-center">
                <div class="col-auto">
                    <p>Adakah anda ingin <strong>paparkan ke portal?</strong></p>
                </div>
                <div class="col-auto">
                    <label class="switch">
                        <input class="form-check-input" type="checkbox" id="modalToggleStatus">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="confirmApproveBtn" class="btn btn-primary">Sahkan</button>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleInput = document.querySelector('input[name="status"]');
        const modalToggle = document.getElementById('modalToggleStatus');
        const approvalModal = new bootstrap.Modal(document.getElementById('confirmApprovalModal'));

        document.getElementById('triggerApprovalModal').addEventListener('click', function () {
            modalToggle.checked = toggleInput?.checked ?? false;
            approvalModal.show();
        });

        document.getElementById('confirmApproveBtn').addEventListener('click', function () {
            if (toggleInput) {
                toggleInput.checked = modalToggle.checked;
            }
            document.getElementById('pengesahan').click();
        });
    });
</script>


@endsection
