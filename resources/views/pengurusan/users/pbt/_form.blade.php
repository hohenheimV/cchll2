<style>
    .col-separator {
        position: relative;
        padding-left: 15px;
    }

    .col-separator::before {
        content: '';
        position: absolute;
        top: 5%;
        bottom: 5%;
        left: 0;
        width: 3px;
        background: linear-gradient(to bottom, #ff7f50, #00bfff);
    }
    .col-separator:first-child::before {
        background: none;
    }
</style>

<div class="row inertShow">
    <div class="col-lg col-separator">
        <div class="form-group">
            {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
            {{ Form::text('pbt',null,['placeholder'=>'Sila masukkan pbt', 'inert'=>'inert', 'disabled'=>'disabled', 'class' => 'form-control '.Html::isInvalid($errors,'pbt')]) }}
            {!! Html::hasError($errors,'pbt') !!}
        </div>
        <div class="form-group">
            {{ Form::label('department', 'Unit / Jabatan / Bahagian') }}
            {{ Form::text('department',null,['placeholder'=>'Sila masukkan department','class' => 'form-control '.Html::isInvalid($errors,'department')]) }}
            {!! Html::hasError($errors,'department') !!}
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('phone', 'No. Telefon') }}
                    {{ Form::text('phone',null,['placeholder'=>'Sila masukkan phone','class' => 'form-control '.Html::isInvalid($errors,'phone')]) }}
                    {!! Html::hasError($errors,'phone') !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('position', 'Jawatan') }}
                    {{ Form::text('position',null,['placeholder'=>'Sila masukkan position','class' => 'form-control '.Html::isInvalid($errors,'position')]) }}
                    {!! Html::hasError($errors,'position') !!}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('sv_name', 'Nama Penyelia') }}
                    {{ Form::text('sv_name',null,['placeholder'=>'Sila masukkan sv_name','class' => 'form-control '.Html::isInvalid($errors,'sv_name')]) }}
                    {!! Html::hasError($errors,'sv_name') !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{ Form::label('sv_email', 'Email Penyelia') }}
                    {{ Form::text('sv_email',null,['placeholder'=>'Sila masukkan sv_email','class' => 'form-control '.Html::isInvalid($errors,'sv_email')]) }}
                    {!! Html::hasError($errors,'sv_email') !!}
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg col-separator">
        <div class="form-group">
            {{ Form::label('address1', 'Alamat 1') }}
            {{ Form::text('address1',null,['placeholder'=>'Sila masukkan address1','class' => 'form-control '.Html::isInvalid($errors,'address1')]) }}
            {!! Html::hasError($errors,'address1') !!}
        </div>
        <div class="form-group">
            {{ Form::label('address2', 'Alamat 2') }}
            {{ Form::text('address2',null,['placeholder'=>'Sila masukkan address2','class' => 'form-control '.Html::isInvalid($errors,'address2')]) }}
            {!! Html::hasError($errors,'address2') !!}
        </div>

        <div class="form-row">
            <div class="col-2">
                <div class="form-group">
                    {{ Form::label('postcode', 'Poskod') }}
                    {{ Form::text('postcode',null,['placeholder'=>'Sila masukkan postcode','class' => 'form-control '.Html::isInvalid($errors,'postcode')]) }}
                    {!! Html::hasError($errors,'postcode') !!}
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    {{ Form::label('locality', 'Bandar') }}
                    {{ Form::text('locality',null,['placeholder'=>'Sila masukkan locality','class' => 'form-control '.Html::isInvalid($errors,'locality')]) }}
                    {!! Html::hasError($errors,'locality') !!}
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    {{ Form::label('state', 'Negeri') }}
                    {{ Form::text('state',null,['placeholder'=>'Sila masukkan state', 'inert'=>'inert', 'disabled'=>'disabled', 'class' => 'form-control '.Html::isInvalid($errors,'state')]) }}
                    {!! Html::hasError($errors,'state') !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('address1', 'Alamat 1') }}
            {{ Form::text('address1',null,['placeholder'=>'Sila masukkan address1','class' => 'form-control '.Html::isInvalid($errors,'address1')]) }}
            {!! Html::hasError($errors,'address1') !!}
        </div>
        <div class="form-group">
            {{ Form::label('address2', 'Alamat 2') }}
            {{ Form::text('address2',null,['placeholder'=>'Sila masukkan address2','class' => 'form-control '.Html::isInvalid($errors,'address2')]) }}
            {!! Html::hasError($errors,'address2') !!}
        </div>

        <div class="form-row">
            <div class="col-2">
                <div class="form-group">
                    {{ Form::label('postcode', 'Poskod') }}
                    {{ Form::text('postcode',null,['placeholder'=>'Sila masukkan postcode','class' => 'form-control '.Html::isInvalid($errors,'postcode')]) }}
                    {!! Html::hasError($errors,'postcode') !!}
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    {{ Form::label('locality', 'Bandar') }}
                    {{ Form::text('locality',null,['placeholder'=>'Sila masukkan locality','class' => 'form-control '.Html::isInvalid($errors,'locality')]) }}
                    {!! Html::hasError($errors,'locality') !!}
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    {{ Form::label('state', 'Negeri') }}
                    {{ Form::text('state',null,['placeholder'=>'Sila masukkan state', 'inert'=>'inert', 'disabled'=>'disabled', 'class' => 'form-control '.Html::isInvalid($errors,'state')]) }}
                    {!! Html::hasError($errors,'state') !!}
                </div>
            </div>
        </div>
    </div>
</div> -->
