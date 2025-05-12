@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Kempen Tanam Pokok')

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col">
                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                    'class'=>'btn btn-success btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.ktp.create')."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="ktptable" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <!-- <th class="w-5">Gambar</th> -->
                                    <th class="text-center w-15">Nama Program</th>
                                    <th class="text-center w-15">PBT/ Agensi</th>
                                    <th class="text-center w-15">Lokasi</th>
                                    <th class="text-center w-5">Jumlah Pokok Ditanam</th>
                                    {{-- <th class="text-center w-5">Tarikh</th> --}}
                                    <th class="text-center w-5">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($index = $ktps->firstItem())
                                @forelse($ktps as $ktp)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <!-- <td class="p-0">
                                        {!! '<img class="image-thumb p-1 w-75 mx-auto d-block embed-responsive-item" alt="Gambar Kempen Tanam Pokok"
                                            src="'.asset($ktp->gambar_360 ? 'storage/images/shares/ktp/'.$ktp->gambar_360 : 'img/no-photos.png').'">' !!}
                                    </td> -->
                                    <td class="text-center">{{ $ktp->tajuk ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $ktp->pbt ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $ktp->lokasi ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $ktp->jumlah_pokok ?? 'N/A' }}</td>
                                    {{-- <td class="text-center">{{ $ktp->created_at ? $ktp->created_at->format('Y') : 'N/A' }}</td> --}}
                                    <td>
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fas fa-search"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.ktp.show',$ktp)."'",
                                                'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran Maklumat')]) !!}
                                            {!! Form::button('<i class="fas fa-pencil-alt"></i>',
                                                ['onclick'=>"window.location='".route('pengurusan.ktp.edit',$ktp)."'",
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini Maklumat')]) !!}
                                            {!! Form::button('<i class="fas fa-trash"></i>', 
                                                ['class'=>'btn btn-danger btn-sm',
                                                'data-url'=>route('pengurusan.ktp.destroy',$ktp),
                                                'data-text'=>'Kempen : '.$ktp->tajuk,
                                                'data-toggle'=>'modal', 'data-target'=>'#modalDelete',
                                                Html::tooltip('Padam'),
                                                ]) !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {!! Html::forelse_alert(request('keyword'),'Kempen Tanam Pokok') !!}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($ktps) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($ktps) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->

@section('page-js-script')

<style>
@media print {
    #ktptable th:nth-child(6),
    #ktptable td:nth-child(6) {
        display: none !important;
    }
}
</style>

<script>
    $('#ktptable').DataTable({
        responsive: true,
        paging: false,
        searching: true,
        info: false,
        autoWidth: false,
        ordering: true,
        dom: '<"top"fB>rt<"bottom"><"clear">',
        language: {
            search: "Carian:"
        },
        buttons: [
            {
                extend: 'copy',
                text: 'Salin'
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            },
            {
                extend: 'print',
                text: 'Cetak',
                exportOptions: {
                    columns: [0,1,2,3,4]
                }
            }
        ]
    });
</script>
@stop
@endsection
