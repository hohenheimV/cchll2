<style>
    .wp-150{
        width: 150px !important;
    }
</style>
<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="7" class="table-secondary">Maklumat Penyelenggaraan</th>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Pemangkasan</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Pemangkasan</th>
        <td class="wp-150">
            <div class="form-group mb-0">
                {{ Form::label('tarikh_pem', 'tarikh_pem',['class'=>'sr-only']) }}
                {{ Form::text('tarikh_pem',null,['placeholder'=>'Tarikh','class' => 'tarikh form-control form-control-sm '.Html::isInvalid($errors,'tarikh_pem')]) }}
                {!! Html::hasError($errors,'tarikh_pem') !!}
            </div>
        </td>

    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Pemangkasan</th>
        <td class="wp-150" colspan="6" style="height: 50px">
            <div class="form-group mb-0">
                {{ Form::label('jenis_pema', 'jenis_pema',['class'=>'sr-only']) }}
                {{ Form::textarea('jenis_pema',null,['placeholder'=>'Jenis Pemangkasan','style'=>'height:60px !important','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_pema')]) }}
                {!! Html::hasError($errors,'jenis_pema') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Pembajaan</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Baja</th>
        <td class="wp-150">
            <div class="form-group mb-0">
                {{ Form::label('tarikh_baj', 'tarikh_baj',['class'=>'sr-only']) }}
                {{ Form::text('tarikh_baj',null,['placeholder'=>'Tarikh','class' => 'tarikh form-control form-control-sm '.Html::isInvalid($errors,'tarikh_baj')]) }}
                {!! Html::hasError($errors,'tarikh_baj') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Baja</th>
        <td class="wp-150" colspan="6" style="height: 50px">
            <div class="form-group mb-0">
                {{ Form::label('jenis_baja', 'jenis_baja',['class'=>'sr-only']) }}
                {{ Form::textarea('jenis_baja',null,['placeholder'=>'Jenis Baja','style'=>'height:60px !important','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_baja')]) }}
                {!! Html::hasError($errors,'jenis_baja') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kaedah Pembajaan</th>
        <td class="wp-150" colspan="6" style="height: 50px">
            <div class="form-group mb-0">
                {{ Form::label('kaedah_baj', 'kaedah_baj',['class'=>'sr-only']) }}
                {{ Form::textarea('kaedah_baj',null,['placeholder'=>'Kaedah Pembajaan','style'=>'height:60px !important','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kaedah_baj')]) }}
                {!! Html::hasError($errors,'kaedah_baj') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Kawalan Perosak</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Rawatan</th>
        <td class="wp-150">
            <div class="form-group mb-0">
                {{ Form::label('tarikh_raw', 'tarikh_raw',['class'=>'sr-only']) }}
                {{ Form::text('tarikh_raw',null,['placeholder'=>'Tarikh','class' => 'tarikh form-control form-control-sm '.Html::isInvalid($errors,'tarikh_raw')]) }}
                {!! Html::hasError($errors,'tarikh_raw') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kaedah Rawatan</th>
        <td class="wp-150" colspan="6" style="height: 50px">
            <div class="form-group mb-0">
                {{ Form::label('kaedah_raw', 'kaedah_raw',['class'=>'sr-only']) }}
                {{ Form::textarea('kaedah_raw',null,['placeholder'=>'Kaedah Rawatan','style'=>'height:60px !important','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kaedah_raw')]) }}
                {!! Html::hasError($errors,'kaedah_raw') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Risiko</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh</th>
        <td class="wp-150">
            <div class="form-group mb-0">
                {{ Form::label('tarikh_ris', 'tarikh_ris',['class'=>'sr-only']) }}
                {{ Form::text('tarikh_ris', null,['placeholder'=>'Tarikh','class' => 'tarikh form-control form-control-sm '.Html::isInvalid($errors,'tarikh_ris')]) }}
                {!! Html::hasError($errors,'tarikh_ris') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Risiko</th>
        <td class="wp-150" colspan="3">
            <div class="form-group mb-0">
                {{ Form::label('jenis_risi', 'jenis_risi',['class'=>'sr-only']) }}
                {{ Form::text('jenis_risi',null,['placeholder'=>'Jenis Risiko','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_risi')]) }}
                {!! Html::hasError($errors,'jenis_risi') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tahap Risiko</th>
        <td class="wp-150" colspan="3">
            <div class="form-group mb-0">
                {{ Form::label('tahap_risi', 'tahap_risi',['class'=>'sr-only']) }}
                {{ Form::text('tahap_risi',null,['placeholder'=>'Tahap Risiko','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tahap_risi')]) }}
                {!! Html::hasError($errors,'tahap_risi') !!}
            </div>
        </td>
    </tr>
</table>
