@extends('layouts.master')

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
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="card light m-3 " style="width: 18rem;">
				<div class="card-header text-center">
				<i class="nav-icon fa fa-users"></i>
					<h5>Divisi</h5>
				</div>
				<div class="card-body" >
					<h5 class="card-text text-center">{{$dataDivisi}} Divisi</h5>
					<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
				</div>
			</div>
			<div class="card light m-3 " style="width: 18rem;">
				<div class="card-header text-center">
				<i class="nav-icon fa fa-briefcase"></i>
					<h5>Role</h5>
				</div>
				<div class="card-body" >
					<h5 class="card-text text-center">{{$dataRole}} Role</h5>
					<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
				</div>
			</div>
			<div class="card light m-3" style="width: 18rem;">
				<div class="card-header text-center">
				<i class="nav-icon fa fa-user"></i>
					<h5>User</h5>
				</div>
				<div class="card-body" >
					<h5 class="card-text text-center">{{$dataUser}} User</h5>
					<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
				</div>
			</div>
			<div class="card light m-3" style="width: 18rem;">
				<div class="card-header text-center">
				<i class="nav-icon fa fa-money"></i>
					<h5>Kategori</h5>
				</div>
				<div class="card-body" >
					<h5 class="card-text text-center">{{$dataKategori}} Kategori</h5>
					<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
				</div>
			</div>
		</div>	
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection