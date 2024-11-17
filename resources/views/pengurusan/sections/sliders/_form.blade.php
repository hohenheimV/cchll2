<div class="row">
    <div class="col-12 col-sm-6">
        {{-- <div class="card">
            <div class="card-header">
                Image
            </div>
            <img id='img-output' src="{{ $slider->slider_image ?? '' }}" class="card-img-top" />
        <!-- /.card-header -->
        <div class="card-footer">
            <input type="hidden" name="slider_image" value="{{ $slider->slider_image ?? '' }}" id="img-slider">
            <button id="ckfinder-modal-slider" type="button" class="btn btn-default btn-file">Browse…</button>
        </div>
        <!-- /.card-body -->
    </div> --}}


    <div class="card">
        <div class="card-header">
            Image Slider
        </div>
        <div id="holder">
            @isset($slider->slider_image)
            <img id='img-output' src="{{ $slider->slider_image ?? '' }}" class="card-img-top" />
            @endisset
        </div>
        <div class="card-footer">
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-default">
                        Choose
                    </a>
                    <a id="del" class="btn btn-danger text-light">
                        Delete
                    </a>
                </span>
                <input type="hidden" name="slider_image" value="{{ $slider->slider_image ?? '' }}" id="thumbnail">
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="form-group">
        {{ Form::label('title', 'Tajuk') }}
        {{ Form::text('title',null,['placeholder'=>'Sila masukkan Tajuk','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
        {!! Html::hasError($errors,'title') !!}
    </div>
    <div class="form-group">
        {{ Form::label('subtitle', 'Sub Tajuk') }}
        {{ Form::text('subtitle',null,['placeholder'=>'Sila masukkan Sub Tajuk','class' => 'form-control '.Html::isInvalid($errors,'subtitle')]) }}
        {!! Html::hasError($errors,'subtitle') !!}
    </div>
    <div class="form-group">
        {{ Form::label('url', 'Url') }}
        {{ Form::textarea('url',null,['rows'=>3,'placeholder'=>'Sila masukkan URL','class' => 'form-control '.Html::isInvalid($errors,'url')]) }}
        {!! Html::hasError($errors,'url') !!}
    </div>
    <div class="form-group">
        {{ Form::label('target', 'Target') }}
        {{ Form::select('target', ['_self' => '_self', '_blank' => '_blank'], null, ['placeholder' => '--Pilihan--','class' => 'form-control '.Html::isInvalid($errors,'target')]) }}
        {!! Html::hasError($errors,'target') !!}
    </div>
    <div class="form-group">
        {{ Form::label('is_active', 'Aktif?') }}
        {{ Form::checkbox('is_active',1, $slider->is_active ?? false) }}
        {!! Html::hasError($errors,'is_active') !!}
    </div>

    <div class="form-group">
        {{ Form::label('popup', 'Popup Aktif?') }}
        {{ Form::checkbox('popup',1, $slider->popup ?? false) }}
        {!! Html::hasError($errors,'popup') !!}
    </div>

</div>
