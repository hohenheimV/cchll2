@extends('layouts.pengurusan.app')

@section('title', 'Dashboard')

@section('content')

@hasanyrole('Perunding')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="info-box bg-olive">
                <span class="info-box-icon"><i class="fa fa-tree" aria-hidden="true"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah Pokok Ditanam Setakat 2025</span>
                    <span class="info-box-number">{{ app_dashboard_pokok() }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
</div>
@else
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-8">
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
        <!-- /.col -->
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
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <style>
                #myHistogram2 {
                    width: 100% !important; /* Make canvas full width of its container */
                    height: 400px; /* Adjust height as needed */
                }
            </style>
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Bilangan PBT</h3>
                </div><!-- /.card-header -->
                <div class="card-body p-0">
                    <canvas id="myHistogram2"></canvas>
                    <script>
                        // Data for the histogram
                        const data1 = {
                            labels: [
                                'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan',
                                'Pahang', 'Penang', 'Perak', 'Perlis', 'Selangor',
                                'Sabah', 'Sarawak', 'Kuala Lumpur', 'Putrajaya', 'Labuan'
                            ],
                            datasets: [{
                                label: 'Bilangan PBT',
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
                                        suggestedMax: 20 // Increase y-axis scale
                                    }
                                }
                            }
                        };

                        // Render the histogram
                        window.onload = () => {
                            const ctx = document.getElementById('myHistogram2').getContext('2d');
                            new Chart(ctx, config);
                        };
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
                    <h3 class="card-title p-3">Bilangan Pelawat</h3>
                </div><!-- /.card-header -->
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
                    <style>
                        canvas {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                    <canvas id="visitorChart2" width="800" height="400"></canvas>
                    <script>
                        // Create dummy data
                        const labels = [];
                        const data = [];
                        const startDate = new Date('2024-01-01');
                        const endDate = new Date();
                        const currentDate = new Date(startDate);

                        while (currentDate <= endDate) {
                            const yearMonth = currentDate.toISOString().slice(0, 7); // YYYY-MM format
                            labels.push(yearMonth);
                            data.push(Math.floor(Math.random() * 30000)); // Random visitor count between 0 and 29999
                            currentDate.setMonth(currentDate.getMonth() + 1); // Increment by one month
                        }

                        const ctx = document.getElementById('visitorChart2').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Bilangan Pelawat',
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
                    </script>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endhasanyrole
@endsection
