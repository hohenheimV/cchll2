@extends('layouts.pengurusan.app') @section('title', 'entitiLandskap')
@section('content')
<section class="content">
  <!-- /.container -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-olive card-outline">
          <div class="card-header">
            <h3 class="card-title font-weight-bold my-1">
              Senarai
            </h3>

            <div class="card-tools">
              <div
                class="btn-toolbar"
                role="toolbar"
                aria-label="Toolbar with button groups"
              >
                <div class="btn-group" role="group" aria-label="First group">
                  <button
                    onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/create'"
                    class="btn bg-success btn-sm"
                    data-tooltip="tooltip"
                    data-placement="top"
                    title=""
                    type="button"
                    data-original-title="Daftar Analisa Statistik"
                  >
                    <i class="fas fa-plus"></i>Daftar
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <div id="example_wrapper" class="dataTables_wrapper no-footer">
                <div id="example_wrapper" class="dataTables_wrapper no-footer">
                  <table
                    id="example"
                    class="responsive table table-bordered table-hover table-striped mb-0 dataTable no-footer dtr-inline"
                  >
                    <thead class="thead-dark">
                      <tr>
                        <th
                          class="w-5 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                          style="min-width: 5px"
                        ></th>
                        <th class="sorting_disabled" rowspan="1" colspan="1">
                          Nama Saintifik
                        </th>
                        <th class="sorting_disabled" rowspan="1" colspan="1">
                          Nama Biasa
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                          Lokasi &amp; Koordinat
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                          Keterangan
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                          Gambar
                        </th>
                        <th
                          class="text-center w-5 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                          Tindakan
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="odd">
                        <td class="dtr-control" tabindex="0">1</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/31"
                              data-text="Jawatan : tesettttttsss"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="even">
                        <td class="dtr-control" tabindex="0">2</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/30"
                              data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon E &amp; F"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="odd">
                        <td class="dtr-control" tabindex="0">3</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/31"
                              data-text="Jawatan : tesettttttsss"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="even">
                        <td class="dtr-control" tabindex="0">4</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/30"
                              data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon E &amp; F"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="odd">
                        <td class="dtr-control" tabindex="0">5</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/31/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/31"
                              data-text="Jawatan : tesettttttsss"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr class="even">
                        <td class="dtr-control" tabindex="0">6</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td style="text-align: center">
                          <div class="btn-group">
                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30'"
                              class="btn bg-info btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Butiran Maklumat Interaktif"
                            >
                              <i class="fas fa-search"></i>
                            </button>

                            <button
                              onclick="window.location='http://127.0.0.1:8000/pengurusan/analisa/30/edit'"
                              class="btn bg-warning btn-sm"
                              data-tooltip="tooltip"
                              data-placement="top"
                              title=""
                              type="button"
                              data-original-title="Kemaskini Maklumat Interaktif"
                            >
                              <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button
                              class="btn btn-danger btn-sm"
                              data-url="http://127.0.0.1:8000/pengurusan/analisa/30"
                              data-text="Jawatan : Peta Tagging Bagi Aset Lembut Mengikut Zon E &amp; F"
                              data-toggle="modal"
                              data-target="#modalDelete"
                              type="button"
                            >
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div
            class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end"
          >
            <div class="text-muted mx-2">
              <small
                >Laman 1 daripada 2, menunjukkan 15 data daripada 30 jumlah
                data, bermula pada baris 1, berakhir pada baris 15</small
              >
            </div>
            <div class="mx-2">
              <div>
                <nav>
                  <ul class="pagination">
                    <li
                      class="page-item disabled"
                      aria-disabled="true"
                      aria-label="pagination.previous"
                    >
                      <span class="page-link" aria-hidden="true">‹</span>
                    </li>

                    <li class="page-item active" aria-current="page">
                      <span class="page-link">1</span>
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        href="http://127.0.0.1:8000/pengurusan/analisa?page=2"
                        >2</a
                      >
                    </li>

                    <li class="page-item">
                      <a
                        class="page-link"
                        href="http://127.0.0.1:8000/pengurusan/analisa?page=2"
                        rel="next"
                        aria-label="pagination.next"
                        >›</a
                      >
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</section>


@endsection
