@php
function formatRupiah($angka){
$rupiah = "Rp. " . number_format($angka,0,',','.');
return $rupiah;
}
@endphp
@extends('karyawan.layouts.master')

@section('addJavascript')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$greeting}}, {{ Auth::user()->nama }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="col">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Saldo</h3>
                            <p>{{ formatRupiah($saldo) }},-</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-wallet"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Total Pemasukan</h3>
                            <p>{{ formatRupiah($totalMasuk) }},-</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <a href="{{route('daftarPemasukan')}}" class="small-box-footer">
                            Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Total Pengeluaran</h3>
                            <p>{{ formatRupiah($totalKeluar) }},-</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <a href="{{route('daftarPengeluaran')}}" class="small-box-footer">
                            Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {{-- card grafik --}}
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title text-bold text-lg text-center">Grafik Keuangan Karyawan</h3>
                        <div class="card-tools">
                            <span class="badge badge-info">tanggal</span>
                        </div>
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
                                        <span class="text-bold text-lg">Pemasukan Karyawan Seiring Waktu</span>
                                        <span class="text-sm">Pemasukan Karyawan Seiring Waktu</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span class="">
                                            <i class=""></i>
                                            Perbandingan %
                                        </span>
                                        <span class="text-muted">Di Bulan ini</span>
                                        <span class="text-muted">Diisi dengan mingguan</span>
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
                                        <i class="fa fa-square text-gray" style="opacity: 0.23;"></i> Pengeluaran
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.content -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                label: 'Total',
                data: [{
                    {
                        $totalMasuk
                    }
                }, {
                    {
                        $totalKeluar
                    }
                }],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            maintainAspectRatio: true,
            aspectRatio: 1.5
        }
    });
</script>
<script>
    $(function() {
        // Format Rupiah
        $('.rupiah').mask('000.000.000.000', {
            reverse: true
        });
    });
</script>
@endsection