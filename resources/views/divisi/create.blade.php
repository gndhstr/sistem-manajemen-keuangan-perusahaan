@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Tambah Divisi</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{route('daftarDivisi')}}">Divisi</a></li>
					<li class="breadcrumb-item active">Tambah Divisi</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">
				<form action="{{route('storeDivisi')}}" method="post">
				@csrf
				<div class="form-group">
					<label for="nama">Nama Divisi</label>
					<input type="text" name="nama_divisi" id="nama_divisi" class="form-control" required placeholder="Masukkan Nama Divisi">
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection