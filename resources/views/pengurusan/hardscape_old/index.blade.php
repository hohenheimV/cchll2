@extends('layouts.pengurusan.app')

@section('title', 'Senarai Landskap Kejur')

@section('content')

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
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Hardscape','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.hardscape.index')."'",'class'=>'btn
                                    btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <div class="btn-group mr-1" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar',
                                ['data-href'=>''.route('pengurusan.hardscape.create').'',
                                'data-toggle'=>'modal','data-target'=>'#modalHardscape', 'class'=>'btn bg-success
                                btn-sm', Html::tooltip('Daftar Landskap Kejur')
                                ]) !!}
                            </div>
                            <div class="btn-group" role="group" aria-label="Second group">
                                {!! Form::button('<i class="fas fa-map"></i> Peta',
                                ['onclick'=>"window.location='".route('pengurusan.hardscape.peta')."'",
                                'class'=>'btn bg-maroon btn-sm', Html::tooltip('Peta Landskap Kejur')
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
                                    <th>Nama Struktur</th>
                                    <th class="text-center w-8">Tarikh Cerapan</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php($index = $hardscapes->firstItem())
                                @forelse($hardscapes as $hardscape)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td class="p-0">
                                        <div class="embed-responsive embed-responsive-4by3">

                                            <img class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item"
                                                onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                                alt="Gambar hardscape"
                                                src="{{ $hardscape->gambar_lengkap ? $hardscape->gambar_lengkap : asset('img/default-150x150.png') }}">
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $hardscape->fullKodTag }}</td>
                                    <td>{{ $hardscape->jenis_komponen }}</td>
                                    <td>{{ $hardscape->nama_struktur }}</td>
                                    <td class="text-center">{!! Html::datetime($hardscape->tarikh,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($hardscape->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">

                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.hardscape.show',$hardscape)."'",
                                            //['data-href'=>''.route('pengurusan.hardscape.show',$hardscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapKejur',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Landskap Kejur')])
                                            !!}

                                            {!! Form::button('<i class="fas fa-qrcode"></i>',
                                            ['onclick'=>"window.open('".route('pengurusan.hardscape.tagging',$hardscape)."');",'class'=>'btn
                                            btn-secondary btn-sm',
                                            Html::tooltip('Tag')]) !!}

                                            <div class="btn-group">
                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.hardscape.edit',$hardscape)."'",
                                                //['data-href'=>''.route('pengurusan.hardscape.show',$hardscape).'','data-toggle'=>'modal','data-target'=>'#modalLandskapKejur',
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Landskap
                                                Kejur')])
                                                !!}
                                                <button type="button" class="btn btn-warning  btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @foreach ($hardscape->records as $record)
                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Tahun
                                                    '.$record->tarikh,
                                                    ['data-href'=>''.route('pengurusan.hardscape.edit',['hardscape'=>$hardscape,'record'=>$record->id]).'','data-toggle'=>'modal','data-target'=>'#modalLandskapKejurEdit',
                                                    'class'=>'dropdown-item']) !!}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Hardscape') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($hardscapes) > 0)
                <div
                    class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($hardscapes) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('modal')
<div class="modal fade" id="modalHardscape" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalHardscapeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<div class="modal fade" id="modalHardscapeEdit" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalHardscapeEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')

<script>
    $(document).ready(function () {

        $.validator.setDefaults({
            submitHandler: function(form) {
                console.log(form.submit());
                alert("submitted!");
            }
        });

        $('#modalHardscape').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalHardscape .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //Date picker
                $('input[name="tarikh"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                    maxDate: moment().endOf('month').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                    drops: "up",
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });

                validation();

                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalHardscape').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalHardscape').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        $('#modalHardscapeEdit').on('show.bs.modal', function (event) {
            //console.log(item);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('#modalHardscapeEdit').modal('show'); // Show Modal start

            $('#modalHardscapeEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {
                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalLandskapKejur').modal('hide');
                    validation();
                }

            });
        });

        //jquery validation
        function validation() {
            $('#modalFormHardscape').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'kod_tag': 'required',
                    'kategori': 'required',
                    'kos_pembinaan': 'required',
                    'jenis_komponen': 'required',
                    'nama_struktur': 'required',
                    'keadaan_semasa': 'required',
                    'tarikh': 'required',
                    'lat': 'required',
                    'lng': 'required',
                }
            });
        }
    });

    function editHard(d){
        $('#modalHardscape').modal('hide');
        modalEdit(d);
    }


    /*Bootstrap Modal Pop Up Open Code*/
    function modalEdit(d) {
        //console.log(item);
        var item = d.getAttribute("data-id");
        var href = d.getAttribute("data-href");
        $('#modalHardscapeEdit').modal('show'); // Show Modal start

        $('#modalHardscapeEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {


        });

    }

</script>
@include('pengurusan.hardscape._ckfinder')
@stop
@endsection
