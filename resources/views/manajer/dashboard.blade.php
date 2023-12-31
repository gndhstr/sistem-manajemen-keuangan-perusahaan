@extends('manajer.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <!-- Add other CSS styles for your dashboard -->
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{$greeting}}, {{ Auth::user()->nama }}</h1>
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
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>

                        <div class="info-box-content">
                            <h5 class="info-box-text">Sisa Anggaran </h5>
                            <span class="info-box-number">Rp. {{ number_format($saldo, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fa fa-arrow-down"></i></span>

                        <div class="info-box-content">
                            <h5 class="info-box-text">Total Pemasukan ({{ $tahun }})</h5>
                            <span class="info-box-number">Rp. {{ number_format($totalPemasukan, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fa fa-arrow-up"></i></span>

                        <div class="info-box-content">
                            <h5 class="info-box-text">Total Pengeluaran ({{ $tahun }})</h5>
                            <span class="info-box-number">Rp. {{ number_format($totalPengeluaran, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>


            {{-- card grafik --}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title text-bold text-lg text-center">Grafik Keuangan Divisi {{ Auth::user()->division->nama_divisi }} ({{ $tahun }})</h3>
                </div>
                <div class="card-body">
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
                                            <span class="text-sm">Pemasukan Divisi Bulan Ini</span>
                                        </p>
                                        <p class="ml-auto d-flex flex-column text-right">
                                            <span
                                                class="{{ $perbandinganPemasukanPengeluaranBulanan > 0 ? 'text-success' : 'text-danger' }}">
                                                <i
                                                    class="fa {{ $perbandinganPemasukanPengeluaranBulanan > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                                {{ number_format($perbandinganPemasukanPengeluaranBulanan, 2) }}%
                                            </span>
                                            <span class="text-muted">Di Bulan ini</span>
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
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('addJavascript')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/Chart.js') }}"></script>
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

            // eslint-disable-next-line no-unused-vars

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
