<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex, noimageindex, nofollow, noarchive,nocache,nosnippet,noodp,noydir">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="suuIPqWFOpGU8NuxAn8CvgD6xH9QMQxHo7y7iUhR">

    <title>Dashboard | eLANDSKAP</title>


    <!-- Scripts -->
    <script src="http://127.0.0.1:8000/js/app.js" defer></script>

    <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->


    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/adminlte.min.css">

    <link rel="stylesheet" href="http://127.0.0.1:8000/css/percentage.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/css/pixel.css">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/daterangepicker/daterangepicker.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- CSS:style -->
    

    <!-- CSS:percentage -->
    

        <link rel="stylesheet" href="http://127.0.0.1:8000/css/tree.css">
    <!-- <style>
        .nav-pills .active {
            background-color: #84cd73 !important
        }
        .nav-pills .nav-item.dropdown.show >.nav-link:hover,
        .nav-pills .show>.nav-link,
        .nav-pills .show>.nav-link:hover{
            background-color: #84cd73 !important;
            color: #ffffff !important
        }

        .nav-pills .nav-link:not(.active):hover {
            color: #84cd73 !important
        }

    </style> -->
    <style>
        .pagination {
            display: flex;
            flex-wrap: wrap; /* Allow buttons to wrap */
        }
    </style>
<link rel='stylesheet' type='text/css' property='stylesheet' href='//127.0.0.1:8000/_debugbar/assets/stylesheets?v=1695153190&theme=auto' data-turbolinks-eval='false' data-turbo-eval='false'><script src='//127.0.0.1:8000/_debugbar/assets/javascript?v=1695153190' data-turbolinks-eval='false' data-turbo-eval='false'></script><script data-turbo-eval="false">jQuery.noConflict(true);</script>

</head>

<body class="sidebar-mini sidebar-collapse layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
       
    </ul>

   eLANDSKAP, Jabatan Landskap Negara
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">        
        <li class="nav-item">
           

        <button onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/profile&#039;" class="nav-link btn bg-purle" type="button"><i class="fa fa-user"></i> Profil</button>

        </li>
         <li class="nav-item">
            <button data-toggle='modal' data-target='#logoutModal' class="nav-link btn bg-purle">
                <i class="fa fa-power-off"></i> Log Keluar
            </button>
        </li>

    </ul>
</nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <style>
    .sidebar {
        overflow-y: scroll; /* Allows vertical scrolling */
    }

    /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
    .sidebar::-webkit-scrollbar {
        display: none; /* Hide scrollbar */
    }

    /* Hide scrollbar for Firefox */
    .sidebar {
        scrollbar-width: none; /* Hide scrollbar for Firefox */
    }
