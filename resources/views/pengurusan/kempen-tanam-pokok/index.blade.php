@extends('layouts.pengurusan.app')

@section('title', 'Kempen Tanam Pokok')

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

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.kempen-tanam-pokok.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Kempen Tanam Pokok')]) !!}
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
                                    <th class="text-center w-10">Tarikh Cerapan</th>
                                    <th class="text-center w-10">Tarikh Daftar</th>
                                    <th class="text-center w-10">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $kempenTanamPokok->firstItem())
                                @forelse($kempenTanamPokok as $kempen)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        {!! '<img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar Kempen Tanam Pokok"
                                            src="'.asset($kempen->gambar_360 ? 'storage/images/shares/kempen-tanam-pokok/'.$kempen->gambar_360 : 'img/no-photos.png').'">' !!}
                                    </td>
                                    <td>{{ $kempen->tajuk }}</td>
                                    <td>{{ \Str::words($kempen->keterangan, 10, '....') }} </td>
                                    <td class="text-center">{!! Html::datetime($kempen->tarikh, 'd-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($kempen->created_at, 'd-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($kempen->updated_at, 'd-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.kempen-tanam-pokok.show',$kempen)."'",
                                                'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Kempen Tanam Pokok')]) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.kempen-tanam-pokok.edit',$kempen)."'",
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Kempen Tanam Pokok')]) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', 
                                                ['class'=>'btn btn-danger btn-sm',
                                                'data-url'=>route('pengurusan.kempen-tanam-pokok.destroy',$kempen),
                                                'data-text'=>'Kempen : '.$kempen->tajuk,
                                                'data-toggle'=>'modal', 'data-target'=>'#modalDelete']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Kempen Tanam Pokok') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($kempenTanamPokok) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($kempenTanamPokok) !!}
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
        $('#modalKempen').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalKempen .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                // Date picker
                $('input[name="tarikh"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'),
                    maxDate: moment().endOf('month').format('DD-MM-YYYY'),
                    drops: "up",
                    locale: { format: 'DD-MM-YYYY' }
                });

                validation();

                if (statusTxt == "success") {
                    $('#modalKempen').modal('show');
                    $('#modalKempen').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        // JQuery validation
        function validation() {
            $('#modalFormKempen').validate({
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
