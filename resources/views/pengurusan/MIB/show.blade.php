@extends('layouts.pengurusan.app')

@section('title', 'Butiran Rakan Taman')

@section('content')


    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($MIB, ['route' => ['pengurusan.MIB.update', $MIB],
                'method'=>'PUT','id'=>'formFeedbacks','files' => true]) !!}
                <div class="card-body">
                    <style>
                        .showButton{
                            display: none;
                        }
                        .inertShow {
                            pointer-events: none; /* Ensure no interactions are possible */
                        }

                        .inertShow input,
                        .inertShow span,
                        .inertShow textarea,
                        .inertShow select {
                            background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                            color: rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                            pointer-events: none; /* Ensure no interactions are possible */
                        }
                    </style>
                    @if($MIB->status == "Diluluskan")
                        <div class="table-responsive">
                            <h3>Senarai Aktiviti Rakan Taman - [{{ $MIB->taman }}] </h3>
                            <div class="d-flex justify-content-end" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                'class'=>'btn btn-success btn-sm',
                                'onclick' => "window.location='" . route('pengurusan.MIB_laporan.create', ['id_rakan' => $MIB]) . "'"
                                ]) !!}
                            </div>
                            <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center align-middle w-5">No.</th>
                                        <th class="text-center align-middle">Nama Aktviti</th>
                                        <th class="text-center align-middle wpx-7">Laporan</th>
                                        <th class="text-center align-middle w-8">Tarikh Laporan</th>
                                        <th class="text-center align-middle w-5">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                    @php($index = $MIB_laporan->firstItem())
                                    @forelse($MIB_laporan as $laporan)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{!! $laporan->name !!}</td>
                                        <td>{!! Str::limit($laporan->laporan, 250) !!}</td>
                                        <td class="text-center">{!! $laporan->created_at->format('d-m-Y') !!}</td>
                                        <td>
                                            <div class="btn-group">
                                                {!! Form::button('<i class="fas fa-search"></i>', [
                                                'class'=>'btn btn-info btn-sm',
                                                'onclick'=>"window.location='".route('pengurusan.MIB_laporan.show',$laporan)."'"
                                                ]) !!}
                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                'class'=>'btn btn-warning btn-sm',
                                                'onclick'=>"window.location='".route('pengurusan.MIB_laporan.edit',$laporan)."'"
                                                ]) !!}
                                                {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger
                                                btn-sm',
                                                'data-url'=>route('pengurusan.MIB_laporan.destroy',$laporan->id),
                                                'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    {!! Html::forelse_alert(request('keyword'),'Aktiviti') !!}
                                    @endforelse
                                </tbody>
                            </table>
                            @if($MIB_laporan->count() > 0)
                            <div
                                class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                {!! Html::pagination($MIB_laporan) !!}
                            </div>
                            <!-- /.card-footer -->
                            @endif
                        </div>
                        <br>
                    @endif
                    <br>
                    <h3>Maklumat Rakan Taman</h3>
                    <div inert>
                        @include('pengurusan.MIB._form')
                    </div>

                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pihak Berkuasa Tempatan') || (auth()->user()->hasRole('Pegawai') && $MIB->status == "Diperakui"))
                        @if($MIB->status == "Diperakui" || $MIB->status == "Diluluskan") <div inert> @endif
                            {{ Form::label('ulasan_lawatan', 'KEGUNAAN PIHAK BERKUASA TEMPATAN :', ['class' => 'col-form-label']) }}<br>
                            <div class="p-3 bg-gray">
                                <div class="form-row">

                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('responsed_at', 'Tarikh Tindakan') }}
                                            {{ Form::text('responsed_at',$MIB->responsed_at?$MIB->responsed_at->format('d-m-Y g:m A') : null,
                                            ['class' => 'form-control '.Html::isInvalid($errors,'responsed_at'), 'disabled' => 'disabled']) }}
                                            {!! Html::hasError($errors,'responsed_at') !!}
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('status', 'Status') }}
                                            {{ Form::select('status', $status, 'Diperakui', ['placeholder' => '','class' => 'form-control notselect2']) }}
                                            {!! Html::hasError($errors,'status') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{ Form::label('notes', 'Catatan') }}
                                            {{ Form::textarea('notes',$MIB->form_attachment ? $MIB->form_attachment : null,['rows'=>6,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'notes')]) }}
                                            {!! Html::hasError($errors,'notes') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @if($MIB->status == "Diperakui" || $MIB->status == "Diluluskan") </div> @endif
                    @endif

                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        @if($MIB->status == "Diluluskan") <div inert> @endif
                            {{ Form::label('ulasan_lawatan', 'KEGUNAAN JABATAN :', ['class' => 'col-form-label']) }}<br>
                            <div class="p-3 bg-gray">
                                <div class="form-row">

                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('approved_at', 'Tarikh Tindakan') }}
                                        {{ Form::text('approved_at',$MIB->approved_at?$MIB->approved_at->format('d-m-Y g:m A') : null,
                                        ['class' => 'form-control '.Html::isInvalid($errors,'approved_at'), 'disabled' => 'disabled']) }}
                                            {!! Html::hasError($errors,'approved_at') !!}
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('status', 'Status') }}
                                            {{ Form::select('status', $status, 'Diluluskan', ['placeholder' => '','class' => 'form-control notselect2']) }}
                                            {!! Html::hasError($errors,'status') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            {{ Form::label('notes', 'Catatan') }}
                                            {{ Form::textarea('notes',$MIB->officer ? $MIB->officer : null,['rows'=>6,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'notes')]) }}
                                            {!! Html::hasError($errors,'notes') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @if($MIB->status == "Diluluskan") </div> @endif
                    @endif
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.MIB.index')."'",
                    'class'=>'btn btn-secondary']) !!}
                    {{--
                        {!! 
                            Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.MIB.edit',$MIB)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
                        !!}
                    --}}
                    @if((auth()->user()->hasRole('Pentadbir Sistem|Pegawai') && $MIB->status == "Diperakui") || (auth()->user()->hasRole('Pihak Berkuasa Tempatan') && $MIB->status == "Baru"))
                        {!! Form::button('<i class="fas fa-save"></i> Pengesahan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'value' => 'approve'
                        ]) !!}
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
