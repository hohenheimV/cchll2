


@extends('layouts.pengurusan.app')

@section('title', 'Audit Log')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <form class="form-inline" action="{{ route('pengurusan.audits.index') }}" method="get" novalidate>

                                <div class="input-group mr-2">
                                    <input id="keyword" type="text" class="form-control form-control-sm @error('keyword') is-invalid @enderror" name="keyword" value="{{ request('keyword') }}"
                                        autocomplete="nama" autofocus>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-search"></i></button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='{{route('pengurusan.audits.index')}}'">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-primary">
                            <p class="m-0 p-0">Contoh carian: </p>
                            <p class="m-0 p-0">Tarikh : 3/5/2021 atau 3-5-2021</p>
                            <p class="m-0 p-0">IP Address : 171.140.123.70</p>
                            <p class="m-0 p-0">Nama Pegawai : Ali</p>
                            <p class="m-0 p-0">URL : sempadan tpbk</p>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table id="example" class="responsive table table-bordered table-hover table-fixed table-striped table-sm mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="w-5"></th>
                                <th class="text-center w-5">User</th>
                                <th class="text-center w-5">event</th>
                                <th class="text-center w-5">model</th>
                                <th class="text-center w-5">auditable_id</th>
                                <th class="text-center w-5">url</th>
                                <th class="text-center w-5">IP</th>
                                <th class="text-center w-15">Tarikh</th>
                                <th class="text-center w-5"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @php($index = $audits->firstItem())
                            @forelse($audits as $audit)

                            <tr>
                                <th scope="row">{{ $index++ }}</th>
                                <td class="text-center">{!! $audit->user ? $audit->user->name : '' !!}</td>
                                <td class="text-center">{!! $audit->event!!}</td>
                                <td class="text-center">{!! $audit->auditable_type!!}</td>
                                <td class="text-center">{!! $audit->auditable_id!!}</td>
                                <td>{!! $audit->url!!}</td>
                                 <td>{!! $audit->ip_address!!}</td>
                                <td class="text-center">{!! $audit->created_at ? date('d-m-Y H:i A' , strtotime($audit->created_at)) : '-' !!}</td>
                                <td> {!! Form::button('<i class="fas fa-search"></i>', [
                                            'class'=>'btn btn-info btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.audits.show',$audit)."'"
                                            ]) !!}</td>
                            </tr>
                            @empty
                            <p>{{request('keyword')}}</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @if(count($audits) > 0)
                <div class="card-footer d-flex flex-column justify-content-center align-items-center">
                    {{ $audits->links() }}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
