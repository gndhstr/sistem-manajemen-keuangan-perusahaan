@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Tambah User</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{route('daftarUser')}}">User</a></li>
					<li class="breadcrumb-item active">Edit</li>
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
				<form action="{{route('updateUser',['id'=>$user->id])}}" method="post">
				@csrf
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan Nama" value="{{$user->nama}}">
					</div>
					<div class="form-group">
						<label for="role">Jabatan</label>
						<select name="role" id="role" class="form-control" required="required">
							@foreach($roles as $role)
								<option value="{{ $role->id_role }}" {{$role->id_role == $user->role ? "selected": ""}}>{{ $role->role }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="divisi">Divisi</label>
						<select name="id_divisi" id="id_divisi" class="form-control" required="required">
							@foreach($divisis as $divisi)
							<option value="{{ $divisi->id_divisi }}" {{$divisi->id_divisi == $user->id_divisi ? "selected": ""}}>{{ $divisi->nama_divisi }}</option>
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