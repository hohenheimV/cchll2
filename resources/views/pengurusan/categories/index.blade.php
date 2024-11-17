@extends('layouts.pengurusan.app')

@section('title', 'Kategori')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Kategori','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.categories.index')."'",'class'=>'btn btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', ['data-href'=>''.route('pengurusan.categories.create').'',
                                'data-toggle'=>'modal','data-target'=>'#modalKategori', 'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Kategori')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-5"></th>
                                    <th class="w-5">Name</th>
                                    <th class="w-10">Slug</th>
                                    <th>Keterangan</th>
                                    <th class="w-5">Artikel</th>
                                    <th class="text-center w-8">Tarikh Cipta</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $categories->firstItem())
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td class="text-center">
                                        <h5>{!! Html::badgeColor($category->articles_count,'info') !!}</h5>
                                    </td>
                                    <td class="text-center">{!! Html::datetime($category->cipta_pada,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($category->kemaskini_pada,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['data-href'=>''.route('pengurusan.categories.edit',$category).'','data-toggle'=>'modal','data-target'=>'#modalKategori',
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Kategori','left')]) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Kategori') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($categories->count() > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($categories) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('modal')
<div class="modal fade" id="modalKategori" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalKategoriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')

<script>
    $(document).ready(function () {
        $('#modalKategori').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalKategori .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

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
                    $('#modalKategori').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalKategori').on('hidden.bs.modal', function () {
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
@endsection
