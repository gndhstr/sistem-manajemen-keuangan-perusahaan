@extends('direktur.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $greeting }}, {{ Auth::user()->nama }}</h1>
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
            {{-- card grafik --}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title text-bold text-lg text-center">Grafik Keuangan Karyawan</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ date('Y') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border-3">
                                <div class="card-header border-0 pb-0">
                                    <div class="d-flex justify-content-end">
                                        {{-- <a href="">View Report</a> --}}
                                    </div>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span class="text-bold text-lg">Rp.
                                                {{ number_format($pemasukanMingguan, 2, ',', '.') }}</span>
                                            <span class="text-muted text-sm">Pemasukan Karyawan di Minggu ini</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span
                                                class="{{ $perbandinganPemasukanPengeluaranMingguan > 0 ? 'text-success' : 'text-danger' }}">
                                                {{-- <i class="fa {{ $perbandinganPemasukanPengeluaranMingguan > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> --}}
                                                {{ number_format($perbandinganPemasukanPengeluaranMingguan, 2) }} %
                                            </span>
                                            <span class="text-muted text-sm">Dibanding Pengeluaran</span>
                                            {{-- <span class="text-muted">{{ $tanggalMingguan }}</span> --}}
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
                                        {{-- <a href="javascript:void(0);">View Report</a> --}}
                                    </div>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column">
                                            <span class="text-bold text-lg">Rp.
                                                {{ number_format($pemasukanBulanan, 2, ',', '.') }}</span>
                                            <span class="text-muted text-sm">Pemasukan Karyawan di Bulan ini</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span
                                                class="{{ $perbandinganPemasukanPengeluaranBulanan > 0 ? 'text-success' : 'text-danger' }}">
                                                {{-- <i
                                                    class="fa {{ $perbandinganPemasukanPengeluaranBulanan > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> --}}
                                                {{ number_format($perbandinganPemasukanPengeluaranBulanan, 2) }}%
                                            </span>
                                            <span class="text-muted text-sm">Dibanding Pengeluaran</span>
                                            {{-- <span class="text-muted">{{ $tanggalBulanan }}</span> --}}
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
            <div class="col-12 py-2">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage"><i class="fa fa-caret-down text-success mr-lg-1"></i></span>
                                <span class="description-percentage"><i class="fa fa-money text-success"></i></span>
                                <h5 class="description-header">Rp. {{ number_format($totalPemasukan, 2, ',', '.') }}</h5>
                                <span class="description-text">TOTAL PEMASUKAN KARYAWAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fa fa-caret-left"></i>
                                    {{ number_format(abs($perbandinganPemasukanPengeluaranTotal), 2) }}%</span>
                                <h5 class="description-header">Rp. {{ number_format($totalPengeluaran, 2, ',', '.') }}</h5>
                                <span class="description-text">TOTAL BIAYA KARYAWAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage"><i class="fa fa-briefcase text-success"></i></span>
                                <h5 class="description-header">Rp. {{ number_format($rencanaAnggaran, 2, ',', '.') }}</h5>
                                <span class="description-text">TOTAL ANGGARAN</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <span
                                    class="description-percentage {{ $perbandinganAnggaran > 100 ? 'text-danger' : 'text-success' }}">{{ number_format($perbandinganAnggaran, 2) }}
                                    %</span>
                                <h5 class="description-header">{{ $realisasiAnggaran }}</h5>
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

    {{-- <script>
        var pemasukanHarians = @json($pemasukanHarians);        
        pemasukanHarians.forEach((element) => {
            console.log(element);
        });
    </script> --}}

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
            });

            var pengeluaranHarians = @json($pengeluaranHarians);
            pengeluaranHarians.forEach((element, index) => {
                pengeluaranHarians.push(element);
            });

            var pemasukanBulanans = @json($pemasukanBulanans);
            for (const key in pemasukanBulanans) {
                if (pemasukanBulanans.hasOwnProperty(key)) {
                    const element = pemasukanBulanans[key];
                }
            }

            var pengeluaranBulanans = @json($pengeluaranBulanans);
            for (const key in pengeluaranBulanans) {
                if (pengeluaranBulanans.hasOwnProperty(key)) {
                    const element = pengeluaranBulanans[key];
                }
            }

            var tanggalHarians = @json($tanggalHarians);
            for (const key in tanggalHarians) {
                if (tanggalHarians.hasOwnProperty(key)) {
                    const element = tanggalHarians[key];
                }
            }

            var tanggalBulanans = @json($tanggalBulanans);
            for (const key in tanggalBulanans) {
                if (tanggalBulanans.hasOwnProperty(key)) {
                    const element = tanggalBulanans[key];
                }
            }

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
                            data: [pengeluaranHarians[0], pengeluaranHarians[1], pengeluaranHarians[2],
                                pengeluaranHarians[3], pengeluaranHarians[4], pengeluaranHarians[5],
                                pengeluaranHarians[6]
                            ],
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
                    labels: [tanggalBulanans[6], tanggalBulanans[5], tanggalBulanans[4], tanggalBulanans[3],
                        tanggalBulanans[2], tanggalBulanans[1], tanggalBulanans[0]
                    ],
                    datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: [pemasukanBulanans[6], pemasukanBulanans[5], pemasukanBulanans[4],
                                pemasukanBulanans[3], pemasukanBulanans[2], pemasukanBulanans[1],
                                pemasukanBulanans[0]
                            ]
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: [pengeluaranBulanans[6], pengeluaranBulanans[5], pengeluaranBulanans[
                                    4], pengeluaranBulanans[3], pengeluaranBulanans[2],
                                pengeluaranBulanans[1], pengeluaranBulanans[0]
                            ]
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
        })


        // lgtm [js/unused-local-variable]
    </script>
@endsection
