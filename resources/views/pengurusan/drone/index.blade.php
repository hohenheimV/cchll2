@extends('layouts.pengurusan.app')

@section('title', 'Drone')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i>Daftar',
                                ['onclick'=>"window.location='".route('pengurusan.drone.create')."'",
                                'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Drone')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-5"></th>
                                    <th class="w-5">Gambar</th>
                                    <th>Tajuk</th>
                                    <th>Keterangan</th>
                                    <th>Saiz</th>
                                    <th class="text-center w-10">Tarikh Cerapan</th>
                                    <th class="text-center w-10">Tarikh Daftar</th>
                                    <th class="text-center w-10">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $drones->firstItem())
                                @forelse($drones as $drone)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        {!! '<img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar drone"
                                            src="'. asset($drone->gambar ? 'storage/images/shares/drone/'.$drone->gambar : 'img/no-photos.png').'">' !!}
                                    </td>
                                    <td>{{ $drone->tajuk }}</td>
                                    <td>{{ \Str::words($drone->keterangan, 5,'....') }} </td>
                                    <td>{{ $drone->sizeName.' MB' }}</td>
                                    <td class="text-center">{!! Html::datetime($drone->tarikh,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($drone->created_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($drone->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">


                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.drone.show',$drone)."'",
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Drone')
                                            ]) !!}

                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.drone.edit',$drone)."'",
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Drone')
                                            ]) !!}


                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-url'=>route('pengurusan.drone.destroy',$drone),
                                            'data-text'=>'Jawatan : '.$drone->tajuk,
                                            'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Drone') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($drones) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($drones) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('page-js-script')

<script>
    $(document).ready(function () {
        $('#modalDrone').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modaldrone .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

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
                    $('#modalDrone').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalDrone').on('hidden.bs.modal', function () {
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
            $('#modalFormDrone').validate({ //sets up the validator
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
@endsection
