@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Lokasi')

@section('page-css-style')
    <style>
        .table-softscape .table tr th.table-secondary,
        .table-softscape .table tr th.font-weigt-bold {
            width: 200px;
        }

        .table-softscape .table tr th,
        .table-softscape .table tr td {
            padding: .1rem .3rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-olive card-outline">

                    <div class="card-header border-0">
                        <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('Kembali', [
                                            'onclick' => "window.location='" . route('pengurusan.zon.index') . "'",
                                            'class' => 'btn btn-secondary',
                                        ]) !!}
                                            @can('role-edit')
                                                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                            'class' => 'btn btn-warning btn-sm',
                                            'onclick' => "window.location='" . route('pengurusan.zon.edit', $zon) . "'",
                                        ]) !!}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="tab-content table-softscape text-sm">
                                @include('pengurusan.zon.show._gambar')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="gambarModal" tabindex="-1" role="dialog" aria-labelledby="gambarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <img class="image_preview_container" id="image_preview_container" src=""
                                    alt="preview image" style="max-height: 150px;">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="jenis" value="">
                                    <input type="file" accept=".jpeg,.png,.jpg" name="image" placeholder="Choose image"
                                        id="image">
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Muat Naik</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
