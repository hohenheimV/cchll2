@extends('layouts.pengurusan.app')

@section('title', 'Artikel')

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
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            {{ Form::open(['class'=>'form-inline','method' => 'get']) }}
                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Cari Artikel','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.article.index')."'",'class'=>'btn btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', ['onclick'=>"window.location='".route('pengurusan.article.create')."'",
                                'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Artikel') ]) !!}
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
                                    <th class="text-center align-middle">Kategori</th>
                                    <th class="text-center align-middle">Tajuk</th>
                                    <th class="text-center align-middle">Penulis</th>
                                    <th class="text-center align-middle w-8">Hits</th>
                                    <th class="text-center align-middle w-8">Tarikh Diterbitkan</th>
                                    <th class="text-center align-middle w-8">Tarikh Cipta</th>
                                    <th class="text-center align-middle w-8">Tarikh Kemaskini</th>
                                    <th class="text-center align-middle w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $articles->firstItem())
                                @forelse($articles as $article)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ isset($article->category) ? $article->category->name : '' }}</td>
                                    <td>{{ $article->title }} {!! $article->is_status != 'publish' ? '<span class="badge badge-warning">'.$article->is_status.'</span>':'' !!}</td>
                                    <td>{{ isset($article->users) ? $article->users->name : '' }}</td>
                                    <td class="text-center">{!! $article->visited() !!}</td>
                                    <td class="text-center">{!! Html::datetime($article->published_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($article->created_at,'d-m-Y') !!}</td>
                                    <td class="text-center">{!! Html::datetime($article->updated_at,'d-m-Y') !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                            ['data-href'=>''.route('pengurusan.article.show',$article).'','data-toggle'=>'modal','data-target'=>'#modalarticle',
                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Papar Artikel','left')]) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.article.edit',$article)."'",
                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Artikel') ]) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-url'=>route('pengurusan.article.destroy',$article),
                                            'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'article') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($articles) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($articles) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

<div class="modal fade" id="modalarticle" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalarticleLabel" aria-hidden="true">
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
        $('#modalarticle').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            // Load URL from data-href
            $('#modalarticle .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalarticle').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalarticle').on('hidden.bs.modal', function () {
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
