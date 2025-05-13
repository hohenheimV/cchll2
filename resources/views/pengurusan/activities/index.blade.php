@extends('layouts.pengurusan.app')

@section('title', 'Permohonan Aktiviti')

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

                            {{ Form::select('status',$statusArr,ucwords(str_replace('_', ' ', trim($status))),['placeholder'=>'--Pilihan Status--','class' => 'notselect2 form-control form-control-sm
                            mr-1']) }}

                            <div class="input-group mr-2">
                                {{ Form::search('keyword',request('keyword'),['aria-label'=>'Search','placeholder'=>'Carian Pantas','class' => 'form-control form-control-sm
                                '.Html::isInvalid($errors,'keyword')]) }}
                                <div class="input-group-append">
                                    {!! Form::button('<i class="fas fa-search"></i>', ['class'=>'btn btn-default
                                    btn-sm','type'=>'submit']) !!}
                                    {!! Form::button('Reset',
                                    ['onclick'=>"window.location='".route('pengurusan.activities.index')."'",'class'=>'btn
                                    btn-secondary btn-sm']) !!}
                                </div>
                            </div>
                            {{ Form::close() }}

                            <!--<div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                'class'=>'btn btn-success btn-sm',
                                'onclick'=>"window.location='".route('pengurusan.activities.create')."'",
                                Html::tooltip('Daftar')
                                ]) !!}
                            </div>-->
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
                                    <th class="text-center align-middle w-8">No Permohonan</th>
                                    <th class="text-center align-middle w-8">Tarikh Mohon</th>
                                    <th class="text-center align-middle">Nama/E-Mel Pemohon</th>
                                    <th class="text-center align-middle">Nama Program/Aktiviti</th>
                                    <th class="text-center align-middle" style="width: 240px">Tarikh/Masa</th>
                                    <th class="text-center align-middle">Lokasi</th>
                                    <th class="text-center align-middle wpx-7">Status</th>
                                    <th class="text-center align-middle w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $activities->firstItem())
                                @forelse($activities as $activity)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                        <span class="badge badge-dark">
                                            {{ $activity->ref_num }}
                                        </span>

                                    </td>
                                    <td class="text-center">{!! $activity->created_at->format('d-m-Y') !!}</td>
                                    <td>{!! $activity->name.'<br />'.$activity->email !!}</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>
                                        <span class="badge badge-info mb-1">
                                            <h6 class="m-0">{!! $activity->start_at->format('d-m-Y')!!}
                                        
                                        {{ 'hingga'}} 
                                                {!! $activity->end_at->format('d-m-Y')!!}
                                            </h6>
                                        </span>
                                        <span class="badge badge-primary mb-1">
                                            <h6 class="m-0">{!! $activity->slot!!}</h6>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        
                                         <p class="text-uppercase font-weight-bold m-0">{!! $activity->lokasi ? $activity->zon : 'Tiada Maklumat' !!}</p>
                                        <p class="m-0">{!! $activity->zones['label'] !!}</p>
                                        <p>{!! $activity->zones['text'] !!}</p>
                                        
                                    </td>
                                   
                                    <td>{{ $activity->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>', [
                                            'class'=>'btn btn-info btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.activities.show',$activity)."'"
                                            ]) !!}
                                            @can('activity-edit')

                                            @php($allow = false)
                                            @php($lvel = ucwords(str_replace('_', ' ', trim($status))))


                                            @if (Auth::user()->hasRole('Pengurus Taman') && in_array($lvel,['Permohonan Baru','Dalam Tindakan']))
                                            @php($allow = true)
                                            @elseif (Auth::user()->hasRole('Pengarah Taman') && in_array($lvel,['Pengesahan Sokongan']))
                                            @php($allow = true)
                                            @elseif (Auth::user()->hasRole('KP/ TKP JLN') && in_array($lvel,['Pengesahan Kelulusan']))
                                            @php($allow = true)
                                            @elseif (in_array($lvel,['Lulus','Tidak Lulus']))
                                            @php($allow = true)
                                            @elseif (Auth::user()->hasRole('Pentadbir Sistem'))
                                            @php($allow = true)
                                            @else
                                            @php($allow = false)
                                            @endif

                                            @if ($allow)

                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                            'class'=>'btn btn-warning btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.activities.edit',$activity)."'"
                                            ]) !!}

                                            @endif
                                            @endcan
                                            @can('activity-delete')
                                            {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger btn-sm',
                                            'data-url'=>route('pengurusan.activities.destroy',$activity->id),
                                            'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Kategori') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($activities->count() > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($activities) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
