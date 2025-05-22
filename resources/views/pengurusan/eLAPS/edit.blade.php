@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Permohonan Projek Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                    <div class="d-flex justify-content-end" role="group" aria-label="First group">
                        {!! Form::button('Informasi&nbsp;&nbsp;&nbsp;<i class="fas fa-info"></i>', [
                            'class'=>'btn btn-success btn-sm',
                            'data-toggle'=>'modal','data-target'=>'#pelanModal',
                        ]) !!}
                        &nbsp;
                    </div>
                </div>
                @php
                    //dd($eLAPS['id']);
                    //(dd($eLAPS->category))
                @endphp
                {!! Form::model($eLAPS, ['route' => ['pengurusan.eLAPS.update', $eLAPS], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.eLAPS._form')

                    <!-- @include('pengurusan.eLAPS._upload') -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to eLAPS index) -->
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Simpan', [
                        'class' => 'btn btn-primary', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update',
                        'id' => 'updateButton'
                    ]) !!}

                    <!-- Submit Button (Hantar Permohonan) -->
                    {{-- {!! Form::button('<i class="fas fa-paper-plane"></i> Hantar Permohonan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'submit'
                    ]) !!} --}}

                    {!!
                        ((($eLAPS->status_permohonan == 10 || $eLAPS->status_permohonan == 12) && auth()->user()->hasRole('Pentadbir Sistem|Pihak Berkuasa Tempatan')) ?
                            Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini Status Projek', 
                                [
                                    'class' => 'btn btn-primary', 
                                    'type' => 'submit', 
                                    'name' => 'statusProjek', 
                                    'value' => 'siap'
                                ]) 
                        : '')
                    !!}
                    
                        {!! Form::button('', [
                            'class' => 'btn btn-success',
                            'id' => 'sendButton', 
                            'style' => 'display: none;', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'value' => 'submit'
                        ]) !!}
                        
                        <button type="button" class="btn btn-success" id="triggerSendModal">
                            <i class="fas fa-paper-plane"></i> Hantar Permohonan
                        </button>
                        
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmSendModal" tabindex="-1" aria-labelledby="confirmSendLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 50%; max-width: none;">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmSendLabel">Pengesahan dan pengakuan pemohon:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">&times;</button>
      </div>

      <div class="modal-body">
        <div class="form-group p-3" style="background-color: #fef7f8; border-left: 5px solid #f0868e;">
          <p class="mb-3" style="font-size: 16px;">
            Dengan ini saya mengesahkan segala maklumat yang diberikan adalah <strong>betul, tepat, lengkap</strong> dan sebarang kesalahan dan percanggahan maklumat adalah dibawah tanggungan pihak saya sendiri. Diperakukan bahawa tapak cadangan ini tidak terlibat dengan pembangunan-pembangunan semasa dan pihak saya juga tidak mengemukakan apa-apa permohonan selain cadangan pembangunan yang dipohon untuk projek ini sahaja.
          </p>
          <div class="form-check mt-3">
            <input 
              class="form-check-input" 
              type="checkbox" 
              id="acknowledgement" 
              name="acknowledgement" 
              required 
            >
            <label 
              class="form-check-label" 
              for="acknowledgement" 
            >
              Saya mengakui dan bersetuju dengan pengesahan di atas.
            </label>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="confirmSendBtn" class="btn btn-success">
          <i class="fas fa-paper-plane"></i> Hantar Permohonan
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Send Modal Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const SendModal = new bootstrap.Modal(document.getElementById('confirmSendModal'));
    const confirmSendBtn = document.getElementById('confirmSendBtn');
    const triggerSendModal = document.getElementById('triggerSendModal');
    const acknowledgementCheckbox = document.getElementById('acknowledgement');
    const sendButton = document.getElementById('sendButton');

    triggerSendModal.addEventListener('click', function () {
      SendModal.show();
    });

    confirmSendBtn.addEventListener('click', function () {
      if (!acknowledgementCheckbox.checked) {
        alert('Sila tandakan pengesahan sebelum menghantar permohonan.');
        return;
      }

      sendButton.click();
    });
  });
</script>
@endsection

