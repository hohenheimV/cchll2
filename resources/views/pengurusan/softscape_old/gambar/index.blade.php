@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Tambahan')
@section('card-title', 'Maklumat Gambar')

@section('content')
<div class="container-fluid">
    {{-- {!! Html::info_alert('Masih dalam pembangunan/pengujian') !!} --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                    @include('pengurusan.softscape._pill_nav')
                </div>
                <div class="card-body p-0">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('card-title') </h5>
                        <div class="p-1">
                            {!! Form::button('<i class="fas fa-plus"></i> Daftar',
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.gambar.create',$softscape)."'",'class'=>'btn bg-primary btn-sm']) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-fixed table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-3"></th>
                                    <th class="text-center w-3">Tahun</th>
                                    <th class="text-center">Keseluruhan</th>
                                    <th class="text-center">Batang</th>
                                    <th class="text-center">Daun</th>
                                    <th class="text-center w-15">Bunga</th>
                                    <th class="text-center w-15">Buah</th>
                                    <th class="w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                @php($index = $gambar->firstItem())
                                @forelse($gambar as $data)
                                <tr>

                                    <th scope="row">{{ $index++ }}</th>
                                    <td class="text-center">{!! $data->tarikh ? '<h5><span class="badge badge-primary">'.$data->tarikh->format('Y').'</span></h5>' :  $null !!}</td>
                                    <td class="text-center wpx-80">{!! $data->keseluruhan ? '<i class="fas fa-camera fa-2x"></i>':$null !!}</td>
                                    <td class="text-center wpx-80">{!! $data->batang ? '<i class="fas fa-tree fa-2x"></i>':$null !!}</td>
                                    <td class="text-center wpx-80">{!! $data->daun ? '<i class="fas fa-leaf fa-2x"></i>':$null !!}</td>
                                    <td class="text-center wpx-80">{!! $data->bunga ? '<i class="fas fa-spa fa-2x"></i>':$null !!}</td>
                                    <td class="text-center wpx-80">{!! $data->buah ? '<i class="fas fa-pepper-hot fa-2x"></i>':$null !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {{--  button view  --}}
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscapes.gambar.show',$data)."'",'class'=>'btn bg-info btn-sm']) !!}
                                            {{--  button edit  --}}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                            ['onclick'=>"window.location='".route('pengurusan.softscapes.gambar.edit',$softscape)."'",'class'=>'btn bg-warning btn-sm']) !!}
                                            {{--  button delete  --}}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-id'=>$data->id, 'data-toggle'=>'modal','data-target'=>'#modalDelMaklumatRecord']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Gambar') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                @if(count($gambar) > 0)
                <div class="card-footer p-2 border-top-0 d-flex flex-column justify-content-center align-items-center">
                    {!! Html::pagination($gambar) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@section('modal')
<div class="modal fade" id="modalMaklumatGambar" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalMaklumatGambarLabel" aria-hidden="true">
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
        $('#modalMaklumatGambar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalMaklumatGambar .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

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
                    $('#modalMaklumatGambar').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalMaklumatGambar').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        //jquery validation
        function validation() {
            $('#modalFormKategori').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'kod_tag': 'required',
                    'kategori': 'required',
                    'jenis': 'required',
                    'tarikh': 'required',
                    'lat': 'required',
                    'lng': 'required',
                }
            });
        }
    });

</script>
@stop
