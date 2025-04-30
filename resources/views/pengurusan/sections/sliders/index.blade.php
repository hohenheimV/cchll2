@extends('layouts.pengurusan.app')

@section('title', 'Slider')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <!--<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Slider','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.sliders.index')."'",'class'=>'btn btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}
							</div>-->
                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', ['data-href'=>''.route('pengurusan.sliders.create').'',
                                'data-toggle'=>'modal','data-target'=>'#modalSlider', 'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Slider')
                                ]) !!}
                            </div>
                        
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>Gambar</th>
                                    <th>Tajuk</th>
                                    <th>Keterangan</th>
                                    <th>URL</th>
                                    <th class="w-5">Target</th>
                                    <th class="text-center">Popup</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $sliders->firstItem())
                                @forelse($sliders as $slider)
                                <tr>
                                    <th scope="row">{{ $index++ }}</th>
                                    <td>{!! '<img style="height: 70px" class="image-thumb p-1" alt="Gambar hardscape" src="'.url($slider->slider_image ).'">' !!}</td>
                                    <td>{{ $slider->title ?? 'Tiada Maklumat' }}</td>
                                    <td>{{ $slider->subtitle ?? 'Tiada Url'}}</td>
                                    <td>{{ $slider->url ?? 'Tiada Url'}}</td>
                                    <td>{{ $slider->target }}</td>
                                    <td class="text-center w-5">{!! Html::badgeIcon($slider->popup) !!}</td>
                                    <td class="text-center w-5">{!! Html::badgeIcon($slider->is_active) !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['data-href'=>''.route('pengurusan.sliders.edit',$slider).'','data-toggle'=>'modal','data-target'=>'#modalSlider',
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Slider','left')]) !!}


                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-url'=>route('pengurusan.sliders.destroy',$slider),
                                            'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Slider') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($sliders->count() > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($sliders) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
@section('modal')
@parent
<div class="modal fade" id="modalSlider" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalSliderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->

<script>@php($url = config('app.url')); </script>
@endsection

@section('page-js-script')


<!-- ckeditor -->
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>


<script>
    $(document).ready(function () {

        $('#modalSlider').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalSlider .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                validation();
                imgupload();




                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalSlider').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalSlider').on('hidden.bs.modal', function () {
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
            $('#modalFormSlider').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'image_slider': 'required'
                }
            });
        }

        function imgupload(){


            var route_prefix = "{{ $url }}/filemanager";

                $('a#del').click(function() {
                    if (confirm('Are you sure?')) {
                        $('#img-output').attr('src','');
                        $('input#thumbnail').attr('value',null);
                    }
                });

                $('#lfm').filemanager('image', {prefix: route_prefix});


                $('input[name="published_at"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                    maxDate: moment().add(1, 'year').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                    drops: "down",
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });



                // Define function to open filemanager window
                var lfm = function (options, cb) {
                    console.log('options',options);
                    var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
                    window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
                    window.SetUrl = cb;
                };


                // Define LFM summernote button
                var LFMButton = function (context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-picture"></i> ',
                        tooltip: 'Insert image with filemanager',
                        click: function () {

                            lfm({ type: 'image', prefix: route_prefix }, function (lfmItems, path) {
                                lfmItems.forEach(function (lfmItem) {
                                    context.invoke('insertImage', lfmItem.url);
                                });
                            });

                        }
                    });
                    return button.render();
                };
        }

    });

</script>
@endsection
