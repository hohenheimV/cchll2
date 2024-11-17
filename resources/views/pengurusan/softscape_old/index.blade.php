@extends('layouts.pengurusan.app')

@section('title', 'Senarai Landskap Lembut')

@section('content')
<style>
    a.rm-link {
        color: #e83e8c !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Landskap Lembut','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.softscape.index')."'",'class'=>'btn
                                    btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <div class="btn-group mr-1" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar',
                                ['data-href'=>''.route('pengurusan.softscape.create').'',
                                'data-toggle'=>'modal','data-target'=>'#modalLandskapLembut', 'class'=>'btn bg-success
                                btn-sm', Html::tooltip('Daftar Landskap Lembut')
                                ]) !!}
                            </div>
                            <div class="btn-group" role="group" aria-label="Second group">
                                {!! Form::button('<i class="fas fa-map"></i> Peta',
                                ['onclick'=>"window.location='".route('pengurusan.softscape.peta')."'",
                                'class'=>'btn bg-maroon btn-sm', Html::tooltip('Peta Landskap Lembut')
                                ]) !!}
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
                                    <th class="w-5">Gambar</th>
                                    <th class="w-10 text-center">Kod Tag</th>
                                    <th>Jenis</th>
                                    <th>Nama Botani</th>
                                    <th>Nama Tempatan</th>
                                    <th>Nama Keluarga</th>
                                    <th class="text-center w-8">Tarikh Cerapan</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $softscapes->firstItem())
                                @forelse($softscapes as $softscape)
                                {{-- {{dd($softscape->gambar->keseluruhan)}} --}}
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        <div class="embed-responsive embed-responsive-4by3">
                                            <img class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item"
                                            onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                                alt="Gambar softscape" src="{{ isset($softscape->gambar->keseluruhan) ? $softscape->gambar->keseluruhan : asset('img/default-150x150.png') }}">
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $softscape->fullKodTag }}</td>
                                    <td>{{ $softscape->jenis }}</td>
                                    <td>{{ $softscape->nama_botani }}</td>
                                    <td>{{ $softscape->nama_tempatan }}</td>
                                    <td>{{ $softscape->nama_keluarga }}</td>
                                    <td class="text-center">{!! Html::datetime($softscape->tarikh,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($softscape->updated_at,'d-m-Y') !!}
                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscape.show',$softscape)."'",
                                            //['data-href'=>''.route('pengurusan.softscape.show',$softscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapLembut',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Landskap Lembut')])
                                            !!}

                                            {!! Form::button('<i class="fas fa-qrcode"></i>',
                                            ['onclick'=>"window.open('".route('pengurusan.softscape.tagging',$softscape)."');",'class'=>'btn btn-secondary btn-sm',
                                            Html::tooltip('Tag')]) !!}

                                            <div class="btn-group">
                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.softscape.edit',$softscape)."'",
                                                //['data-href'=>''.route('pengurusan.softscape.show',$softscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapLembut',
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Landskap Lembut')])
                                                !!}
                                                <button type="button" class="btn btn-warning  btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @foreach ($softscape->records as $record)
                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Tahun '.$record->tarikh,
                                                    ['data-href'=>''.route('pengurusan.softscape.edit',['softscape'=>$softscape,'record'=>$record->id]).'','data-toggle'=>'modal','data-target'=>'#modalLandskapLembutEdit',
                                                    'class'=>'dropdown-item']) !!}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Landskap Lembut') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($softscapes) > 0)
                <div
                    class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($softscapes) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('modal')

<div class="modal fade" id="modalLandskapLembut" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalLandskapLembutLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<div class="modal fade" id="modalLandskapLembutEdit" data-keyboard="false" role="dialog"
    aria-labelledby="modalLandskapLembutEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')
<script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script src="{{ asset('js/readmore/readmore.min.js') }}"></script>
<script>
    $(document).ready(function () {

        $('#modalLandskapLembut').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalLandskapLembut .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //If success load, show modal
                if (statusTxt == "success") {

                    $('input[name="tarikh"]').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                        maxDate: moment().add(1, 'year').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                        drops: "down",
                        locale: {
                            format: 'DD-MM-YYYY'
                        }
                    });


                    validation();

                    $readMoreJS.init({
                        target: '.more p',
                        numOfWords: 50,
                        moreLink: 'baca selanjutnya...',
                        lessLink: 'tutup',
                        toggle: true,
                    });

                    $('img.thumb').on('click', function () {
                        $('img.product-image').attr("src", $(this)[0].src);
                    });

                    $('#modalLandskapLembut').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalLandskapLembut').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });


        });




        $('#modalLandskapLembutEdit').on('show.bs.modal', function (event) {
            //console.log(item);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('#modalLandskapLembutEdit').modal('show'); // Show Modal start

            $('#modalLandskapLembutEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {
                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalLandskapLembut').modal('hide');
                    validation();
                }

            });
        });





    //jquery validation
    function validation() {
        $('#modalFormSoftscape').validate({ //sets up the validator
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'kod_tag': 'required',
                'kategori': 'required',
                'kos_perolehan': 'required',
                'no_rujukan': 'required',
                'keterangan': 'required',
                'nama_botani': 'required',
                'nama_tempatan': 'required',
                'nama_keluarga': 'required',
                'jenis': 'required',
                'tarikh': 'required',
                'lat': 'required',
                'lng': 'required',
            }
        });
    }
    function editSoft(d){
                setTimeout(()=>{
                    modalEdit(d);
                },200)
            }
});

</script>
@include('pengurusan.softscape._ckfinder')
@stop
@endsection