</style>
<aside class="main-sidebar  elevation-4 collapsed" style="background-color: white;">
    <!-- Brand Logo -->
    <a href="http://127.0.0.1:8000/pengurusan/dashboard" class="brand-link navbar">
        <img src="http://127.0.0.1:8000/img/logo-jln-sm.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">eLANDSKAP, JLN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="overflow-y: auto;">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
           <!-- <div class="image">
                <img src="http://127.0.0.1:8000/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>-->
            <div class="info">
                <a href="#" class="d-block">PBT</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            
                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/dashboard&#039;" class="nav-link btn btn-block btn-link text-left active"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></button>
                </li>
                
                                                <li class="nav-item">
                    <button  onclick="window.location=&#039;#&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-shapes"></i><p>ePALM</p></button>
                </li>
                
                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/eLIND&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-chart-pie"></i><p>eLIND</p></button>
                </li>
                
                
                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/eMohon&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-chart-pie"></i><p>eMOHON</p></button>
                </li>
                
                
                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/entiti-lanskap&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-chart-pie"></i><p>Entiti Landskap</p></button>
                </li>
                
                
                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/kempen-tanam&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-chart-pie"></i><p>Kempen Tanam Pokok</p></button>
                </li>
                
                <!-- /.Pengurusan -->

                <!-- Website  -->
                <!-- <li class="nav-header text-uppercase">Laman Web</li>
                <li class="nav-item has-treeview ">
                    <button  class="nav-link btn btn-block
                    btn-link text-left"><i class="nav-icon fas fa-copy"></i><p>Artikel<i class="fas fa-angle-left right"></i></p></button>
                    <ul class="nav nav-treeview">

                                                <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/article&#039;" class="nav-link btn btn-block btn-link text-left "><i class="far fa-circle nav-icon"></i><p>Senarai Artikel</p></button>
                        </li>
                                                                        <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/article/create&#039;" class="nav-link btn btn-block btn-link text-left
                            "><i class="far fa-circle nav-icon"></i><p>Daftar Artikel</p></button>
                        </li>
                                                                        <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/categories&#039;" class="nav-link btn btn-block btn-link text-left "><i class="far fa-circle nav-icon"></i><p>Kategori</p></button>
                        </li>
                                                                        <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/tags&#039;" class="nav-link btn btn-block btn-link text-left "><i class="far fa-circle nav-icon"></i><p>Tag</p></button>
                        </li>
                                            </ul>
                </li>
                <li class="nav-item has-treeview ">
                    <button  class="nav-link btn btn-block
                    btn-link text-left"><i class="nav-icon fas fa-thumbtack"></i><p>Page<i class="fas fa-angle-left right"></i></p></button>
                    <ul class="nav nav-treeview">
                                                <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/page&#039;" class="nav-link btn btn-block btn-link text-left "><i class="far fa-circle nav-icon"></i><p>Senarai Page</p></button>
                        </li>
                                                                        <li class="nav-item">
                            <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/page/create&#039;" class="nav-link btn btn-block btn-link text-left
                            "><i class="far fa-circle nav-icon"></i><p>Daftar Page</p></button>
                        </li>
                                            </ul>
                </li>

                                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/sections&#039;" class="nav-link btn btn-block btn-link text-left
                    "><i class="nav-icon fas fa-boxes"></i><p>Seksyen</p></button>
                </li>
                                                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/activities&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-indent"></i><p>eMohon</p></button>
                </li>
                                                <li class="nav-item">
                    <button  onclick="window.location=&#039;http://127.0.0.1:8000/pengurusan/feedbacks&#039;" class="nav-link btn btn-block btn-link text-left "><i class="nav-icon fas fa-comment-alt"></i><p>Maklumbalas</p></button>
                </li>
                 -->
                <!-- /.Website -->


                

                            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard PBT</h1>
                        </div>
                        <div class="col-sm-6">
                           <!-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"></a></li>
                                <li class="breadcrumb-item"><a href="#"></a></li>
                                <li class="breadcrumb-item active"></li>
                            </ol>-->
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

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
                          Tajuk Permohonan
                        </th>
                        <th class="sorting_disabled" rowspan="1" colspan="1">
                          Jenis Permohonan
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                          PBT
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                        Status
                        </th>
                        <th
                          class="text-center w-10 sorting_disabled"
                          rowspan="1"
                          colspan="1"
                        >
                           	Tarikh Permohonan
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
<!-- /.row -->
</div><!-- /.container -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 6.20.44
    </div>
    Hakcipta Terpelihara &copy; 2024 - 2024 <span class="font-weight-bold text-logo">eLANDSKAP</span> , JLN | eLANDSKAP</span>.

</footer>

        <!-- Modal Logout -->
