@extends('layouts.master')

@section('addCss')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Daftar User</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Daftar User</li>
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
            <div class="card-header text-left">
                <a href="" class="btn btn-primary" role="button">Tambah User</a>
            </div>
            <div class="card-body">
                    <table class="table table-hover table-bordered table-striped" id="data-table">
                            <thead>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>L/P</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Dibuat</th>
                                <th>Diubah</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td> {{ $loop->index +1 }} </td>
                                    <td> {{ $user->username }} </td>
                                    <td> {{ $user->nama }} </td>
                                    <td> {{ $user->role }} </td>
                                    <td> {{ $user->jenis_kelamin }} </td>
                                    <td> {{ $user->nomor_telepon }} </td>
                                    <td> {{ $user->alamat }} </td>
                                    <td> {{ $user->created_at }} </td>
                                    <td> {{ $user->updated_at }} </td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm" role="button">Edit</a>
                                        <a onclick="confirmDelete(this)" data-url="{{ route('deleteUser', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" role="button">Hapus</a>
                                    
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
            </div>
        </div>

	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('addJavascript')
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(function(){
        $("#data-table").dataTable({
            responsive: true
        });
    })
</script>

<script>
    confirmDelete = function(button) {
        var url = $(button).data('url');

        swal({
            'title' : 'Konfirmasi Hapus',
            'text' : 'Apakah kamu yakuin ingin menghapus data ini?',
            'dangermode' : true,
            'buttons' : true,
        }).then(function(value) {
            if(value) {
                window.location = url;
            }
        })
    }
</script>
@endsection