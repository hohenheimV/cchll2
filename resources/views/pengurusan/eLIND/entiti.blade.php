@extends('layouts.pengurusan.app')

@section('title', 'PenggXuna')

@section('content')
<section class="content">
                                <!-- /.container -->
                
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-olive card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold my-1">Senarai</h3>

                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">

                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/create'" class="btn bg-success btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Daftar Analisa Statistik"><i class="fas fa-plus"></i>Daftar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <div id="example_wrapper" class="dataTables_wrapper no-footer"><table id="example" class="responsive table table-bordered table-hover table-striped mb-0 dataTable no-footer dtr-inline">
                                <thead class="thead-dark">
                                    <tr><th class="w-5 sorting_disabled" rowspan="1" colspan="1" style="min-width: 5px;"></th><th class="sorting_disabled" rowspan="1" colspan="1">Maklumat Interaktif</th><th class="sorting_disabled" rowspan="1" colspan="1">Saiz</th><th class="text-center w-10 sorting_disabled" rowspan="1" colspan="1">Tarikh Analisa</th><th class="text-center w-10 sorting_disabled" rowspan="1" colspan="1">Tarikh Daftar</th><th class="text-center w-10 sorting_disabled" rowspan="1" colspan="1">Tarikh Kemaskini</th><th class="text-center w-5 sorting_disabled" rowspan="1" colspan="1">Tindakan</th></tr>
                                </thead>
                                <tbody>
                                                                                                                
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                    <tr class="odd">
                                            <td class="dtr-control" tabindex="0">1</td>
                                            <td>tesettttttsss</td>
                                            <td>0.12 MB</td>
                                            <td class="text-center">13-10-2023</td>
                                            <td class="text-center">19-10-2023</td>
                                            <td class="text-center">20-10-2023</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/31" data-text="Jawatan : tesettttttsss" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">2</td>
                                            <td>Peta Tagging Bagi Aset Lembut Mengikut Zon E &amp; F</td>
                                            <td>0.49 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">19-10-2023</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/30" data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon E &amp; F" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">3</td>
                                            <td>Peta Tagging Bagi Aset Lembut Mengikut Zon D</td>
                                            <td>0.54 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/29'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/29/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/29" data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon D" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">4</td>
                                            <td>Peta Tagging Bagi Aset Lembut Mengikut Zon C</td>
                                            <td>0.60 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/28'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/28/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/28" data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon C" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">5</td>
                                            <td>Peta Tagging Bagi Aset Lembut Mengikut Zon B</td>
                                            <td>0.56 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/27'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/27/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/27" data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon B" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">6</td>
                                            <td>Peta Tagging Bagi Aset Lembut Mengikut Zon A</td>
                                            <td>1.32 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/26'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/26/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/26" data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon A" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">7</td>
                                            <td>Peta Tagging Bagi Aset Kejur Keseluruhan Taman Persekutuan Bukit Kiara</td>
                                            <td>1.36 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/25'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/25/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/25" data-text="Jawatan : Peta Tagging Bagi Aset Kejur Keseluruhan Taman Persekutuan Bukit Kiara" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">8</td>
                                            <td>Peta Tagging Bagi Semua Aset Keseluruhan Taman Persekutuan Bukit Kiara</td>
                                            <td>1.51 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/24'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/24/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/24" data-text="Jawatan : Peta Tagging Bagi Semua Aset Keseluruhan Taman Persekutuan Bukit Kiara" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">9</td>
                                            <td>Peta Rujukan Bagi Pokok Tag Besi</td>
                                            <td>1.61 MB</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td class="text-center">28-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/23'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/23/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/23" data-text="Jawatan : Peta Rujukan Bagi Pokok Tag Besi" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">10</td>
                                            <td>Maklumat Keluasan Taman Persekutuan Bukit Kiara</td>
                                            <td>0.16 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/22'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/22/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/22" data-text="Jawatan : Maklumat Keluasan Taman Persekutuan Bukit Kiara" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">11</td>
                                            <td>Maklumat Zonning Taman Persekutuan Bukit Kiara</td>
                                            <td>0.17 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/21'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/21/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/21" data-text="Jawatan : Maklumat Zonning Taman Persekutuan Bukit Kiara" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">12</td>
                                            <td>Maklumat Cerapan Landskap Lembut - Graf</td>
                                            <td>0.08 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/20'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/20/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/20" data-text="Jawatan : Maklumat Cerapan Landskap Lembut - Graf" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">13</td>
                                            <td>Maklumat Jumlah Keseluruhan Cerapan Landskap Lembut</td>
                                            <td>0.17 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/19'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/19/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/19" data-text="Jawatan : Maklumat Jumlah Keseluruhan Cerapan Landskap Lembut" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="even">
                                            <td class="dtr-control" tabindex="0">14</td>
                                            <td>Maklumat Pecahan Cerapan Landskap Lembut Mengikut Zon</td>
                                            <td>0.09 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/18'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/18/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/18" data-text="Jawatan : Maklumat Pecahan Cerapan Landskap Lembut Mengikut Zon" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr><tr class="odd">
                                            <td class="dtr-control" tabindex="0">15</td>
                                            <td>Maklumat Cerapan Landskap Kejur - Graf</td>
                                            <td>0.10 MB</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td class="text-center">19-09-2022</td>
                                            <td style="text-align: center;">
                                                <div class="btn-group">
                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/17'" class="btn bg-info btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Butiran Maklumat Interaktif"><i class="fas fa-search"></i></button>

                                                    <button onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/17/edit'" class="btn bg-warning btn-sm" data-tooltip="tooltip" data-placement="top" title="" type="button" data-original-title="Kemaskini Maklumat Interaktif"><i class="fas fa-pencil-alt"></i></button>


                                                    <button class="btn btn-danger btn-sm" data-url="http://127.0.0.1:8000/pengurusan/analisa/17" data-text="Jawatan : Maklumat Cerapan Landskap Kejur - Graf" data-toggle="modal" data-target="#modalDelete" type="button"><i class="fas fa-trash"></i></button>

                                                </div>
                                            </td>
                                        </tr></tbody>
                            </table></div>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                                            <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                            <div class="text-muted mx-2"><small>Laman 1 daripada 2, menunjukkan 15 data daripada 30 jumlah data, bermula pada baris 1, berakhir pada baris 15</small></div><div class="mx-2"><div><nav>
        <ul class="pagination">
            
                            <li class="page-item disabled" aria-disabled="true" aria-label="pagination.previous">
                    <span class="page-link" aria-hidden="true">‹</span>
                </li>
            
            
                            
                
                
                                                                                        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                                                                                <li class="page-item"><a class="page-link" href="http://127.0.0.1:8000/pengurusan/analisa?page=2">2</a></li>
                                                                        
            
                            <li class="page-item">
                    <a class="page-link" href="http://127.0.0.1:8000/pengurusan/analisa?page=2" rel="next" aria-label="pagination.next">›</a>
                </li>
                    </ul>
    </nav>
</div></div>
                        </div>
                        <!-- /.card-footer -->
                                    </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

                </section>

@endsection
