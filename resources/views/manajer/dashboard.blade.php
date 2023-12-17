@extends('manajer.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
			<div class="d-md-flex">
				<div class="info-box mr-md-3">
					<span class="info-box-icon bg-success" ><i class="fa  fa-chevron-down"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total Pemasukan</span>
						<span class="info-box-number">
							<h2>Rp. {{ number_format($totalMasuk, 0, ',', '.') }}</h2>
						</span>
					</div>
				</div>
				<div class="info-box">
					<span class="info-box-icon bg-danger"><i class="fa  fa-chevron-up"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total Pengeluaran</span>
						<span class="info-box-number">
							<h2>Rp. {{ number_format($totalKeluar, 0, ',', '.') }}</h2>
						</span>
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

@endsection
