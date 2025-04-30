@extends('layouts.pengurusan.app')

@section('title', 'Rakan Taman')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                'class'=>'btn btn-success btn-sm',
                                'onclick'=>"window.location='".route('pengurusan.MIB.create')."'",
                                Html::tooltip('Daftar')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <!-- <th class="text-center align-middle w-1">No Permohonan</th> -->
                                    <!-- <th class="text-center align-middle">Nama/E-Mel</th> -->
                                    <th class="text-center align-middle w-15">Taman Perumahan</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|TKP/B JLN'))
                                        <th class="text-center w-11">PBT</th>
                                    @endif
                                    <!-- <th class="text-center align-middle w-1">Tarikh Permohonan</th> -->
                                    <th class="text-center align-middle w-1">Penyaluran Peruntukan Promosi</th>
                                    <th class="text-center align-middle w-1">Status Permohonan</th>
                                    <th class="text-center align-middle w-1">Status Rakan Taman</th>
                                    <th class="text-center align-middle w-1">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                @php($index = $MIB->firstItem())
                                @forelse($MIB as $rakan_taman)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <!-- <td>
                                        <span class="badge badge-dark">
                                            {!! $rakan_taman->ref_num ?? $null !!}
                                        </span>
                                    </td> -->
                                    <!-- <td>{!! $rakan_taman->name.'<br />'.$rakan_taman->email !!}</td> -->
                                    <td>{{ $rakan_taman->taman }}</td>
                                    @if(Auth::user()->hasRole('TKP/B JLN|Pegawai|Pentadbir Sistem'))
                                        <td>
                                            {{ $rakan_taman->pbt }}
                                        </td>
                                    @endif
                                    <!-- <td class="text-center">{!! $rakan_taman->created_at->format('d-m-Y') !!}</td> -->
                                    <td class="text-center">
                                        {!! '<span class="badge badge-success" style="white-space: normal; text-align: centre;width: 100%;">RM ' . number_format($rakan_taman->peruntukan, 2) . '</span>' !!}
                                    </td>
                                    <td class="text-center">{!! '<span class="badge badge-warning" style="white-space: normal; text-align: centre;width: 100%;">'.$rakan_taman->status.'</span>' !!}</td>
                                    <td class="text-center">{!! '<span class="badge badge-primary" style="white-space: normal; text-align: centre;width: 100%;">'.$rakan_taman->status_keahlian.'</span>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>', [
                                            'class'=>'btn btn-info btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.MIB.show',$rakan_taman)."'"
                                            ]) !!}
                                            @if($rakan_taman->status_keahlian == 'Aktif' && $rakan_taman->status == 'Diluluskan')
                                                {!! Form::button('<i class="fas fa-file-alt"></i>', [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'onclick' => "window.open('".route('pengurusan.MIB.generateCertificate', $rakan_taman->ref_num)."', '_blank')"
                                                ]) !!}
                                            @endif
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                            'class'=>'btn btn-warning btn-sm',
                                            'onclick'=>"window.location='".route('pengurusan.MIB.edit',$rakan_taman)."'"
                                            ]) !!}
                                            @if(Auth::user()->hasRole('TKP/B JLN|Pegawai|Pentadbir Sistem'))
                                                {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger
                                                btn-sm',
                                                'data-url'=>route('pengurusan.MIB.destroy',$rakan_taman->id),
                                                'data-toggle'=>'modal','data-target'=>'#modalDelete']) !!}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Rakan Taman') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if($MIB->count() > 0)
                <div
                    class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($MIB) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
