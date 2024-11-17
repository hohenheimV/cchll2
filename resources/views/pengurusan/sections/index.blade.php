@extends('layouts.pengurusan.app')

@section('title', 'Seksyen')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($modules as $item)
                @if ($item['route'])
                <div class="col-md-3">
                    <div class="small-box bg-default">
                        <div class="inner">
                            <h3>{!! $item['title'] !!}</h3>
                            <p class="card-text">{!! $item['subtitle'] !!}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <a href="{{ $item['route'] ? route($item['route']) : url('#') }}" class="small-box-footer bg-cyan">Maklumat Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                    <!-- /.card -->
                </div>
                @endif
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.card-body -->
    </div><!-- /.card -->
</div><!-- /.container -->
@endsection
