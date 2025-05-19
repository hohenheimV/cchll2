@extends('layouts.pengurusan.app')

@section('title', 'Lihat Maklumat Pelan Induk Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {{-- dd($ePIL)--}}
                {!! Form::model($ePIL, ['route' => ['pengurusan.ePIL.update', $ePIL], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
                            pointer-events: none; /* Ensure no interactions are possible */
                        }

                        .inertShow input,
                        .inertShow span,
                        .inertShow textarea,
                        .inertShow select {
                            background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                            color: rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                            pointer-events: none; /* Ensure no interactions are possible */
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
                        @include('pengurusan.ePIL._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePIL.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$ePIL->id_pelan)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
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
