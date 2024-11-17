@extends('layouts.pengurusan.app')

@section('title', 'Tag')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <!--{{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Tag','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.tags.index')."'",'class'=>'btn btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}-->

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', ['onclick'=>"window.location='".route('pengurusan.tags.create')."'",'class'=>'btn btn-success btn-sm']) !!}
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
                                    <th class="w-5">Label</th>
                                    <th>Tajuk</th>
                                    <th>Keterangan</th>
                                    <th class="w-5">Artikel</th>
                                    <th class="text-center w-8">Tarikh Cipta</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $tags->firstItem())
                                @forelse($tags as $tag)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $tag->label }}</td>
                                    <td>{{ $tag->title }}</td>
                                    <td>{{ $tag->meta_description }}</td>
                                    <td class="text-center">
                                        <h5>{!! Html::badgeColor($tag->articles_count,'info') !!}</h5>
                                    </td>
                                    <td class="text-center">{!! Html::datetime($tag->created_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($tag->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">

                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.tags.edit',$tag)."'",'class'=>'btn btn-warning btn-sm']) !!}

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Tag') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($tags->count() > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($tags) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('modal')
<div class="modal fade" id="modalTag" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTagLabel" aria-hidden="true">
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
        $('#modalTag').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalTag .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

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
                    $('#modalTag').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalTag').on('hidden.bs.modal', function () {
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
            $('#modalFormTag').validate({ //sets up the validator
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
