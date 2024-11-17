@extends('layouts.pengurusan.app')

@section('title', 'Menu')

@section('page-css-style')
<style>
    /**
     * Nestable
     */
    .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        max-width: 600px;
        list-style: none;
        font-size: 13px;
        line-height: 20px;
    }

    .dd-list {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dd-list .dd-list {
        padding-left: 30px;
    }

    .dd-collapsed .dd-list {
        display: none;
    }

    .dd-item,
    .dd-empty,
    .dd-placeholder {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 20px;
        font-size: 13px;
        line-height: 20px;
    }

    .dd-handle {
        display: block;
        height: 31px;
        margin: 5px 0;
        padding: 8px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        /*background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;*/
        border-radius: 1px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-handle:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-item>button {
        display: block;
        position: relative;
        cursor: pointer;
        float: left;
        width: 25px;
        height: 20px;
        margin: 5px 0;
        padding: 0;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 0;
        background: transparent;
        font-size: 20px;
        line-height: 1;
        text-align: center;
        font-weight: bold;
    }

    .dd-item>button:before {
        content: '+';
        display: block;
        position: absolute;
        width: 100%;
        text-align: center;
        text-indent: 0;
    }

    .dd-item>button[data-action="collapse"]:before {
        content: '-';
    }

    .dd-placeholder,
    .dd-empty {
        margin: 5px 0;
        padding: 0;
        min-height: 30px;
        background: #f2fbff;
        border: 1px dashed #b6bcbf;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-empty {
        border: 1px dashed #bbb;
        min-height: 100px;
        background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel {
        position: absolute;
        pointer-events: none;
        z-index: 9999;
    }

    .dd-dragel>.dd-item .dd-handle {
        margin-top: 0;
    }

    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
    }

    .btn-group-sm>.btn,
    .btn-xs {
        padding: .25rem;
        font-size: .875rem;
        line-height: 0.5;
        border-radius: .2rem;
    }

    /**
 * Nestable Draggable Handles
 */
    .dd3-content {
        display: block;
        height: 31px;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-dragel>.dd3-item>.dd3-content {
        margin: 0;
    }

    .dd3-item>button {
        margin-left: 30px;
    }

    .dd3-handle {
        position: absolute;
        margin: 0;
        left: 0;
        top: 0;
        cursor: pointer;
        width: 30px;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 3px;
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #fff;
        font-size: 20px;
        font-weight: normal;
    }

    .dd3-handle:hover {
        background: #ddd;
    }

    /**
 * Socialite
 */
    .socialite {
        display: block;
        float: left;
        height: 35px;
    }

    .select2-container {
        width: 90% !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title') Preview</h3>
                </div>
                <div class="card-body p-0">
                    <nav class="navbar navbar-expand-md navbar-light bg-white align-self-center w-100">
                        <a class="navbar-brand d-none d-block d-sm-none" href="#">Navbar</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                @foreach($parentMenus as $menu)
                                @if (count($menu->children))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-uppercase" href="#" id="navbarDropdownMenu{{$menu->slug}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$menu->title}}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg rounded-0" aria-labelledby="navbarDropdownMenu{{$menu->slug}}">
                                        @foreach($menu->children as $children)
                                        @if (count($children->childrens))
                                        <li><a class="dropdown-item dropdown-toggle" href="#">{{ $children->title}}</a>
                                            <ul class="dropdown-menu rounded-0">
                                                @foreach($children->childrens as $childrens)
                                                <li><a class="dropdown-item" href="#">{{ $childrens->title}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li><a class="dropdown-item" href="#">{{ $children->title}}</a></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                <li class="nav-item"><a class="nav-link text-uppercase" href="#">{{$menu->title}}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>
                    <div class="card-tools">
                        {{ Form::open(['route' =>['pengurusan.menu.store'],'id'=>'modalFormHardscape']) }}
                        {{ Form::hidden('output', null,['class' => 'form-control','id'=>'nestable-output']) }}
                        {!! Form::button('<i class="fas fa-save"></i> Simpan', ['class'=>'btn btn-success','type'=>'submit']) !!}
                        <!-- /.modal-footer -->
                        {{ Form::close() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach($parentMenus as $menu)
                            @if (count($menu->children))
                            <li class="dd-item dd3-item" data-id="{{$menu->id}}">
                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$menu->id) }}" data-toggle="modal" data-target="#modalMenu" class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                    <i class=" fas fa-trash-alt"></i>
                                </a>
                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$menu->id) }}" data-toggle="modal" data-target="#modalMenu" class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="dd-handle dd3-handle">&nbsp;</div>
                                <div class="dd3-content">{{$menu->title}}</div>
                                <ol class="dd-list">
                                    @foreach($menu->children as $children)
                                    @if (count($children->childrens))
                                    <li class="dd-item" data-id="{{$children->id}}">
                                        <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$children->id) }}" data-toggle="modal" data-target="#modalMenu"
                                            class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                            <i class=" fas fa-trash-alt"></i>
                                        </a>
                                        <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$children->id) }}" data-toggle="modal" data-target="#modalMenu"
                                            class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="dd-handle dd3-handle">&nbsp;</div>
                                        <div class="dd3-content">{{$children->title}}</div>
                                        <ol class="dd-list">
                                            @foreach($children->childrens as $childrens)
                                            <li class="dd-item" data-id="{{$childrens->id}}">
                                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$childrens->id) }}" data-toggle="modal" data-target="#modalMenu"
                                                    class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                                    <i class=" fas fa-trash-alt"></i>
                                                </a>
                                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$childrens->id) }}" data-toggle="modal" data-target="#modalMenu"
                                                    class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <div class="dd-handle dd3-handle">&nbsp;</div>
                                                <div class="dd3-content">{{$childrens->title}}</div>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </li>
                                    @else
                                    <li class="dd-item dd3-item" data-id="{{$children->id}}">
                                        <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$children->id) }}" data-toggle="modal" data-target="#modalMenu"
                                            class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                            <i class=" fas fa-trash-alt"></i>
                                        </a>
                                        <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$children->id) }}" data-toggle="modal" data-target="#modalMenu"
                                            class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="dd-handle dd3-handle">&nbsp;</div>
                                        <div class="dd3-content">{{$children->title}}</div>
                                    </li>
                                    @endif
                                    @endforeach
                                </ol>
                            </li>
                            @else
                            <li class="dd-item" data-id="{{$menu->id}}">
                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$menu->id) }}" data-toggle="modal" data-target="#modalMenu" class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                    <i class=" fas fa-trash-alt"></i>
                                </a>
                                <a href="javascript:" data-href="{{ route('pengurusan.menu.edit',$menu->id) }}" data-toggle="modal" data-target="#modalMenu" class="btn bg-info btn-sm btn-flat float-right m-0 p-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="dd-handle dd3-handle">&nbsp;</div>
                                <div class="dd3-content">{{$menu->title}}</div>
                            </li>
                            @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
                <!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

</div><!-- /.container -->
@endsection

@section('modal')
<div class="modal fade" id="modalMenu" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalMenuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')
<!-- AdminLTE App -->
<script src="{{ asset('js/jquery.nestable.js') }}"></script>
<script>
    $( document ).ready( function () {

        $('#modalMenu').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var href = button.data('href');             // Extract info from data-* attributes
            // Load URL from data-href
            $('#modalMenu .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //If success load, show modal
                if (statusTxt == "success") {

                    //validation();

                    $('select:not(.notselect2)').select2({
                        theme: 'bootstrap4'
                    });

                    $('#modalMenu').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalMenu').on('hidden.bs.modal', function () {
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        //jquery validation
        function validation(){
            $('#modalFormKategori').validate({//sets up the validator
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

        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                console.log(list.nestable('serialize'));
                //console.log(window.JSON.stringify(list.nestable('serialize')));
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            maxDepth: 3
        })
        .on('change', updateOutput);

        updateOutput($('#nestable').data('output', $('#nestable-output')));

        // activate Nestable for list 1
        //$('#nestable2').nestable({
        //    maxDepth: 3
        //})
        //.on('change', updateOutput);

        //updateOutput($('#nestable2').data('output', $('#nestable-output2')));

    });

</script>
@endsection
