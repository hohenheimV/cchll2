@extends('layouts.pengurusan.app')

@section('title', 'eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    @hasrole('Pentadbir Sistem')
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>
                    @endhasrole
                    @hasrole('Penggiat Industri')
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') PBT1</h3>
                    @endhasrole
                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.eLAPS.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar eLAPS')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <th class="w-5">Gambar</th>
                                    <th>Nama Entiti Landskap</th>
                                    <th>Keterangan</th>
                                    <!-- <th class="text-center w-10">PBT/ Agensi</th> -->
                                    @hasrole('Pentadbir Sistem')
                                        <th class="text-center w-10">PBT/ Agensi</th>
                                    @endhasrole
                                    @hasrole('Penggiat Industri')
                                        <!-- <th class="text-center w-10">PBT/ Agensi</th> -->
                                    @endhasrole
                                    <th class="text-center w-10">Lokasi</th>
                                    <th class="text-center w-10">Anggaran Nilai</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @hasrole('Pentadbir Sistem')
                                    @php($index = $eLAPS->firstItem())
                                    @forelse($eLAPS as $kempen)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td class="p-0">
                                                {!! '<img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar eLAPS"
                                                    src="'.asset($kempen->gambar_360 ? 'storage/images/shares/eLAPS/'.$kempen->gambar_360 : 'img/no-photos.png').'">' !!}
                                            </td>
                                            <td>{{ (($index-1) % 2 == 0) ? 'Kawasan Unik '.($index-1) : 'Pokok Unik '.($index-1) }}</td>
                                            <td>{{ (($index-1) % 2 == 0) ? 'Kawasan Unik '.($index-1).' ini berkonsepkan...' : 'Pokok Unik '.($index-1).' ini adalah pokok yang pertama...' }} </td>
                                            <td class="text-center">{!! Html::datetime($kempen->tarikh, 'd-m-Y') ? 'PBT '.($index-1) : 'null'  !!}</td>
                                            <td class="text-center">{!! Html::datetime($kempen->created_at, 'd-m-Y') ? 'Lokasi '.($index-1) : 'null'  !!}</td>
                                            <td class="text-center">{!! Html::datetime($kempen->updated_at, 'd-m-Y')  ? 'RM '.number_format(($index - 1) * 2541.143, 2) : 'null' !!}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>',
                                                        ['onclick'=>"window.location='".route('pengurusan.eLAPS.show',$kempen)."'",
                                                        'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran eLAPS')]) !!}
                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                        ['onclick'=>"window.location='".route('pengurusan.eLAPS.edit',$kempen)."'",
                                                        'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini eLAPS')]) !!}
                                                    {!! Form::button('<i class="fas fa-trash"></i>', 
                                                        ['class'=>'btn btn-danger btn-sm',
                                                        'data-url'=>route('pengurusan.eLAPS.destroy',$kempen),
                                                        'data-text'=>'Kempen : '.$kempen->tajuk,
                                                        'data-toggle'=>'modal', 'data-target'=>'#modalDelete']) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center">No data available</td></tr>
                                    @endforelse
                                @endhasrole
                                @hasrole('Penggiat Industri')
                                    @php($index = $eLAPS->firstItem())
                                    @forelse($eLAPS as $kempen)
                                        <!-- Check if the PBT/Agensi matches the user's assigned PBT/Agensi -->
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td class="p-0">
                                                    {!! '<img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar eLAPS"
                                                        src="'.asset($kempen->gambar_360 ? 'storage/images/shares/eLAPS/'.$kempen->gambar_360 : 'img/no-photos.png').'">' !!}
                                                </td>
                                                <td>{{ (($index-1) % 2 == 0) ? 'Kawasan Unik '.($index-1) : 'Pokok Unik '.($index-1) }}</td>
                                                <td>{{ (($index-1) % 2 == 0) ? 'Kawasan Unik '.($index-1).' ini berkonsepkan...' : 'Pokok Unik '.($index-1).' ini adalah pokok yang pertama...' }} </td>
                                                <!-- <td class="text-center">{!! Html::datetime($kempen->tarikh, 'd-m-Y') ? 'PBT 1' : 'null'  !!}</td> -->
                                                <td class="text-center">{!! Html::datetime($kempen->created_at, 'd-m-Y') ? 'Lokasi '.($index-1) : 'null'  !!}</td>
                                                <td class="text-center">{!! Html::datetime($kempen->updated_at, 'd-m-Y')  ? 'RM '.number_format(($index - 1) * 2541.143, 2) : 'null' !!}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        {!! Form::button('<i class="fas fa-search"></i>',
                                                            ['onclick'=>"window.location='".route('pengurusan.eLAPS.show',$kempen)."'",
                                                            'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran eLAPS')]) !!}
                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                            ['onclick'=>"window.location='".route('pengurusan.eLAPS.edit',$kempen)."'",
                                                            'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini eLAPS')]) !!}
                                                        {!! Form::button('<i class="fas fa-trash"></i>', 
                                                            ['class'=>'btn btn-danger btn-sm',
                                                            'data-url'=>route('pengurusan.eLAPS.destroy',$kempen),
                                                            'data-text'=>'Kempen : '.$kempen->tajuk,
                                                            'data-toggle'=>'modal', 'data-target'=>'#modalDelete']) !!}
                                                    </div>
                                                </td>
                                            </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center">No data available for your role.</td></tr>
                                    @endforelse
                                @endhasrole
                                @unlessrole('Pentadbir Sistem|Penggiat Industri')
                                    <tr><td colspan="8" class="text-center">You do not have the necessary permissions to view this data.</td></tr>
                                @endunlessrole
                                
                            </tbody>

                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($eLAPS) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($eLAPS) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
