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
                                <a href="{{ route('pengurusan.MIB.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                &nbsp;&nbsp;&nbsp;
                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                'class'=>'btn btn-success btn-sm',
                                'onclick'=>"window.location='".route('pengurusan.MIB.create')."'",
                                Html::tooltip('Daftar Rakan Taman')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <!-- <th class="text-center align-middle">Nama/E-Mel</th> -->
                                    <th class="text-center align-middle w-15">Nama Rakan Taman</th>
                                    <th class="text-center align-middle w-5">Maklumat Wakil</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                        <th class="text-center w-10">PBT</th>
                                    @endif
                                    <!-- <th class="text-center align-middle w-1">Tarikh Permohonan</th> -->
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                    <th class="text-center align-middle w-1">Penyaluran Peruntukan Promosi</th>
                                    @endif
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
                                    <!-- <td>{!! $rakan_taman->name.'<br />'.$rakan_taman->email !!}</td> -->
                                    <td>
                                        {!! strtoupper($rakan_taman->taman)
                                        .'<br>'
                                        .'<span class="badge badge-secondary" style="white-space: normal; text-align: centre;">' . $rakan_taman->no_siri . '</span>' !!}
                                    </td>
                                    <?php
                                        $rakanTaman = $nama = $telefon = $emel = null;
                                        $setiausaha_maklumat = $penyelaras_maklumat = "Tiada Maklumat";
                                        if(isset($rakan_taman->jawatankuasa)){
                                            $rakanTaman = ($rakan_taman->jawatankuasa);
                                            
                                            if(isset($rakanTaman[2])){
                                                $nama = isset($rakanTaman) ? $rakanTaman[2]['setiausaha_nama'] : 'Tiada Maklumat';
                                                $telefon = isset($rakanTaman) ? $rakanTaman[2]['setiausaha_tel_bimbit'] : 'Tiada Maklumat';
                                                $emel = isset($rakanTaman) ? $rakanTaman[2]['setiausaha_email'] : 'Tiada Maklumat';
                                                $setiausaha_maklumat = ($nama != '' ? strtoupper($nama) : 'Tiada Maklumat') . '<br>' .
                                                    ($telefon != '' ? $telefon : '-') . '<br>' .
                                                    ($emel != '' ? $emel : '-');
                                            }

                                            if(isset($rakanTaman[4])){
                                                $nama = isset($rakanTaman) ? $rakanTaman[4]['penyelaras_nama'] : 'Tiada Maklumat';
                                                $telefon = isset($rakanTaman) ? $rakanTaman[4]['penyelaras_tel_bimbit'] : 'Tiada Maklumat';
                                                $emel = isset($rakanTaman) ? $rakanTaman[4]['penyelaras_email'] : 'Tiada Maklumat';
                                                $penyelaras_maklumat = ($nama != '' ? strtoupper($nama) : 'Tiada Maklumat') . '<br>' .
                                                    ($telefon != '' ? $telefon : '-') . '<br>' .
                                                    ($emel != '' ? $emel : '-');
                                            }
                                        }
                                    ?>
                                    <td class="text-left">
                                        {!! $setiausaha_maklumat !!}
                                        {!! $penyelaras_maklumat != "Tiada Maklumat" ? "<hr>".$penyelaras_maklumat : '' !!}
                                    </td>
                                    @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem'))
                                        <td class="text-center">
                                            {{ strtoupper($rakan_taman->pbt) }}
                                        </td>
                                    @endif
                                    <!-- <td class="text-center">{!! $rakan_taman->created_at->format('d-m-Y') !!}</td> -->
                                    
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                    <td class="text-center">
                                        {!! '<span class="badge badge-success" style="white-space: normal; text-align: centre;width: 100%;">RM ' . number_format($rakan_taman->peruntukan, 2) . '</span>' !!}
                                    </td>
                                    @endif
                                    <td class="text-center">{!! '<span class="badge badge-warning" style="white-space: normal; text-align: centre;width: 100%;">'.$rakan_taman->status.'</span>' !!}</td>
                                    <td class="text-center">{!! '<span class="badge badge-primary" style="white-space: normal; text-align: centre;width: 100%;">'.$rakan_taman->status_keahlian.'</span>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>', [
                                            'class'=>'btn btn-info btn-sm', Html::tooltip('Butiran dan Kemaskini Maklumat Rakan Taman'),
                                            'onclick'=>"window.location='".route('pengurusan.MIB.show',$rakan_taman)."'"
                                            ]) !!}
                                            @if(/* $rakan_taman->status_keahlian == 'Aktif' &&  */$rakan_taman->status == 'Diluluskan')
                                                {!! Form::button('<i class="fas fa-file-alt"></i>', [
                                                    'class' => 'btn btn-success btn-sm', Html::tooltip('Sijil Rakan Taman'),
                                                    'onclick' => "window.open('".route('pengurusan.MIB.generateCertificate', $rakan_taman->ref_num)."', '_blank')"
                                                ]) !!}
                                            @endif
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                            'class'=>'btn btn-warning btn-sm', Html::tooltip('Kemaskini Permohonan Rakan Taman'),
                                            'onclick'=>"window.location='".route('pengurusan.MIB.edit',$rakan_taman)."'"
                                            ]) !!}
                                            @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem'))
                                                {!! Form::button('<i class="fas fa-trash"></i>', ['class'=>'btn btn-danger
                                                btn-sm', Html::tooltip('Padam Rakan Taman'),
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
