<!--HEADER- SIDEBAR - NAVIGATION -->
@include('admin.header')

@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

    $scheduleData = DB::table('schedule_logs')
        ->selectRaw('DATE_FORMAT(start_time, "%M") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderByRaw("STR_TO_DATE(month, '%M') ASC") // Ensures correct order of months
        ->get();

    $months = $scheduleData->pluck('month')->toArray(); // Get month names
    $counts = $scheduleData->pluck('count')->toArray(); // Get counts
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DASHBOARD-->
<div class="page-content">

    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
        </div>
    </div>

    <!--CARDS-->
    <section class="no-padding-top no-padding-bottom">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6">

                    <div class="statistic-block block" style="margin-top: 20px">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="fa fa-users" style="font-size: 25px;"></i></div>
                                <strong>Registered Account</strong>
                            </div>
                            <div class="number dashtext-1">{{ $userCount }}</div>
                        </div>
                        {{-- <div class="progress progress-template">
                            <div role="progressbar" style="width: {{ $userCount }}%"
                                aria-valuenow="{{ $userCount }}" aria-valuemin="0" aria-valuemax="200"
                                class="progress-bar progress-bar-template dashbg-1"></div>
                        </div> --}}
                    </div>

                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block" style="margin-top: 20px">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="fa fa-book" style="font-size: 25px;"></i></div>
                                <strong>Total Subjects</strong>
                            </div>
                            <div class="number dashtext-2">{{ $subjectCount }}</div>
                        </div>
                        {{-- <div class="progress progress-template">
                            <div role="progressbar" style="width: {{ $subjectCount }}%"
                                aria-valuenow="{{ $subjectCount }}" aria-valuemin="0" aria-valuemax="200"
                                class="progress-bar progress-bar-template dashbg-2"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block" style="margin-top: 20px">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon">
                                    <i class="fa fa-lightbulb-o" style="font-size: 25px;"></i>
                                </div>
                                <strong>Total Devices</strong>
                            </div>
                            <div class="number dashtext-3">{{ $deviceCount }}</div>
                        </div>
                        {{-- <div class="progress progress-template">
                            <div role="progressbar" style="width: {{ $deviceCount }}%"
                                aria-valuenow="{{ $deviceCount }}" aria-valuemin="0" aria-valuemax="200"
                                class="progress-bar progress-bar-template dashbg-3"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block" style="margin-top: 20px">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon">
                                    <i class='fas fa-building' style="font-size: 25px;"></i>
                                </div>
                                <strong>Total Classrooms</strong>
                            </div>
                            <div class="number dashtext-4">{{ $classroomCount }}</div>
                        </div>
                        {{-- <div class="progress progress-template">
                            <div role="progressbar" style="width: {{ $classroomCount }}%"
                                aria-valuenow="{{ $classroomCount }}" aria-valuemin="0" aria-valuemax="200"
                                class="progress-bar progress-bar-template dashbg-4"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!--GRAPH 1: Bar Chart for Users, Subjects, Devices, and Classrooms-->
    <section class="no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bar-chart block no-margin-bottom">
                        <canvas id="barChartExample1" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="line-chart block">
                        <canvas id="lineChartExample"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--GRAPH 2: Display individual progress bars-->
    <section class="no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    {{-- <!-- Stats for Users, Subjects, Devices, Classrooms -->
                    <div class="stats-2-block block d-flex">
                        <div class="stats-2">
                            <strong class="d-block">{{ $userCount }}</strong><span class="d-block">Users</span>
                            <div class="progress progress-template progress-small">
                                <div role="progressbar" style="width: {{ $userCount / 10 }}%"
                                    aria-valuenow="{{ $userCount }}" aria-valuemin="0" aria-valuemax="100"
                                    class="progress-bar progress-bar-template progress-bar-small dashbg-1">
                                </div>
                            </div>
                        </div> --}}
                    {{-- <div class="stats-2">
                            <strong class="d-block">{{ $subjectCount }}</strong><span class="d-block">Subjects</span>
                            <div class="progress progress-template progress-small">
                                <div role="progressbar" style="width: {{ $subjectCount / 10 }}%"
                                    aria-valuenow="{{ $subjectCount }}" aria-valuemin="0" aria-valuemax="100"
                                    class="progress-bar progress-bar-template progress-bar-small dashbg-2"></div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="stats-2-block block d-flex">
                        <div class="stats-2">
                            <strong class="d-block">{{ $deviceCount }}</strong><span class="d-block">Devices</span>
                            <div class="progress progress-template progress-small">
                                <div role="progressbar" style="width: {{ $deviceCount / 10 }}%"
                                    aria-valuenow="{{ $deviceCount }}" aria-valuemin="0" aria-valuemax="100"
                                    class="progress-bar progress-bar-template progress-bar-small dashbg-3"></div>
                            </div>
                        </div>
                        <div class="stats-2">
                            <strong class="d-block">{{ $classroomCount }}</strong><span
                                class="d-block">Classrooms</span>
                            <div class="progress progress-template progress-small">
                                <div role="progressbar" style="width: {{ $classroomCount / 10 }}%"
                                    aria-valuenow="{{ $classroomCount }}" aria-valuemin="0" aria-valuemax="100"
                                    class="progress-bar progress-bar-template progress-bar-small dashbg-4"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="drills-chart block">
                        <!-- Display Admin Account Information Here -->
                        <div class="stats-2-block block d-flex">
                            <div class="stats-2">
                                <strong class="d-block">{{ $userCount }}</strong>
                                <span class="d-block">Admin Accounts</span>
                                <div class="progress progress-template progress-small">
                                    <div role="progressbar" style="width: {{ $userCount / 10 }}%"
                                        aria-valuenow="{{ $userCount }}" aria-valuemin="0" aria-valuemax="100"
                                        class="progress-bar progress-bar-template progress-bar-small dashbg-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div> --}}
    </section>



    <script>
        var ctx1 = document.getElementById('barChartExample1').getContext('2d');
        var barChartExample1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($classroomCountPerFloor)) !!}, // Dynamic floor names
                datasets: [{
                    label: 'Classroom Count per Floor',
                    data: {!! json_encode(array_values($classroomCountPerFloor)) !!}, // Dynamic classroom counts
                    backgroundColor: 'rgba(53, 95, 46, 0.3)', // Background color for bars
                    borderColor: 'rgba(53, 95, 46, 1)', // Border color for bars
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ensures the chart is responsive
                maintainAspectRatio: true, // Allows the chart to scale freely
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });




        // Line Chart (you can adjust this to show other relevant data)
        document.addEventListener("DOMContentLoaded", function() {
            var ctx2 = document.getElementById('lineChartExample').getContext('2d');

            var lineChartExample = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: {!! json_encode($months) !!}, // Display only months
                    datasets: [{
                        label: 'Classroom Usage per Month',
                        data: {!! json_encode($counts) !!}, // Fetch counts dynamically
                        borderColor: 'rgb(24, 85, 25, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>


    <style>
        .chart-container {
            width: 100%;
            height: auto;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>



    <!--FOOtER -->
    @include('admin.footer')
