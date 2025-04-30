@extends('layouts.pengurusan.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .mib {
        background-color:rgb(25, 98, 92) !important;
        background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}");
    }
</style>
<div class="container-fluid">
    <div class="row" id="elaps">
        {!! stats_card('Jumlah Permohonan Projek', app_dashboard_permohonan(), 'javascript:void(0)', 'fas fa-paper-plane', '#17a2b8') !!}
        {!! stats_card('Projek B. Pengurusan Landskap', app_dashboard_permohonan(1), route('pengurusan.eLAPS.index'), 'fas fa-paper-plane', '#1bc3de') !!}
        {!! stats_card('Projek B. Taman Awam', app_dashboard_permohonan(2), route('pengurusan.eLAPS.index'), 'fas fa-paper-plane', '#1fb3ff') !!}
        {!! stats_card('Projek B. Pembangunan Landskap', app_dashboard_permohonan(3), route('pengurusan.eLAPS.index'), 'fas fa-paper-plane', '#1fa4ff') !!}
        {!! stats_card('Projek B. Khidmat Teknikal', app_dashboard_permohonan(4), route('pengurusan.eLAPS.index'), 'fas fa-paper-plane', '#1f95ff') !!}
        {!! stats_card('Projek B. Penyelidikan & Pemulihan', app_dashboard_permohonan(5), route('pengurusan.eLAPS.index'), 'fas fa-paper-plane', '#1f86ff') !!}
    </div>
    <div class="row" id="epalm">
        {!! stats_card('Jumlah Taman Setakat ' . date('Y'), app_dashboard_taman(), 'javascript:void(0)', 'fas fa-leaf', ' #145a32 ') !!}
        {!! stats_card('Jumlah Taman Awam', app_dashboard_taman(1), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #196f3d ') !!}
        {!! stats_card('Jumlah Taman Botani', app_dashboard_taman(2), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #1e8449 ') !!}
        {!! stats_card('Jumlah Landskap Perbandaran', app_dashboard_taman(3), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #229954 ') !!}
        {!! stats_card('Jumlah Persekitaran Kehidupan', app_dashboard_taman(4), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #27ae60 ') !!}
        {!! stats_card('Jumlah Taman Persekutuan', app_dashboard_taman(5), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #16a085 ') !!}
        {!! stats_card('Jumlah Lain-lain Jenis Taman', app_dashboard_taman(6), route('pengurusan.ePALM.index'), 'fas fa-leaf', ' #1abc9c ') !!}
    </div>
    <div class="row" id="epil">
        {!! stats_card('Jumlah Pelan Induk Landskap', app_dashboard_pelan(), route('pengurusan.ePIL.index'), 'fas fa-drafting-compass', ' #7d6608 ') !!}
    </div>
    <div class="row" id="ktp">
        {!! stats_card('Jumlah Pokok Ditanam Setakat ' . date('Y'), app_dashboard_pokok(), route('pengurusan.ktp.index'), 'fas fa-tree', ' #186a3b ') !!}
    </div>
    <div class="row" id="mib">
        {!! stats_card('Jumlah Rakan Taman', app_dashboard_mib(), 'javascript:void(0)', 'fas fa-users', ' #4a235a  ') !!}
        {!! stats_card('Status: Aktif', app_dashboard_mib('Aktif'), route('pengurusan.MIB.index'), 'fas fa-users', '  #5b2c6f  ') !!}
        {!! stats_card('Status: Tidak Aktif', app_dashboard_mib('Tidak Aktif'), route('pengurusan.MIB.index'), 'fas fa-users', '  #6c3483  ') !!}
        {!! stats_card('Status: Digugurkan', app_dashboard_mib('Digugurkan'), route('pengurusan.MIB.index'), 'fas fa-users', '  #7d3c98  ') !!}
    </div>
    <div class="row" id="elind">
        {!! stats_card('Jumlah Penggiat Industri Landskap', app_dashboard_industri(), 'javascript:void(0)', 'fas fa-seedling', '  #6e2c00   ') !!}
        {!! stats_card('Kontraktor', app_dashboard_industri('Kontraktor'), route('pengurusan.eLIND.index', ['type' => 'kontraktor']), 'fas fa-user-tie', '   #873600   ') !!}
        {!! stats_card('Perunding', app_dashboard_industri('Perunding'), route('pengurusan.eLIND.index', ['type' => 'perunding']), 'fas fa-briefcase', '   #a04000   ') !!}
        {!! stats_card('Pembekal', app_dashboard_industri('Pembekal'), route('pengurusan.eLIND.index', ['type' => 'pembekal']), 'fas fa-truck', '   #ba4a00   ') !!}
        {!! stats_card('Pertubuhan Antarabangsa', app_dashboard_industri('Pertubuhan Antarabangsa'), route('pengurusan.eLIND.index', ['type' => 'antarabangsa']), 'fas fa-globe', '   #d35400   ') !!}
        {!! stats_card('NGO / Badan Ikhtisas', app_dashboard_industri('NGO / Badan Ikhtisas'), route('pengurusan.eLIND.index', ['type' => 'ngo']), 'fas fa-hands-helping', '   #d35400   ') !!}
        {!! stats_card('Institusi Pendidikan', app_dashboard_industri('Institusi Pendidikan'), route('pengurusan.eLIND.index', ['type' => 'pendidikan']), 'fas fa-university', '   #e67e22   ') !!}
    </div>
    <div class="row" id="entiti">
        {!! stats_card('Jumlah Entiti Landskap Unik', app_dashboard_entiti(), route('pengurusan.entiti-landskap-unik.index'), 'fas fa-dna', '  #616a6b  ') !!}
    </div>
</div>
@if(Auth::user()->hasRole('Penggiat Industri'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-olive card-outline">
                    <div class="card-header border-0">
                        <h5 class="card-title p-1 m-1 font-weight-bold">Gambaran Paparan Portal</h5>
                        <div class="card-tools" id="tool">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                @php
                                    $user = Auth::user();
                                    $id_elind = $user->bahagian_jln;
                                    $userDetails = \App\Model\MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->first();
                                    $jenis = $userDetails->jenis_industri;
                                    switch ($jenis) {
                                        case 'Kontraktor':
                                            $data = 'kontraktor';
                                            break;

                                        case 'Perunding':
                                            $data = 'perunding';
                                            break;

                                        case 'Pembekal':
                                            $data = 'pembekal';
                                            break;
                                        case 'Pertubuhan Antarabangsa':
                                            $data = 'antarabangsa';
                                            break;

                                        case 'NGO & Badan Ikhtisas':
                                            $data = 'ngo';
                                            break;

                                        case 'Institusi Pendidikan':
                                            $data = 'pendidikan';
                                            break;
                                    }
                                @endphp
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.eLIND.edit', ['type' => strtolower($data), 'id' => $id_elind])."'"
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-hardscape form-hardscape text-sm mib">
                        @include('website.eLIND_form')
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ app_dashboard_pokok() }}</h3>
                        <p>Jumlah Pokok Ditanam Setakat {{ date('Y') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tree" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1bc3de; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_taman() }}</h3>
                        <p>Jumlah Taman Setakat {{ date('Y') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-leaf" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1fd1ff; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_pelan() }}</h3>
                        <p>Jumlah Pelan Induk Landskap</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1fc2ff; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_mib() }}</h3>
                        <p>Jumlah Rakan Taman</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-olive card-outline">
                    <div class="card-header border-0">
                        <h5 class="card-title p-1 m-1 font-weight-bold">Gambaran Paparan Portal ePALM</h5>
                        <div class="card-tools" id="tool">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.ePALM.index')."'"
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-hardscape form-hardscape text-sm mib" style="max-height: 400px; overflow-y: auto;">
                        @include('website.ePALM_form')
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-olive card-outline">
                    <div class="card-header border-0">
                        <h5 class="card-title p-1 m-1 font-weight-bold">Gambaran Paparan Portal ePIL</h5>
                        <div class="card-tools" id="tool">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.ePIL.index')."'"
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-hardscape form-hardscape text-sm mib" style="max-height: 400px; overflow-y: auto;">
                        @include('website.ePIL_form')
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="{{ route('pengurusan.ktp.index') }}" style="text-decoration: none; color: inherit;">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ app_dashboard_pokok() }}</h3>
                        <p>Jumlah Pokok Ditanam Setakat {{ date('Y') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tree" aria-hidden="true"></i>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1bc3de; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_taman() }}</h3>
                        <p>Jumlah Taman Setakat {{ date('Y') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-leaf" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1fd1ff; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_pelan() }}</h3>
                        <p>Jumlah Pelan Induk Landskap</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="small-box" style="background-color: #1fc2ff; color: white;">
                    <div class="inner">
                        <h3>{{ app_dashboard_mib() }}</h3>
                        <p>Jumlah Rakan Taman</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <style>
                    #myHistogram {
                        width: 100% !important; /* Make canvas full width of its container */
                        height: 400px; /* Adjust height as needed */
                    }
                </style>
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">Bilangan Pihak Berkuasa Tempatan</h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <canvas id="myHistogram"></canvas>
                        <script>
                            // Ensure the DOM is fully loaded before making the fetch request
                            document.addEventListener('DOMContentLoaded', () => {
                                // Fetch data from the server (via the DataController)
                                fetch('/get-pbt-statistics')
                                    .then(response => {
                                        // Check if the response is successful
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Fetched PBT Data:', data);

                                        // Data for the histogram
                                        const data1 = {
                                            labels: [
                                                'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan',
                                                'Pahang', 'Penang', 'Perak', 'Perlis', 'Selangor',
                                                'Sabah', 'Sarawak', 'Wilayah Persekutuan'
                                            ],
                                            datasets: [{
                                                label: 'Bilangan PBT',
                                                data: data, // The fetched PBT counts
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        };

                                        // Configuration for the histogram
                                        const config = {
                                            type: 'bar',
                                            data: data1,
                                            options: {
                                                scales: {
                                                    x: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Negeri - Negeri Malaysia'
                                                        },
                                                        ticks: {
                                                            autoSkip: false // Ensure all labels are shown
                                                        }
                                                    },
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Bilangan PBT'
                                                        },
                                                        suggestedMax: 10 // Increase y-axis scale
                                                    }
                                                }
                                            }
                                        };

                                        // Render the histogram after DOM is fully loaded
                                        const ctx = document.getElementById('myHistogram').getContext('2d');
                                        new Chart(ctx, config);
                                    })
                                    .catch(error => {
                                        console.error('There was a problem with the fetch operation:', error);
                                    });
                            });
                        </script>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>

            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">Bilangan Pelawat</h3>
                    </div><!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <style>
                            canvas {
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                        <canvas id="visitorChart" width="800" height="400"></canvas>
                        <script>
                            // Fetch visitor data from the backend (via the DataController)
                            fetch('/get-visitor-statistics')
                                .then(response => response.json())
                                .then(data => {
                                    // Prepare the labels and data for the chart
                                    const labels = [];
                                    const visitorCounts = [];

                                    // Format the data from the response
                                    data.forEach(item => {
                                        labels.push(item.month);  // Year-Month (YYYY-MM)
                                        visitorCounts.push(item.count);  // Visitor count
                                    });

                                    // Get the context for the chart
                                    const ctx = document.getElementById('visitorChart').getContext('2d');
                                    
                                    // Create the chart with real data
                                    new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Bilangan Pelawat',
                                                data: visitorCounts,
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                fill: true,
                                                tension: 0.1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Bulan'
                                                    },
                                                    ticks: {
                                                        autoSkip: true,
                                                        maxTicksLimit: 12
                                                    }
                                                },
                                                y: {
                                                    title: {
                                                        display: true,
                                                        text: 'Bilangan Pelawat'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                })
                                .catch(error => {
                                    console.error('There was an issue fetching visitor data:', error);
                                });
                        </script>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3">Statistik Pengguna Jabatan</h3>
                    </div><!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <style>
                            canvas {
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                        <canvas id="jlnChart" width="800" height="400"></canvas>
                        <script>
                            // Fetch jln data from the backend (via the DataController)
                            fetch('/get-jln-statistics')
                            .then(response => response.json())
                            .then(data => {
                                const labels = [];
                                const jlnCounts = [];

                                // Extract bahagian labels and counts from data.data
                                for (const [key, value] of Object.entries(data.data)) {
                                    labels.push(key);      // e.g., "bahagian_jln 1"
                                    jlnCounts.push(value); // e.g., 25
                                }

                                // Get chart context
                                const ctx = document.getElementById('jlnChart').getContext('2d');

                                // Create the chart
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: `Statistik Pengguna Jabatan (${data.month})`,
                                            data: jlnCounts,
                                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            x: {
                                                title: {
                                                    display: false,
                                                    text: 'Bahagian'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Statistik Pengguna Jabatan'
                                                }
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => {
                                console.error('There was an issue fetching jln data:', error);
                            });

                        </script>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .card-tools {
        display: none;
    }
    #tool {
        display: block;
    }
</style>

@endsection