@extends('karyawan.layouts.master')

@section('addJavascript')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Selamat Datang, {{ Auth::user()->nama }}</h1>
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
        <div class="card p-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Saldo</span>
                            <span class="info-box-number">
                                <h2>{{ $saldo }},-</h2>
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa  fa-chevron-down"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pemasukan</span>
                            <span class="info-box-number">
                                <h2>{{ $totalMasuk }},-</h2>
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa  fa-chevron-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pengeluaran</span>
                            <span class="info-box-number">
                                <h2>{{ $totalKeluar }},-</h2>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center "><i class="fa fa-chart-bar"></i>Grafik Keuangan</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" style="height: 225px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.content -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Set your data for the chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                label: 'Total',
                data: [{{ $totalMasuk }},{{ $totalKeluar }}],
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
            maintainAspectRatio: true, // Setel ke false untuk mengaktifkan penyesuaian aspek rasio
            aspectRatio: 4.9 // Sesuaikan dengan angka yang sesuai dengan kebutuhan tinggi grafik
        }
    });
</script>
@endsection


