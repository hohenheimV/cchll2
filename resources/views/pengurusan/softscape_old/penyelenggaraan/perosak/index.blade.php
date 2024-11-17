@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Penyelenggaraan')
@section('card-title', 'Maklumat Penyelenggaraan Kawalan Perosak')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                    @include('pengurusan.softscape._pill_nav')
                </div>
                <div class="card-body p-0">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('card-title') </h5>
                        <div class="p-1">
                            {!! Form::button('<i class="fas fa-plus"></i> Daftar',
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.perosak.create',$softscape)."'",'class'=>'btn bg-primary btn-sm']) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-fixed table-sm table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-3"></th>
                                    <th class="text-center w-3 align-middle">Tahun</th>
                                    <th class="text-center w-15 align-middle">Kaedah Rawatan Kawalan Perosak</th>
                                    <th class="text-center w-15 align-middle">Tarikh Rawatan Kawalan Perosak</th>
                                    <th class="text-center w-9 align-middle">Tarikh Cipta</th>
                                    <th class="text-center w-8 align-middle">Tarikh Kemaskini</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                @php($index = $perosak->firstItem())
                                @forelse($perosak as $data)
                                <tr>
                                    <th scope="row">{{ $index++ }}</th>
                                    <td class="text-center">{!! $data->created_at ? '<h5><span class="badge badge-primary">'.$data->created_at->format('Y').'</span></h5>' : $null !!}</td>
                                    <td class="text-center">{!! $data->kaedah ?? $null !!}</td>
                                    <td class="text-center">{!! $data->tarikh ?? $null !!}</td>
                                    <td class="text-center">{!! Html::datetime($data->created_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($data->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscapes.perosak.show',$data)."'",'class'=>'btn bg-info btn-sm']) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscapes.perosak.edit',$data)."'",'class'=>'btn bg-warning btn-sm']) !!}
                                            {{--  button delete  --}}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-id'=>$data->id, 'data-toggle'=>'modal','data-target'=>'#modalDelMaklumatRecord']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'landskap lembut berkaitan dengan bahagian
                                perosak') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                @if(count($perosak) > 0)
                <div class="card-footer p-2 border-top-0 d-flex flex-column justify-content-center align-items-center">
                    {!! Html::pagination($perosak) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalMaklumatPerosak" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalMaklumatPerosakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- Modal HTML -->
<div class="modal" id="modalDelMaklumatPerosak" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalDaerahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            {!! Form::open(['method'=>'DELETE','id'=>'modalFormDelMaklumatPerosak']) !!}
            <div class="modal-header bg-gradient-light d-flex justify-content-center p-1 border-0">
                <h3 class="modal-title">Padam Rekod</h3>
            </div>
            <div class="modal-body text-center">
                <p><strong>Adakan anda pasti untuk padam rekod ini?</strong></p>
            </div>
            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0 mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Padam', ['type'=>'submit','class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-js-script')
<script>
    $(document).ready(function () {


        // BS4 Modal Via JavaScript
        $('#modalDelMaklumatPerosak').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var url = '{{ route("pengurusan.softscapes.perosak.destroy", ":id") }}'.replace(':id', id);
            $('#modalFormDelMaklumatPerosak').attr('action', url);
        });

        $('#modalMaklumatPerosak').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalMaklumatPerosak .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //Validation
                validation();

                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalMaklumatPerosak').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalMaklumatPerosak').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        //jquery validation
        function validation() {

            //Date picker
            $('input[name="tarikh"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                maxDate: moment().format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                drops: "down",
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });

            $('#modalFormPerosak').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'warna' : 'required',
                    'bentuk' : 'required',
                    'saiz' : 'required',
                    'musim' : 'required',
                    'tempoh' : 'required',
                },

            });
        }
    });

</script>
@stop
