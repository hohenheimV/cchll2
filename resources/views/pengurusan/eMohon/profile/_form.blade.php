<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('name', 'Nama') }}
            {{ Form::text('name',null,['placeholder'=>'Sila masukkan Name','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
            {!! Html::hasError($errors,'name') !!}
        </div>
        <div class="form-group">
            {{ Form::label('email', 'Emel') }}
            {{ Form::email('email',null,['placeholder'=>'Sila masukkan Email','class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
            {!! Html::hasError($errors,'email') !!}
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('password', 'Kata Laluan') }}
                    {{ Form::password('password',['placeholder'=>'Sila Masukkan Kata Laluan','class' => 'form-control '.Html::isInvalid($errors,'password')]) }}
                    {!! Html::hasError($errors,'password') !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('confirm-password', 'Pengesahan Kata Laluan') }}
                    {{ Form::password('confirm-password',['placeholder'=>'Sila Masukkan Kata Laluan','class' => 'form-control '.Html::isInvalid($errors,'confirm-password')]) }}
                    {!! Html::hasError($errors,'confirm-password') !!}
                </div>
            </div>
        </div>
    </div>
</div>
