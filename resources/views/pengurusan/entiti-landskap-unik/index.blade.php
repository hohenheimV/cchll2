@extends('layouts.pengurusan.app')

@section('title', 'Entiti Landskap dan Pokok Berkarakter Unik ')

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

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.entiti-landskap-unik.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar Entiti')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <th class="w-10">Nama Entiti</th>
                                    <th>Keterangan</th>
                                    <th class="text-center w-10">PBT</th>
                                    <th class="text-center w-10">Lokasi</th>
                                    <th class="w-15">Gambar</th>
                                    <th class="text-center w-10">Anggaran Nilai</th>
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $entitiLandskapUnik->firstItem())
                                @forelse($entitiLandskapUnik as $entiti)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ strtoupper($entiti->nama_entiti) }}</td>
                                    <td>
                                        {!! Str::limit($entiti->keterangan, 250) !!}
                                        {{-- $entiti->keterangan --}} 
                                    </td>
                                    <?php
                                        if(isset($entiti->pbt)){
                                            $dataPbt = json_decode($entiti->pbt, true);
                                            if ($dataPbt === null) {
                                                $dataPbt = [];
                                                $pbt = strtoupper($entiti->pbt);
                                            } elseif (!is_array($dataPbt)) {
                                                $dataPbt = (string) $dataPbt;
                                            }else{
                                                $negeri = $dataPbt['negeri'];
                                                $pbt = strtoupper($dataPbt['pbt']);
                                            }
                                        } else {
                                            $dataPbt = [];
                                        }
                                    ?>
                                    <td class="text-center">{{ isset($pbt) ? strtoupper($pbt) : strtoupper($entiti->pbt) }}</td>
                                    <td class="text-center">{{ strtoupper($entiti->lokasi) }}</td>
                                    <td class="p-0">
                                        <?php
                                            if(isset($entiti->gambar)){
                                                $folderName = str_replace(' ', '_', $entiti->id.' '.$entiti->nama_entiti);
                                                $gambarData = json_decode($entiti->gambar, true);

                                                $gambar_input_modal = isset($gambarData['gambar_input_modal_4']) ? $folderName.'/'.$gambarData['gambar_input_modal_4'] : null;
                                                $gambar_input_modal = isset($gambarData['gambar_input_modal_3']) ? $folderName.'/'.$gambarData['gambar_input_modal_3'] : null;
                                                $gambar_input_modal = isset($gambarData['gambar_input_modal_2']) ? $folderName.'/'.$gambarData['gambar_input_modal_2'] : null;
                                                $gambar_input_modal = isset($gambarData['gambar_input_modal_1']) ? $folderName.'/'.$gambarData['gambar_input_modal_1'] : null;
                                                //dd($gambarData);
                                            }else{
                                                $gambar_input_modal = null;
                                            }
                                        ?>
                                        <img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar Entiti" src="{{ isset($gambar_input_modal) ? asset('storage/uploads/entiti_landskap/' . $gambar_input_modal) : asset('storage/uploads/no-photos.png') }}">
                                    </td>
                                    <td class="text-center">{{ $entiti->agensi }}</td>
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.entiti-landskap-unik.show',$entiti)."'",
                                                'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Entiti')]) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.entiti-landskap-unik.edit',$entiti)."'",
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Entiti')]) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', 
                                                ['class'=>'btn btn-danger btn-sm', Html::tooltip('Padam Entiti'),
                                                'data-url'=>route('pengurusan.entiti-landskap-unik.destroy',$entiti),
                                                'data-toggle'=>'modal', 'data-target'=>'#modalDelete']) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Entiti Landskap dan Pokok Berkarakter Unik ') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($entitiLandskapUnik) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($entitiLandskapUnik) !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

