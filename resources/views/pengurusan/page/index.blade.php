@extends('layouts.pengurusan.app')

@section('title', 'Page')

@section('page-css-style')
<style>
    .modal-full {
        min-width: 100%;
        margin: 0;
    }

    .modal-full .modal-content {
        min-height: 100vh;
    }

    :root {
        --ck-image-style-spacing: 1.5em;
    }

    .body-content img {
        width: 100%;
    }

    .body-content .image-style-side,
    .body-content .image-style-align-left,
    .body-content .image-style-align-center,
    .body-content .image-style-align-right {
        max-width: 50%;
    }

    .body-content .image-style-side {
        float: right;
        margin-left: var(--ck-image-style-spacing);
    }

    .body-content .image-style-align-left {
        float: left;
        margin-right: var(--ck-image-style-spacing);
    }

    .body-content .image-style-align-center {
        margin-left: auto;
        margin-right: auto;
    }

    .body-content .image-style-align-right {
        float: right;
        margin-left: var(--ck-image-style-spacing);
    }

</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <!--<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Page','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.page.index')."'",'class'=>'btn btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}
							</div>-->

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', ['onclick'=>"window.location='".route('pengurusan.page.create')."'",
                                'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Page') ]) !!}
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
                                    <th>Kategori</th>
                                    <th>Tajuk</th>
                                    <th>Penulis</th>
                                    <th class="text-center w-8">Hits</th>
                                    <th class="text-center w-8">Tarikh Diterbitkan</th>
                                    <th class="text-center w-8">Tarikh Cipta</th>
                                    <th class="text-center w-8">Tarikh Kemaskini</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $pages->firstItem())
                                @forelse($pages as $page)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ isset($page->category) ? $page->category->name : '' }}</td>
                                    <td>{{ $page->title }} {!! $page->is_status != 'publish' ? '<span class="badge badge-warning">'.$page->is_status.'</span>':'' !!}</td>
                                    <td>{{ $page->users['name'] }}</td>
                                    <td class="text-center">{!! $page->visited() !!}</td>
                                    <td class="text-center">{!! Html::datetime($page->published_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($page->created_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($page->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['data-href'=>''.route('pengurusan.page.show',$page).'','data-toggle'=>'modal','data-target'=>'#modalPage',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Papar Page','left')]) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.page.edit',$page)."'",
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Page') ]) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
											'data-url'=>route('pengurusan.page.destroy',$page),
											'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Page') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($pages) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($pages) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

<div class="modal fade" id="modalPage" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalPageLabel" aria-hidden="true">
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
        $('#modalPage').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            // Load URL from data-href
            $('#modalPage .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalPage').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalPage').on('hidden.bs.modal', function () {
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

    });

</script>
@stop
