@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Edit Divisi</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{route('daftarDivisi')}}">Daftar Divisi</a></li>
					<li class="breadcrumb-item active">Edit Divisi</li>
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
			<form action="{{ route('updateDivisi', ['divisi' => $divisi->id_divisi]) }}" method="post">
				@csrf
				<div class="form-group">
					<label for="nama">Nama Divisi</label>
					<input type="text" name="nama_divisi" id="nama_divisi" class="form-control" required="required" placeholder="Masukkan Nama Divisi" value="{{$divisi->nama_divisi}}">
				</div>
				<div class="text-right">
					<a href="{{route('daftarDivisi')}}" class="btn btn-danger">Batal</a>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection