@extends('direktur.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Anggaran Perusahaan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Anggaran</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- main content here --}}
                <div class="card col-lg-6" style="height: 300px">
                    <div class="card-header border-0">
                        <h3 class="card-title">Anggaran</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover mb-0" id="data-table-divisi">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-1">No</th>
                                    <th>Divisi</th>
                                    <th>Kategori</th>
                                    <th>Rencana</th>
                                    <th>Aktualisasi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggarans as $anggaran)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td class="text-center">{{ $anggaran->divisi->nama_divisi }}</td>
                                        <td class="text-center">{{ $anggaran->kategori->nama_kategori }}</td>
                                        <td class="text-right">Rp.
                                            {{ number_format($anggaran->rencana_anggaran, 2, ',', '.') }}</td>
                                        <td class="text-right">Rp.
                                            {{ number_format($anggaran->aktualisasi_anggaran, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $anggaran->tgl_anggaran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-3">
                        <div class="card-header border-0 pb-0">
                            <div class="d-flex justify-content-end">
                                <a href="javascript:void(0);">View Report</a>
                            </div>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Rp.
                                    </span>
                                    <span class="text-sm">Pemasukan Seiring Waktu</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="">
                                        <i class="fa fa-arrow-up"></i>
                                        {{ number_format(2000, 2) }} %
                                    </span>
                                    <span class="text-muted">Di Bulan ini</span>
                                    <span class="text-muted">{{ date('D') }}</span>
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
        $(function() {
            $("#data-table-divisi").DataTable({
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4, 5],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });
        });
    </script>
    <script>
        $(function() {
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true

            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
                data: {
                    labels: [20, 20, 20, 20,
                        20, 20, 20
                    ],
                    datasets: [{
                            type: 'line',
                            data: [30, 30, 30,
                                30, 30, 30,
                                30
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
                            data: [30, 30, 30,
                                30, 30, 30,
                                30
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
            });
        });
    </script>
@endsection
