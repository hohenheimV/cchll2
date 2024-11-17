@extends('layouts.pengurusan.app')

@section('title', 'Manual')

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
                                     @if (Auth::user()->hasRole('Perunding'))
                                     {{--Role is Perunding, Hide Button--}}
                                        
                                    @else
                                    {!! Form::button('<i class="fas fa-plus"></i>Daftar', [
                                        'onclick' => "window.location='" . route('pengurusan.manual.create') . "'",
                                        'class' => 'btn bg-success btn-sm',
                                        Html::tooltip('Daftar Manual'),
                                    ]) !!}
                                    @endif
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
                                        <th>Tajuk</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th class="text-center w-10">Saiz</th>
                                        <th class="text-center w-10">Tarikh Manual</th>
                                        <th class="text-center w-10">Tarikh Daftar</th>
                                        <th class="text-center w-10">Tarikh Kemaskini</th>
                                        <th class="text-center w-5">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index = $manuals->firstItem())
                                    @forelse($manuals as $manual)
                                        @if(Auth::user()->hasRole('Perunding') && $manual->tajuk !== 'Manual Pengguna Laman Web TPBK'  && $manual->tajuk !== 'Manual Aplikasi Mobil eKiara Park')
                                            {{-- Do nothing, skip this manual --}}
                                        @else
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $manual->tajuk }}</td>
                                            {{-- <td>{{ \Str::words($manual->keterangan, 5, '....') }} </td> --}}
                                            <td>{{ $manual->sizeName.' MB' }}</td>
                                            <td class="text-center">{!! Html::datetime($manual->tarikh, 'd-m-Y') !!}</td>
                                            <td class="text-center">{!! Html::datetime($manual->created_at, 'd-m-Y') !!}</td>
                                            <td class="text-center">{!! Html::datetime($manual->updated_at, 'd-m-Y') !!}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.manual.show', $manual) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Muat Turun'),
                                                    ]) !!}
                                            @can('manual-edit')

                                            @php($allow = false)

                                            @if (Auth::user()->hasRole('Perunding'))
                                            @php($allow = false)
                                            @else
                                            @php($allow = true)
                                            @endif

                                            @if ($allow)

                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.manual.edit', $manual) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Manual'),
                                                    ]) !!}

                                            


                                                    {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.manual.destroy', $manual),
                                                        'data-text' => 'Jawatan : ' . $manual->tajuk,
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#modalDelete',
                                                    ]) !!}
                                            @endif
                                            @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @empty
                                        {!! Html::forelse_alert(request('keyword'), 'Manual') !!}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    @if (count($manuals) > 0)
                        <div
                            class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                            {!! Html::pagination($manuals) !!}
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