<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-power-off"></i> Log keluar</h5>
            </div>
            <div class="modal-body text-center border-0">Anda pasti untuk log keluar?</div>
            <div class="modal-footer d-flex  border-0">
                <input id="id" name="id" type="hidden">
                <button class="btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1" data-dismiss="modal" type="button">Batal</button>
                <button onclick="event.preventDefault();
                document.getElementById(&#039;logout-form&#039;).submit();" class="btn bg-olive btn-lg btn-flat btn-block m-0
                ml-1" type="button">Log Keluar</button>
                <form method="POST" action="http://127.0.0.1:8000/logout" accept-charset="UTF-8" id="logout-form" style="display: none;"><input name="_token" type="hidden" value="suuIPqWFOpGU8NuxAn8CvgD6xH9QMQxHo7y7iUhR">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form method="POST" action="http://127.0.0.1:8000/pengurusan/dashboard" accept-charset="UTF-8" id="modalFormDelete"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="suuIPqWFOpGU8NuxAn8CvgD6xH9QMQxHo7y7iUhR">
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-trash"></i> Padam Rekod</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Adakan anda pasti untuk padam rekod ini?</strong></p>
            </div>
            <div class="modal-footer d-flex">
                <button class="btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1" data-dismiss="modal" type="button">Batal</button>
                <button type="submit" class="btn btn-success btn-lg btn-flat btn-block m-0
                ml-1">Padam</button>
            </div>
            </form>
        </div>
    </div>
</div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="http://127.0.0.1:8000/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="http://127.0.0.1:8000/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- daterangepicker -->
    <script src="http://127.0.0.1:8000/plugins/moment/moment.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/moment/locale/ms-my.js"></script>
    <script src="http://127.0.0.1:8000/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 -->
    <script src="http://127.0.0.1:8000/plugins/select2/js/select2.full.min.js"></script>

    <!-- jQuery Validation Plugin -->
    <script src="http://127.0.0.1:8000/js/jquery-validation.min.js"></script>
    <script src="http://127.0.0.1:8000/js/jquery-validation-methods.min.js"></script>
    <script src="http://127.0.0.1:8000/js/jquery-validation-additional.js"></script>

    <!-- AdminLTE App -->
    <script src="http://127.0.0.1:8000/js/adminlte.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

        <script>
    $(document).ready(function () {

        // BS4 Modal Via JavaScript
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var url = button.data('url'); // Extract info from data-* attributes
            $('#modalFormDelete').attr('action', url);
        });
    });
</script>

    <script>
        $(document).ready(function () {
            $(document).ready(function() {
                $('#example').DataTable({
                    responsive: true,
                    paging: false,  // Disable pagination
                    searching: false, // Disable the search bar
                    info: false,      // Disable the "Showing X to Y of Z entries" text
                    autoWidth: false, // Prevent automatic column width calculations
                    ordering: false,
                    dom: 'Bfrtip', // Position of the buttons
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
            });


            // Set minimum width for the first column
            $('#example thead tr').each(function() {
                $(this).find('th').eq(0).css('min-width', '5px'); // First column
            });

            // Center content of the last column
            $('#example tbody tr').each(function() {
                $(this).find('td').last().css('text-align', 'center'); // Last column
            });
            
            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                var $el = $(this);
                $el.toggleClass('active-dropdown');
                var $parent = $(this).offsetParent(".dropdown-menu");
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                $(this).parent("li").toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-menu .show').removeClass("show");
                    $el.removeClass('active-dropdown');
                });

                if (!$parent.parent().hasClass('navbar-nav')) {
                    $el.next().css({
                        "top": $el[0].offsetTop,
                        "left": $parent.outerWidth() - 4
                    });
                }

                return false;
            });



            $('.sidebar .nav-item button.active').parents('li.has-treeview').addClass('menu-open');
            $('.sidebar .menu-open > button').addClass('active');

            moment().format();
            //moment.locale('my-ms');
            moment.locale('en');
            //Initialize Select2 Elements
            $('select:not(.notselect2)').select2({
                theme: 'bootstrap4',
                //dropdownParent: $('.modal')
            });

            $('[data-tooltip="tooltip"]').tooltip();

            $.validator.setDefaults({
                errorElement: 'span',
                validClass: "valid-feedback",
                errorClass: 'invalid-feedback',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });
        });

    </script>

</body>

</html>
