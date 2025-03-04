@extends('layouts.pengurusan.app')

@section('title', 'Dashboard')

@section('content')

@hasanyrole('Perunding')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-5 col-12">
            <div class="row">
                
                <!-- /.col -->
                <div class="col-md-6 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-olive">LK</span>
                        <div class="info-box-content">
                            <span class="info-box-text">Landskap Kejur</span>
                            <span class="info-box-number">{{ app_dashboard_total_hardscape() }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal">LL</span>
                        <div class="info-box-content">
                            <span class="info-box-text">Landskap Lembut</span>
                            <span class="info-box-number">{{ app_dashboard_total_softscape() }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                
            </div>
        </div>
       
    </div>

</div>


@else
<div class="container-fluid">

    <div class="row">
        <div class="col-md-5 col-12">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            #myHistogram {
                width: 100% !important; /* Make canvas full width of its container */
                height: 400px; /* Adjust height as needed */
            }
        </style>
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Bilangan PBT</h3>
                </div><!-- /.card-header -->
                <div class="card-body p-0">
                    <canvas id="myHistogram"></canvas>
                    <script>
                        // Data for the histogram
                        const data1 = {
                            labels: [
                                'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan',
                                'Pahang', 'Penang', 'Perak', 'Perlis', 'Selangor',
                                'Sabah', 'Sarawak', 'Kuala Lumpur', 'Putrajaya', 'Labuan'
                            ],
                            datasets: [{
                                label: 'Number of PBTs',
                                data: [5, 7, 3, 6, 8, 2, 9, 4, 1, 10, 15, 12, 18, 14, 11], // Number of people in each state
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
                                            text: 'States and Federal Territories in Malaysia'
                                        },
                                        ticks: {
                                            autoSkip: false // Ensure all labels are shown
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of PBTs'
                                        },
                                        suggestedMax: 20 // Increase y-axis scale
                                    }
                                }
                            }
                        };

                        // Render the histogram
                        window.onload = () => {
                            const ctx = document.getElementById('myHistogram').getContext('2d');
                            new Chart(ctx, config);
                        };
                    </script>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div>
        <div class="col-md-7 col-12">
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
                    // Create dummy data
                    const labels = [];
                    const data = [];
                    const startDate = new Date('2024-01-01');
                    const endDate = new Date();
                    const currentDate = new Date(startDate);

                    while (currentDate <= endDate) {
                        labels.push(currentDate.toISOString().slice(0, 10)); // YYYY-MM-DD format
                        data.push(Math.floor(Math.random() * 1000)); // Random visitor count between 0 and 999
                        currentDate.setDate(currentDate.getDate() + 1); // Increment by one day
                    }

                    const ctx = document.getElementById('visitorChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Website Visitors',
                                data: data,
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
                                        text: 'Date'
                                    },
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 20
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Number of Visitors'
                                    }
                                }
                            }
                        }
                    });
                </script>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Artikel/Pages</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li><a class="nav-link rounded-0 btn-sm active" href="#tabLatests" data-toggle="tab">Artikel Terbaharu</a></li>
                        <li><a class="nav-link rounded-0 btn-sm" href="#tabArticlesX" data-toggle="tab">Artikel Popular</a></li>
                        <li><a class="nav-link rounded-0 btn-sm" href="#tabPagesX" data-toggle="tab">Pages Popular</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabLatests">
                            <div class="table-responsive">
                                <table id="example" class="responsive table table-hover table-sm m-0">
                                    <thead>
                                        <tr>
                                            <th>Tajuk</th>
                                            <th>Penulis</th>
                                            <th class="text-center w-8">Hits</th>
                                            <th class="text-center w-8">Tarikh Diterbitkan</th>
                                            <th class="w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($index = 1)
                                        @forelse ($latestArticles as $article)
                                        <tr>
                                            <td>Perutusan Ketua Pengarah  {!! $article->is_status != 'publish' ? '<span class="badge badge-warning">'.$article->is_status.'</span>':'' !!}</td>
                                            <td>{{ $article->users->name }}</td>
                                            <td class="text-center"><span class="badge badge-info">{{ $article->visited() }}</span></td>
                                            <td class="text-center">{!! Html::datetime($article->published_at,'d-m-Y') !!}</td>
                                            <td>
                                                {!! Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.article.edit',$article)."'",
                                                'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini article') ]) !!}
                                            </td>
                                        </tr>
                                        @empty
                                        <div class="aler alert-info">Tiada Artikel Dijumpai</div>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabArticles">
                            <div class="table-responsive">
                                <table id="example" class="responsive table table-hover table-sm m-0">
                                    <thead>
                                        <tr>
                                            <th>Tajuk</th>
                                            <th>Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($popularArticles as $article)
                                        <tr>
                                            <td>{{ Str::limit($article->title, 55) }}</td>
                                            <td class="text-center"><span class="badge badge-info">{{ $article->visited() }}</span></td>
                                        </tr>
                                        @empty
                                        <div class="aler alert-info">Tiada Artikel Dijumpai</div>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Papar Semua Artikel</a>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tabPages">
                            <div class="table-responsive">
                                <table id="example" class="responsive table table-hover table-sm m-0">
                                    <thead>
                                        <tr>
                                            <th>Tajuk</th>
                                            <th>Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($popularPages as $page)
                                        <tr>
                                            <td>{{ Str::limit($page->title, 55) }}</td>
                                            <td class="text-center"><span class="badge badge-info">{{ $page->visited() }}</span></td>
                                        </tr>
                                        @empty
                                        <div class="aler alert-info">Tiada Pages Dijumpai</div>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Papar Semua Pages</a>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

@endhasanyrole
@endsection
