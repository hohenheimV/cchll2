@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Asas')
@section('card-title', 'Maklumat Asas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">

                    @include('pengurusan.hardscape._pill_nav')
                </div>
                <div class="card-body p-0">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('card-title') </h5>
                        <div class="p-1">
                            {!! Form::button('<i class="fas fa-plus"></i> Daftar',
                            ['data-href'=>''.route('pengurusan.hardscapes.record.create',$hardscape->id).'','data-toggle'=>'modal','data-target'=>'#modalMaklumatRecord',
                            'class'=>'btn bg-primary btn-sm']) !!}
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-fixed table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-3"></th>
                                    <th class="text-center w-3">Tahun</th>
                                    <th class="text-center w-15">Saiz Kanopi</th>
                                    <th class="text-center w-15">Keadaan Semasa</th>
                                    <th class="text-center w-15">Nilai Semasa</th>
                                    <th class="text-center w-15">Status</th>
                                    <th class="text-center w-15">Tarikh</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $records->firstItem())
                                @forelse($records as $data)
                                <tr>
                                    <th scope="row">{{ $index++ }}</th>
                                    <td class="text-center p-1">{!! $data->tarikh ? '<h5><span
                                                class="badge badge-primary">'.Html::datetime($data->tarikh,'Y').'</span></h5>'
                                        : '<span class="badge badge-light">Tiada Maklumat</span>' !!}</td>
                                    <td class="text-center">{!! $data->saiz_kanopi ?? '<span
                                            class="badge badge-light">Tiada Maklumat</span>' !!}</td>
                                    <td class="text-center">{!! $data->keadaan_semasa ?? '<span
                                            class="badge badge-light">Tiada Maklumat</span>' !!}</td>
                                    <td class="text-center">{!! $data->nilai_semasa ?? '<span
                                            class="badge badge-light">Tiada Maklumat</span>' !!}</td>
                                    <td class="text-center">{!! $data->status ?? '<span class="badge badge-light">Tiada
                                            Maklumat</span>' !!}</td>
                                    <td class="text-center">{!! $data->tarikh ?? '<span
                                            class="badge badge-light">Tiada Maklumat</span>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['data-href'=>''.route('pengurusan.hardscapes.record.show',$data).'','data-toggle'=>'modal','data-target'=>'#modalMaklumatRecord',
                                            'class'=>'btn bg-info btn-sm']) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['data-href'=>''.route('pengurusan.hardscapes.record.edit',$data).'','data-toggle'=>'modal','data-target'=>'#modalMaklumatRecord',
                                            'class'=>'btn bg-warning btn-sm']) !!}
                                            {{--  button delete  --}}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm', Html::tooltip('Padam'),
                                            'data-id'=>$data->id, 'data-toggle'=>'modal','data-target'=>'#modalDelMaklumatRecord']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Butiran')!!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                @if(count($records) > 0)
                <div class="card-footer p-2 border-top-0 d-flex flex-column justify-content-center align-items-center">
                    {!! Html::pagination($records) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalMaklumatRecord" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalMaklumatRecordLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- Modal HTML -->
<div class="modal" id="modalDelMaklumatRecord" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalDaerahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            {!! Form::open(['method'=>'DELETE','id'=>'modalFormDelMaklumatRecord']) !!}
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
        $('#modalDelMaklumatRecord').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var url = '{{ route("pengurusan.hardscapes.record.destroy", ":id") }}'.replace(':id', id);
            $('#modalFormDelMaklumatRecord').attr('action', url);
        });

        $('#modalMaklumatRecord').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalMaklumatRecord .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //Date picker
                $('input[name="tarikh"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                    maxDate: moment().endOf('month').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                    drops: "up",
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });

                validation();

                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalMaklumatRecord').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalMaklumatRecord').on('hidden.bs.modal', function () {
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
            $('#modalFormKategori').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'kod_tag': 'required',
                    'kategori': 'required',
                    'jenis': 'required',
                    'tarikh': 'required',
                    'lat': 'required',
                    'lng': 'required',
                }
            });
        }
    });

</script>
@stop
