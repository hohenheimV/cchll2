@extends('layouts.pengurusan.app')

@section('title', 'Audit Butiran Aktiviti')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('Kembali',
                                    ['onclick'=>"window.location='".route('pengurusan.audits.index')."'",'class'=>'btn
                                    btn-secondary']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">


                        <div class="row">
                            <div class="col">
                                <dl class="row">
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                    <dt class='col-sm-4'>Nama</dt>
                                    <dd class='col-sm-6'>
                                        {!! $audit->user ? $audit->user->name : $null !!}</dd>

                                    <dt class='col-sm-4'>Ip Address</dt>
                                    <dd class='col-sm-6'>{{ $audit->ip_address }}</dd>

                                    <dt class='col-sm-4'>URL</dt>
                                    <dd class='col-sm-6'>{{ $audit->url }}</dd>

                                    <dt class='col-sm-4'>Data ID</dt>
                                    <dd class='col-sm-6'>{{ $audit->auditable_id }}</dd>

                                    <dt class='col-sm-4'>Model Type</dt>
                                    <dd class='col-sm-6'>{!! $audit->auditable_type!!}</dd>

                                    <dt class='col-sm-4'>Event Type</dt>
                                    <dd class='col-sm-6'>{!! $audit->event !!}</dd>

                                    <dt class='col-sm-4'>User Agent</dt>
                                    <dd class='col-sm-6'>{{ $audit->user_agent }}</dd>

                                    <dt class='col-sm-4'>Tarikh Aktiviti</dt>
                                    <dd class='col-sm-6'>{{ $audit->created_at->format('d-m-Y g:i A') }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Nilai Asal</h4>
                                <table id="example" class="responsive table table-sm table-bordered">
                                    {{--
                                    @foreach ($audit->old_values as $ky => $older)
                                    <tr>
                                        <td class="w-10">{{ $ky }}</td>
                                        <td>{{ $older }}</td>
                                    </tr>
                                    @endforeach
                                    --}}
                                    @foreach ($audit->old_values as $ky => $older)
                                    <tr>
                                        <td class="w-10">{{ $ky }}</td>
                                        <td>
                                            @if(is_array($older) || is_object($older))
                                                <pre>{{ json_encode($older, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $older }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="col-md-12">
                                <h4>Nilai Baharu</h4>
                                <table id="example" class="responsive table table-sm table-bordered">
                                    {{--
                                    @foreach ($audit->new_values as $ky => $newer)
                                    <tr>
                                        <td class="w-10">{{ $ky }}</td>
                                        <td>{{ $newer }}</td>
                                    </tr>
                                    @endforeach
                                    --}}
                                    @foreach ($audit->new_values as $ky => $newer)
                                    <tr>
                                        <td class="w-10">{{ $ky }}</td>
                                        <td>
                                            @if(is_array($newer) || is_object($newer))
                                                <pre>{{ json_encode($newer, JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $newer }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection
