<div class="form-row">
    <div class="col-4">
        <div class="form-group">
            {{ Form::label('name', 'Nama Peranan') }}
            {{ Form::text('name',null,['placeholder'=>'Sila Masukkan Nama Peranan','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
            {!! Html::hasError($errors,'name') !!}
        </div>
    </div>
</div>

<div class="form-group">
    <p class="font-weight-bold">Kawalan</p>


    <div class="row">

        @foreach($permissions as $name => $permission)
        <div class="col-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input select-all" id="checkbox-{{$name}}">
                <label class="custom-control-label font-weight-bold  text-capitalize"
                    for="checkbox-{{$name}}">{{$name}}</label>
            </div>
        </div>
        <div class="col-10">
            <div class="form-group wp-10">
                @foreach ($permission as $item)
                <div class="custom-control custom-checkbox custom-control-inline">
                    {{ Form::checkbox('permission[]', $item->id, in_array($item->id, $rolePermissions) ? true : false, ['class'=>'custom-control-input','id' => "checkbox-".$item->name]) }}
                    <label class="custom-control-label font-weight-light" for="checkbox-{{$item->name}}">
                        {{ preg_replace("/^(\w+\s)/", "", str_replace('-',' ',$item->name)) }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        @endforeach
    </div>
</div>

@section('page-js-script')
<script>
    $(document).ready(function () {
        $('.select-all').click(function(event) {

            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox[id^='+this.id+']').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox[id^='+this.id+']').each(function() {
                    this.checked = false;
                });
            }
        });
    });
</script>
@endsection
