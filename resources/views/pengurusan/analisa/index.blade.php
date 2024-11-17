@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Interaktif')

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

                                    {!! Form::button('<i class="fas fa-plus"></i>Daftar', [
                                        'onclick' => "window.location='" . route('pengurusan.analisa.create') . "'",
                                        'class' => 'btn bg-success btn-sm',
                                        Html::tooltip('Daftar Analisa Statistik'),
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
                                        <th>Maklumat Interaktif</th>
                                        <th>Saiz</th>
                                        <th class="text-center w-10">Tarikh Analisa</th>
                                        <th class="text-center w-10">Tarikh Daftar</th>
                                        <th class="text-center w-10">Tarikh Kemaskini</th>
                                        <th class="text-center w-5">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index = $analisis->firstItem())
                                    @forelse($analisis as $analisa)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $analisa->tajuk }}</td>
                                            <td>{{ $analisa->sizeName.' MB' }}</td>
                                            <td class="text-center">{!! Html::datetime($analisa->tarikh, 'd-m-Y') !!}</td>
                                            <td class="text-center">{!! Html::datetime($analisa->created_at, 'd-m-Y') !!}</td>
                                            <td class="text-center">{!! Html::datetime($analisa->updated_at, 'd-m-Y') !!}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.analisa.show', $analisa) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Maklumat Interaktif'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.analisa.edit', $analisa) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Maklumat Interaktif'),
                                                    ]) !!}


                                                    {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.analisa.destroy', $analisa),
                                                        'data-text' => 'Jawatan : ' . $analisa->tajuk,
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#modalDelete',
                                                    ]) !!}

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        {!! Html::forelse_alert(request('keyword'), 'Maklumat Interaktif') !!}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    @if (count($analisis) > 0)
                        <div
                            class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                            {!! Html::pagination($analisis) !!}
                        </div>
                        <!-- /.card-footer -->
                    @endif
                </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    @section('page-js-script')

        <script>
            $(document).ready(function() {
                $('#modalPanorama').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var href = button.data('href'); // Extract info from data-* attributes
                    $('[data-tooltip="tooltip"]').tooltip('hide');
                    // Load URL from data-href
                    $('#modalPanorama .modal-content').load(href, function(responseTxt, statusTxt, xhr) {

                        //Date picker
                        $('input[name="tarikh"]').daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true,
                            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year')
                                .format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                            maxDate: moment().endOf('month').format(
                            'DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                            drops: "up",
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });

                        validation();

                        //If success load, show modal
                        if (statusTxt == "success") {
                            $('#modalPanorama').modal('show'); // Show Modal start
                            // clear modal content if modal closed
                            $('#modalPanorama').on('hidden.bs.modal', function() {
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
                    $('#modalFormPanorama').validate({ //sets up the validator
                        submitHandler: function(form) {
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
