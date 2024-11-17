<!-- Modal Logout -->
<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-power-off"></i> Log keluar</h5>
            </div>
            <div class="modal-body text-center border-0">Anda pasti untuk log keluar?</div>
            <div class="modal-footer d-flex  border-0">
                {!! Form::hidden('id', null, ['id'=>'id']) !!}
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Log Keluar', ['onclick'=>'event.preventDefault();
                document.getElementById(\'logout-form\').submit();','class'=>'btn bg-olive btn-lg btn-flat btn-block m-0
                ml-1']) !!}
                {!! Form::open(['id'=>'logout-form','style'=>'display: none;','method'=>'POST','route'=>['logout']]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            {!! Form::open(['method'=>'DELETE','id'=>'modalFormDelete']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-trash"></i> Padam Rekod</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Adakan anda pasti untuk padam rekod ini?</strong></p>
            </div>
            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Padam', ['type'=>'submit','class'=>'btn btn-success btn-lg btn-flat btn-block m-0
                ml-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('modal')
<script>
    $(document).ready(function () {

        // BS4 Modal Via JavaScript
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var url = button.data('url'); // Extract info from data-* attributes
            $('#modalFormDelete').attr('action', url);
        });
    });
</script>

@endsection
