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
                <a href="#" class="d-block">Penggiat Industri</a>
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
                            <h1>Dashboard Penggiat Industri</h1>
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
                <form action="/elandskap/elind/contractors/add" class="form-horizontal" novalidate="novalidate" id="ContractorAddForm" method="post" accept-charset="utf-8">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST">
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <div class="form-group">
                                <label class="col-xs-4 control-label"></label>
                                <div class="col-xs-12">
                                    <h4>Butiran Maklumat Kontraktor</h4>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorNama" class="col-md-4 control-label">Nama</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][nama]" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorIdKelas" class="col-md-4 control-label">Kelas Kontraktor</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][id_kelas]" class="form-control" id="ContractorIdKelas" required="required">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">BX</option>
                                        <option value="4">C</option>
                                        <option value="5">D</option>
                                        <option value="6">E</option>
                                        <option value="7">EX</option>
                                        <option value="8">F</option>
                                        <option value="0">TIADA MAKLUMAT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorIdBumi" class="col-md-4 control-label">Taraf Bumiputera</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][id_bumi]" class="form-control" id="ContractorIdBumi">
                                        <option value="1">BUMIPUTERA</option>
                                        <option value="2">BUKAN BUMIPUTERA</option>
                                        <option value="0">TIADA MAKLUMAT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorIdDaftar" class="col-md-4 control-label">Status e-Perunding</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][id_daftar]" class="form-control" id="ContractorIdDaftar" required="required">
                                        <option value="0">Tiada Maklumat</option>
                                        <option value="1">Berdaftar</option>
                                        <option value="2">Tidak Berdaftar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorTngaMahir" class="col-md-4 control-label">Bil. Pekerja Mahir</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][tnga_mahir]" class="form-control" type="number" id="ContractorTngaMahir">
                                </div>
                            </div>


                        </div>

                        <div class="col-lg">
                            <div class="form-group">
                                <label class="col-xs-4 control-label"></label>
                                <div class="col-xs-12">
                                    <h4>Alamat Kontraktor</h4>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorAlamat1" class="col-md-4 control-label">Alamat 1</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][alamat1]" class="form-control" maxlength="50" type="text" id="ContractorAlamat1" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorAlamat2" class="col-md-4 control-label">Alamat 2</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][alamat2]" class="form-control" maxlength="50" type="text" id="ContractorAlamat2">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorPoskod" class="col-md-4 control-label">Poskod</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][poskod]" class="form-control" type="char" id="ContractorPoskod" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorBandar" class="col-md-4 control-label">Bandar</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][bandar]" class="form-control" id="ContractorBandar">
                                        <option value="">(choose one)</option>
                                        <option value="7">Bukit Subang</option>
                                        <option value="8">Kangar</option>
                                        <option value="4">Johor Bahru</option>
                                        <option value="5">Putrajaya</option>
                                        <option value="6">Shah Alam</option>
                                        <option value="11">Kulai</option>
                                        <option value="12">Skudai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorNegeri" class="col-md-4 control-label">Negeri</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][negeri]" class="form-control" id="ContractorNegeri" required="required">
                                        <option value="">(choose one)</option>
                                        <option value="1">Johor</option>
                                        <option value="2">Kedah</option>
                                        <option value="3">Kelantan</option>
                                        <option value="4">Malacca</option>
                                        <option value="5">Negeri Sembilan</option>
                                        <option value="6">Pahang</option>
                                        <option value="7">Penang</option>
                                        <option value="8">Perak</option>
                                        <option value="9">Perlis</option>
                                        <option value="10">Sabah</option>
                                        <option value="11">Sarawak</option>
                                        <option value="12">Selangor</option>
                                        <option value="13">Terengganu</option>
                                        <option value="14">Kuala Lumpur</option>
                                        <option value="15">Putrajaya</option>
                                        <option value="16">Labuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <div class="form-group">
                                <div class="row">
                                    <div class=" col-lg-6">
                                        <!-- <label class="col-xs-4 control-label"></label>
                                        <div class="col-xs-12"> -->
                                            <h4>Butiran Maklumat Kontraktor</h4>
                                        <!-- </div> -->
                                    </div>
                                    <div class=" col-lg-6">
                                        <a id="adda" class="btn btn-success" style="color:white;">
                                            <i class="fas fa-save"></i> Tambah
                                        </a>
                                        <a id="reseta" class="btn btn-success" style="color:white;">
                                            <i class="fas fa-save"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div id="inputContainer" style="border: 1px solid black;">
                                <div class="inputGroup">
                                    <h4>&nbsp;Projek</h4>
                                    <div class="form-group required">
                                        <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek</label>
                                        <div class="col-md-12">
                                            <input name="inputA1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="ContractorNama" class="col-md-4 control-label">Kos</label>
                                        <div class="col-md-12">
                                            <input name="inputB1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label for="ContractorNama" class="col-md-4 control-label">Tahun</label>
                                        <div class="col-md-12">
                                            <input name="data[Contractor][nama]" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                let count = 1;

                                document.getElementById('adda').addEventListener('click', function() {
                                    count++;
                                    const inputContainer = document.getElementById('inputContainer');
                                    const newInputGroup = document.createElement('div');
                                    newInputGroup.className = 'inputGroup';
                                    // newInputGroup.style.border = '1px solid black';
                                    newInputGroup.innerHTML = `
                                        <div style="border-bottom: 1px solid black; width: 100%; margin-bottom: 10px;"></div>
                                        <h4>&nbsp;Projek ${count}</h4>
                                        <div class="form-group required">
                                            <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek${count}</label>
                                            <div class="col-md-12">
                                                <input name="inputA${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ContractorNama" class="col-md-4 control-label">Kos${count}</label>
                                            <div class="col-md-12">
                                                <input name="inputB${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            <label for="ContractorNama" class="col-md-4 control-label">Kos${count}</label>
                                            <div class="col-md-12">
                                                <input name="inputC${count}" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                            </div>
                                        </div>
                                    `;
                                    inputContainer.appendChild(newInputGroup);
                                });

                                document.getElementById('reseta').addEventListener('click', function() {
                                    const inputContainer = document.getElementById('inputContainer');
                                    inputContainer.innerHTML = `
                                        <div class="inputGroup" style="border: 1px solid black;">
                                            <h4>Projek</h4>
                                            <div class="form-group required">
                                                <label for="ContractorNama" class="col-md-4 control-label">Tajuk Projek</label>
                                                <div class="col-md-12">
                                                    <input name="inputA1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorNama" class="col-md-4 control-label">Kos</label>
                                                <div class="col-md-12">
                                                    <input name="inputB1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group required">
                                                <label for="ContractorNama" class="col-md-4 control-label">Tahun</label>
                                                <div class="col-md-12">
                                                    <input name="inputC1" class="form-control" maxlength="50" type="text" id="ContractorNama" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    count = 1;
                                });
                            </script>


                        </div>

                        <div class="col-lg">
                            <div class="form-group">
                                <label class="col-xs-4 control-label"></label>
                                <div class="col-xs-12">
                                    <h4>Alamat Kontraktor</h4>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorAlamat1" class="col-md-4 control-label">Alamat 1</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][alamat1]" class="form-control" maxlength="50" type="text" id="ContractorAlamat1" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorAlamat2" class="col-md-4 control-label">Alamat 2</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][alamat2]" class="form-control" maxlength="50" type="text" id="ContractorAlamat2">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorPoskod" class="col-md-4 control-label">Poskod</label>
                                <div class="col-md-12">
                                    <input name="data[Contractor][poskod]" class="form-control" type="char" id="ContractorPoskod" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ContractorBandar" class="col-md-4 control-label">Bandar</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][bandar]" class="form-control" id="ContractorBandar">
                                        <option value="">(choose one)</option>
                                        <option value="7">Bukit Subang</option>
                                        <option value="8">Kangar</option>
                                        <option value="4">Johor Bahru</option>
                                        <option value="5">Putrajaya</option>
                                        <option value="6">Shah Alam</option>
                                        <option value="11">Kulai</option>
                                        <option value="12">Skudai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="ContractorNegeri" class="col-md-4 control-label">Negeri</label>
                                <div class="col-md-12">
                                    <select name="data[Contractor][negeri]" class="form-control" id="ContractorNegeri" required="required">
                                        <option value="">(choose one)</option>
                                        <option value="1">Johor</option>
                                        <option value="2">Kedah</option>
                                        <option value="3">Kelantan</option>
                                        <option value="4">Malacca</option>
                                        <option value="5">Negeri Sembilan</option>
                                        <option value="6">Pahang</option>
                                        <option value="7">Penang</option>
                                        <option value="8">Perak</option>
                                        <option value="9">Perlis</option>
                                        <option value="10">Sabah</option>
                                        <option value="11">Sarawak</option>
                                        <option value="12">Selangor</option>
                                        <option value="13">Terengganu</option>
                                        <option value="14">Kuala Lumpur</option>
                                        <option value="15">Putrajaya</option>
                                        <option value="16">Labuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
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
