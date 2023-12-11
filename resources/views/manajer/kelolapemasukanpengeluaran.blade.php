@extends('layouts.master')
<!-- css -->
@section("addCss")
	<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/bootstrap4.min.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Karyawan</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Karyawan</li>
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
			<div class="card-header text-right">
				<a href="{{route('createRole')}}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahData">Daftarkan Karyawan</a>
			</div>
			<div class="card-body">
				<table class="table table-hover mb-0" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Divisi</th>
							<th class="text-center">Jenis Kelamin</th>
							<th class="text-center">Nomor</th>
							<th class="text-center">Alamat</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
						<tr>
							<td class="text-center">{{ $loop->index + 1}}</td>
							<td class="text-center">{{ $user->nama}}</td>
        					<td class="text-center">{{ $user->division ? $user->division->nama_divisi : "-" }}</td>
							<td class="text-center">{{ $user->jenis_kelamin}}</td>
							<td class="text-center">{{ $user->nomor_telepon}}</td>
							<td class="text-center">{{ $user->alamat}}</td>
							<td class="text-center">
								<a data-url="{{route('editUser',['id'=>$user->id])}}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{$user->id}}">Edit</a>
								<a onclick="confirmDelete(this)"  data-url="{{route('deleteUser',['id'=>$user->id])}}"data-nama="{{ $user->nama}}" class="btn btn-danger btn-sm ml-1 text-white" role="button">Hapus</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div><!-- /.container-fluid -->