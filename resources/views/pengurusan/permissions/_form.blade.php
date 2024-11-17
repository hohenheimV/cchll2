<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('name', 'Nama') }}
            {{ Form::text('name', $permission->name ?? null ,['placeholder'=>'Sila Masukkan Nama permission','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
            {!! Html::hasError($errors,'name') !!}
        </div>
    </div>
</div>
