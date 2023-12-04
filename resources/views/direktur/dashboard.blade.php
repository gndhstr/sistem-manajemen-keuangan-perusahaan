@extends('direktur.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard Direktur</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">                
        <div class="container-fluid"> <!-- content from here -->
            {{-- card grafik --}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title text-bold text-lg">Grafik Keuangan Perusahaan</h3>
                    <div class="card-tools">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                        <span class="badge badge-primary">Label</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border-3">
                                <div class="card-header border-0 pb-0">
                                    <div class="d-flex justify-content-end">
                                        <a href="javascript:void(0);">View Report</a>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span class="text-bold text-lg">Rp.
                                                {{ number_format($pemasukanMingguan, 2, ',', '.') }}</span>
                                            <span>Pemasukan Seiring Waktu</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span class="{{ ($persentasePerbandingan > 0) ? 'text-success' : 'text-danger' }}">
                                                <i class="fa {{ ($persentasePerbandingan > 0) ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                                {{ number_format($persentasePerbandingan, 2) }} %
                                            </span>
                                            <span class="text-muted">Sejak minggu terakhir</span>
                                            <span class="text-muted">{{ $tanggalMingguan }}</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->



                                    <div class="position-relative mb-4">
                                        <canvas id="visitors-chart" height="200"></canvas>
                                    </div>

                                    <div class="d-flex flex-row justify-content-end">
                                        <span class="mr-2">
                                            <i class="fa fa-square text-primary"></i> Pemasukan
                                        </span>

                                        <span>                                        
                                            <i class="fa fa-square text-gray" style="opacity: 23%"></i> Pengeluaran
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div class="d-flex justify-content-end">
                                        <a href="javascript:void(0);">View Report</a>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span class="text-bold text-lg">Rp.
                                                {{ number_format($pemasukanBulanan, 2, ',', '.') }}</span>
                                            <span>Pemasukan Seiring Waktu</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span class="text-success">
                                                <i class="fa fa-arrow-up"></i> 33.1%
                                            </span>
                                            <span class="text-muted">Sejak 1 bulan terakhir</span>
                                            <span class="text-muted">{{ $tanggalBulanan }}</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->

                                    <div class="position-relative mb-4">
                                        <canvas id="sales-chart" height="200"></canvas>
                                    </div>

                                    <div class="d-flex flex-row justify-content-end">
                                        <span class="mr-2">
                                            <i class="fa fa-square text-primary"></i> Pemasukan
                                        </span>

                                        <span>
                                            <i class="fa fa-square text-gray" style="opacity: 23%"></i> Pengeluaran
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>


            {{-- card ringkasan --}}
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fa fa-caret-up"></i>
                                    17%</span>
                                <h5 class="description-header">Rp. {{ $totalPemasukan }}</h5>
                                <span class="description-text">TOTAL PENDAPATAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fa fa-caret-left"></i>
                                    0%</span>
                                <h5 class="description-header">$10,390.90</h5>
                                <span class="description-text">TOTAL BIAYA</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success"><i class="fa fa-caret-up"></i>
                                    20%</span>
                                <h5 class="description-header">$24,813.53</h5>
                                <span class="description-text">TOTAL KEUNTUNGAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <span class="description-percentage text-danger"><i class="fa fa-caret-down"></i>
                                    18%</span>
                                <h5 class="description-header">1200</h5>
                                <span class="description-text">REALISASI ANGGARAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('addJavascript')
    <!-- dashboard3 AdminLTE -->
    <script src="{{ asset('js/Chart.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboard3.js') }}"></script> --}}

    <script>
        // var pemasukanHarians = @json($pemasukanHarians);
        // console.log(pemasukanHarians);
        // pemasukanHarians.forEach((element) => {
        //     console.log(element);
        // });
    </script>

    <script>
        /* global Chart:false */

        $(function() {
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var pemasukanHarians = @json($pemasukanHarians);
            pemasukanHarians.forEach((element, index) => {
                pemasukanHarians.push(element);
                console.log(element);
            });

            var tanggalHarians = @json($tanggalHarians);
            tanggalHarians.forEach((element, index) => {
                tanggalHarians.push(element);
            });

            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
                data: {
                    labels: [tanggalHarians[0], tanggalHarians[1], tanggalHarians[2], tanggalHarians[3],
                        tanggalHarians[4], tanggalHarians[5], tanggalHarians[6]
                    ],
                    datasets: [{
                            type: 'line',
                            data: [pemasukanHarians[0], pemasukanHarians[1], pemasukanHarians[2],
                                pemasukanHarians[3], pemasukanHarians[4], pemasukanHarians[5],
                                pemasukanHarians[6]
                            ],
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false
                            // pointHoverBackgroundColor: '#007bff',
                            // pointHoverBorderColor    : '#007bff'
                        },
                        {
                            type: 'line',
                            data: [60, 80, 70, 67, 80, 77, 100],
                            backgroundColor: 'tansparent',
                            borderColor: '#ced4da',
                            pointBorderColor: '#ced4da',
                            pointBackgroundColor: '#ced4da',
                            fill: false
                            // pointHoverBackgroundColor: '#ced4da',
                            // pointHoverBorderColor    : '#ced4da'
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: 200,
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += 'k';
                                        // value = value.toLocaleString("id-ID");
                                    }

                                    return 'Rp. ' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })

            var $salesChart = $('#sales-chart')
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart($salesChart, {
                type: 'bar',
                data: {
                    labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                    datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }

                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        })


        // lgtm [js/unused-local-variable]
    </script>
@endsection