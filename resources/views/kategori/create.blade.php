@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Tambah Kategori</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{route('daftarKategori')}}">Kategori</a></li>
					<li class="breadcrumb-item active">Tambah Kategori</li>
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
				<form action="{{route('storeKategori')}}" method="post">
				@csrf
				<div class="form-group">
					<label for="nama">Nama Kategori</label>
					<input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required placeholder="Masukkan Nama Kategori">
				</div>
				<div class="form-group">
					<label for="nama">Jenis</label>
					<select name="jenis_kategori" id="jenis_kategori" class="form-control" required="required">
					@foreach(['Pengeluaran', 'Pemasukkan'] as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
					</select>
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