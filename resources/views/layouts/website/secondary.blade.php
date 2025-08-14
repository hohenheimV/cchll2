<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="Jabatan Landskap Negara">
    <meta name="description" content="Jabatan Landskap Negara, Jabatan Landskap Negara">
    <meta name="keywords" content="Taman, Pesekutuan, Bukit, Kiara, Jabatan, Landskap, Negara, TPBK, JLN, KPKT, Taman Awam, Rekreasi">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="google-site-verification" content="H9AQXvBj0Cnj11LZWLCzYI2lIZ5srIczvWXwKu4Xmig" />


    <title>@yield('title') | {{ config('app.name', 'eLANDSKAP , JLN | Jabatan Landskap Negara') }}</title>
    <link rel="icon" type="image/png" href="/img/logo-jln-sm.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Catamaran:700|Roboto:300,400,400i,700,900&display=swap" rel="stylesheet">

    <!-- CSS:style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- CSS:percentage -->
    <link rel="stylesheet" href="{{ asset('css/percentage.css') }}">
    <style>
        #posts {
            flex: 1;
        }
        .mobile-done {
            display: none !important;
        }
        .mobile-fone {
            display: none !important;
        }
        /* Mobile Styles */
        @media only screen and (max-width: 768px) {
            .mobile-gone {
                display: none !important;
            }
            .mobile-done {
                display: block !important;
            }
        }
        @media (min-width: 768px) and (max-width: 1024px) {
            .mobile-fone {
                display: block !important;
            }
        }

        .mib2 {
            background-color:rgb(231, 255, 232) !important;
            background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}");
            /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
        }

        a.btn, button {
            border-radius: 10px !important;
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1300px;
            }
        }
    </style>
    <style>
        .filter-select {
            min-width: 200px;
            max-width: 200px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath fill='%23333' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            margin: 0 8px 8px 0;
        }

        /* Layout for many dropdowns */
        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-start;
        }

        /* Optional: scrollbar for very long select */
        select.filter-select option {
            white-space: nowrap;
        }

        /* For large option lists (scrolling inside dropdown handled by browser) */
    </style>
    <!-- Yield:insert_style -->
    @yield('insert_style')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('layouts.website.elements.navbar')
    <!-- <link rel="stylesheet" href="{{ asset('css/tree.css') }}"> -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
            {{--  @include('layouts.website.elements.footer')  --}}
            <!-- /.section#footer -->
        </div>
        <!-- /.content -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->


        <!-- Main Footer -->
        @include('layouts.website.elements.footer')
    </div>
    <!-- ./wrapper -->
    <!-- Yield:modal -->
    @yield('modal')

    <!-- REQUIRED SCRIPTS -->

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


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
    <script>
        $(document).ready(function() {
            $('#exampleNP').DataTable({
                responsive: false,
                paging: true,
                pageLength: 5,
                searching: true,
                info: true,
                autoWidth: false,
                ordering: true,
                columnDefs: [
                    {
                        targets: [0, 1, -1],
                        orderable: true
                    },
                    {
                        targets: '_all',
                        orderable: true
                    }
                ],
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'copy',
                //         exportOptions: {
                //             columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Copy" export
                //         }
                //     },
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "CSV" export
                //         }
                //     },
                //     {
                //         extend: 'excel',
                //         exportOptions: {
                //             columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Excel" export
                //         }
                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "PDF" export
                //         }
                //     },
                //     {
                //         extend: 'print',
                //         exportOptions: {
                //             columns: ':not(:eq(5), :eq(-1))'  // Only include the first, second, and second last columns in the "Print" export
                //         }
                //     }
                // ],
                // language: {
                //     search: "Carian:",  // Custom text for the search input
                //     searchPlaceholder: "Cari sesuatu...",  // Placeholder text in the search box
                //     info: "Menunjukkan baris _START_ hingga baris _END_ daripada _TOTAL_ jumlah data",  // Info text
                //     infoEmpty: "Tiada rekod yang ditemui",  // Info text when no data is available
                //     infoFiltered: "(disaring daripada _MAX_ jumlah data keseluruhan)",  // Info when filtering
                //     lengthMenu: "Tunjukkan _MENU_ jumlah data",  // Text for "Show entries"
                //     paginate: {
                //         first: "Pertama",  // First page button
                //         previous: "Sebelumnya",  // Previous page button
                //         next: "Seterusnya",  // Next page button
                //         last: "Terakhir"  // Last page button
                //     }
                // }
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
    </script>
    <!-- Yield:insert_js -->
    @yield('insert_js')
</body>

</html>
