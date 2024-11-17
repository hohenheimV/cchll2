@section('page-css-style')
<style>
    .card-gambar{
        min-height: 260px !important;
    }
    .card-img{
        min-height: 213px !important;
        width: 100%!important;
        height: 220px!important;
        object-fit: cover;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file],
    .btn-group input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload {
        width: 100%;
    }
</style>
@endsection


<div class="row row-cols-1 row-cols-md-3">
    @foreach (['keseluruhan','batang','daun','bunga','buah'] as $item)
    <div class="col mb-4">
        <div class="card card-gambar" id="card-{{$item}}">

            <img src="{{$gambar->{$item} }}" onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"  class="card-img" id="img-src-{{$item}}" alt="Gambar {{$item}}" />
            <div class="card-footer d-flex p-2">
                <input type="hidden" name="{{$item}}" value="{{ $gambar->{$item} }}" id="img-{{$item}}">
                <div class="flex-grow-1 text-capitalize"><span>{{$item}}</span></div>
                <button id="btn-trash-{{$item}}" type="button" class="btn btn-default btn-sm mr-1"><i class="fas fa-trash-alt"></i></button>
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file btn-sm ">
                        <i class="fas fa-folder-open"></i><input type="file" class="input-image" id="input-{{$item}}">
                    </span>
                </span>
            </div>
        </div>
    </div>
    @endforeach

</div>

@section('page-js-script')
<script>
    $(document).ready( function() {
    	// $(document).on('change', '.btn-file :file', function() {
        //     var input = $(this),
        //         label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        //     input.trigger('fileselect', [label]);
		// });

		// $('.btn-file :file').on('fileselect', function(event, label) {

		//     var input = $(this).parents('.input-group').find(':text'),
		//         log = label;

		//     if( input.length ) {
		//         input.val(log);
		//     } else {
		//         if( log ) alert(log);
		//     }

		// });
		function readURL(input) {
            var idElement = input.id.split("-")[1];
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#img-src-'+idElement).attr('src', e.target.result);
		            $('#img-'+idElement).val(e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$(".input-image").change(function(){
		    readURL(this);
		});
	});

</script>
@stop
