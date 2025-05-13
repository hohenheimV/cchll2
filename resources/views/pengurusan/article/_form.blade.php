<!-- Main content -->
<div class="col-9">
    <div class="card">
        <div class="card-body p-2">

            <div class="form-group mb-1">
                {{ Form::label('title', 'Tajuk') }}
                {{ Form::text('title',null,['placeholder'=>'Sila masukkan Tajuk','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
                {!! Html::hasError($errors,'title') !!}
            </div>

            <div class="form-group mb-1">
                {{ Form::label('meta_description', 'Keterangan Ringkasan') }}
                {{ Form::text('meta_description',null,['placeholder'=>'Ringkasan','rows'=>5,'class' => 'form-control '.Html::isInvalid($errors,'meta_description')]) }}
                {!! Html::hasError($errors,'meta_description') !!}
            </div>

            <div class="form-group mb-1">
                {{ Form::label('content', 'Kandungan') }}
                {{ Form::textarea('content',null,['id'=>'editor','placeholder'=>'Kandungan','class' => 'form-control '.Html::isInvalid($errors,'content')]) }}
                {!! Html::hasError($errors,'content') !!}
            </div>

            <!-- Include Summernote CSS and JS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
            <!-- Custom CSS for Code View Wrapping -->
            <style>
                /* Custom styling for code view */
                .note-codeview {
                    white-space: pre-wrap; /* Enable text wrapping */
                    word-wrap: break-word; /* Break long words to fit the container */
                }
            </style>
            
            <!-- Form group with Summernote -->
            <!-- <div class="form-group mb-1">
                {{ Form::label('content', 'Kandungan') }}
                {{ Form::textarea('content', null, ['id' => 'kandunganSN', 'placeholder' => 'Kandungan', 'class' => 'form-control ' . Html::isInvalid($errors, 'content')]) }}
                {!! Html::hasError($errors, 'content') !!}
            </div> -->

            <!-- Initialize Summernote with code view enabled -->
            <script>
                $(document).ready(function() {
                    $('#kandunganSN').summernote({
                        height: 300, // Set the height of the editor
                        placeholder: 'Kandungan',
                        toolbar: [
                            // Custom Toolbar Options
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        callbacks: {
                            onInit: function() {
                                console.log('Summernote is initialized');
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<div class="col-3">
    <div class="card">
        <div class="card-header">
            Terbit
        </div>
        <!-- /.card-header -->

        <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between align-items-center py-1">
                {{ Form::label('is_features', 'Features') }}
                {{ Form::checkbox('is_features',1, $article->is_features ?? false) }}
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between align-items-center py-1">
                {{ Form::label('is_status', 'Status',['class'=>'text-sm']) }}
                {{ Form::select('is_status', ['publish'=>'publish'],null,['class'=>'notselect2 custom-select-sm w-50']) }}
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between align-items-center py-1">
                {{ Form::label('layout', 'Layout',['class'=>'text-sm']) }}
                {{ Form::select('layout', ['right'=>'right','left'=>'left','full'=>'full'],null,['class'=>'notselect2 custom-select-sm w-50']) }}
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between align-items-center py-1">
                {{ Form::label('published_at', 'Diterbit Pada',['class'=>'text-sm']) }}
                <div class="input-group w-50">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    {{ Form::text('published_at',null,['class' => 'form-control form-control-sm '.Html::isInvalid($errors,'published_at')]) }}
                </div>
            </li>
        </ul>
        <div class="card-footer">
            {!! Form::button('<i class="fas fa-save"></i> Simpan', ['class'=>'btn btn-success float-right','type'=>'submit']) !!}
        </div>
        <!-- /.card-footer -->
    </div>

    <div class="card">
        <div class="card-header">
            Kategori
        </div>
        <!-- /.card-header -->
        <div class="card-body p-1">
            {{ Form::select('category_id', $categories, null, ['placeholder' => '','class' => 'form-control notselect2']) }}
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-header">
            Tag
        </div>
        <!-- /.card-header -->
        <div class="card-body p-1">

            {!! Form::select('tags[]', $tags, $article->tag ?? null, ['multiple' => true, 'class' => 'form-control select2']) !!}
        </div>
        <!-- /.card-body -->
    </div>



    <div class="card">
        <div class="card-header">
            Imej Features
        </div>
        <div id="holder">
            @isset($article->page_image)
            <img id='img-output' src="{{ $article->page_image ?? '' }}" class="card-img-top" />
            @endisset
        </div>
        <div class="card-footer">
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-default">
                        Pilih
                    </a>
                    <a id="del" class="btn btn-danger text-light">
                        Padam
                    </a>
                </span>
                <input type="hidden" name="page_image" value="{{ $article->page_image ?? '' }}" id="thumbnail">
            </div>
        </div>
    </div>

</div>

@section('page-css-style')
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color: #28a745 !important;
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border: none;
        font-size: 1rem;
        font-weight: 400;
        color: #fff;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
        color: #333;
    }
</style>
@endsection
@section('page-js-script')
<!-- ckeditor -->

<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/jquery-flm-summernote.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
@php
    $url = config('app.url')
@endphp
<script>

    $(document).ready(function () {

        var route_prefix = "{{ $url }}/filemanager";



        $('a#del').click(function() {
            if (confirm('Are you sure?')) {
                $('#img-output').attr('src','');
                $('input#thumbnail').attr('value',null);
            }
        });

        $('#lfm').filemanager('image', {prefix: route_prefix});
        $('#lfmlink').filemanager('file', {prefix: route_prefix});


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


        // Define LFM summernote button
        var LFMlink = function (context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="fas fa-file-upload"></i>',
                tooltip: 'Link  image/file with filemanager',
                click: function () {

                    lfm({ type: 'image', prefix: route_prefix }, function (lfmItems, path) {
                        lfmItems.forEach(function (lfmItem) {
                            //context.invoke('insertImage', lfmItem.url);
                            insertTextLink(lfmItem.url);

                        });
                    });

                }
            });
            return button.render();
        };



        // Initialize summernote with LFM button in the popover button group
        // Please note that you can add this button to any other button group you'd like
        $('#editor').summernote({
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['popovers', ['link','lfm','lfmlink']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        buttons: {
            lfm: LFMButton,
            lfmlink: LFMlink
        }
        });


        function insertTextLink(url){

            $('#editor').summernote('createLink', {
                text: url,
                url: url,
                isNewWindow: true
            });

        }

    });

</script>
@endsection
