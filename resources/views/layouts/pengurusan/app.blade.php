<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex, noimageindex, nofollow, noarchive,nocache,nosnippet,noodp,noydir">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Jabatan Landskap Negara') }}</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/percentage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pixel.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- CSS:style -->
    {{--  <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    <!-- CSS:percentage -->
    {{--  <link rel="stylesheet" href="{{ asset('css/percentage.css') }}"> --}}

    @yield('page-css-style')
    <link rel="stylesheet" href="{{ asset('css/tree.css') }}">
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
        
        .mobile-done {
            display: none;
        }
        /* Mobile Styles */
        @media only screen and (max-width: 768px) {
            .mobile-gone {
                display: none;
            }
            .mobile-done {
                display: block;
            }
        }
    </style>
    <style>
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ff0000;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #008000;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #008000;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
</head>

<body class="sidebar-mini sidebar-collapse layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper" id="app">
        <!-- Navbar -->
        @include('layouts.pengurusan.elements.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.pengurusan.elements.main-sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
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

            <!-- Main content -->
            <section class="content">
                @include('layouts.pengurusan.notification')
                <!-- /.container -->
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.pengurusan.elements.footer')

        @include('layouts.pengurusan.elements.modal')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/locale/ms-my.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- jQuery Validation Plugin -->
    <script src="{{ asset('js/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation-methods.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation-additional.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
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

    @yield('logout')
    @yield('modal')
    <script>
        $(document).ready(function () {
            $(document).ready(function() {
                $('#example').DataTable({
                    responsive: false,
                    paging: false,  // Disable pagination
                    searching: false, // Disable the search bar
                    info: false,      // Disable the "Showing X to Y of Z entries" text
                    autoWidth: false, // Prevent automatic column width calculations
                    ordering: false,
                    dom: 'Bfrtip', // Position of the buttons
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
                $('#exampleNP').DataTable({
                    responsive: true,
                    paging: true,
                    searching: true,
                    info: true,
                    autoWidth: false,
                    ordering: true,
                    columnDefs: [
                        {
                            targets: [0, 1, -2],
                            orderable: true
                        },
                        // {
                        //     targets: [-3],
                        //     visible: false
                        // },
                        {
                            targets: '_all',
                            orderable: false
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Copy" export
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "CSV" export
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Excel" export
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "PDF" export
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Print" export
                            }
                        }
                    ],
                    language: {
                        search: "Carian:",  // Custom text for the search input
                        searchPlaceholder: "Cari sesuatu...",  // Placeholder text in the search box
                        info: "Menunjukkan baris _START_ hingga baris _END_ daripada _TOTAL_ jumlah data",  // Info text
                        infoEmpty: "Tiada rekod yang ditemui",  // Info text when no data is available
                        infoFiltered: "(disaring daripada _MAX_ jumlah data keseluruhan)",  // Info when filtering
                        lengthMenu: "Tunjukkan _MENU_ jumlah data",  // Text for "Show entries"
                        paginate: {
                            first: "Pertama",  // First page button
                            previous: "Sebelumnya",  // Previous page button
                            next: "Seterusnya",  // Next page button
                            last: "Terakhir"  // Last page button
                        }
                    }
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

            // Set minimum width for the first column
            $('#exampleNP thead tr').each(function() {
                $(this).find('th').eq(0).css('min-width', '5px'); // First column
            });

            // Center content of the last column
            $('#exampleNP tbody tr').each(function() {
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
    @yield('page-js-script')
</body>

</html>
