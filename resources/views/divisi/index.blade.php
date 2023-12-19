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
				<h1 class="m-0 text-dark">Data DIvisi</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Divisi</li>
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
				<a href="{{route('createDivisi')}}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahData">Tambah Data</a>
			</div>
			<div class="card-body">
				<table class="table table-hover mb-0" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama Divisi</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($divisis as $divisi)
						<tr>
							<td class="text-center">{{ $loop->index + 1}}</td>
							<td class="text-center">{{ $divisi->nama_divisi}}</td>
							<td class="text-center">
								<a data-url="{{route('editDivisi',['id_divisi'=>$divisi->id_divisi])}}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{$divisi->id_divisi}}" >Edit</a>
								<a onclick="confirmDelete(this)"  data-url="{{route('deleteDivisi',['id_divisi'=>$divisi->id_divisi])}}"data-nama="{{$divisi->nama_divisi}}" class="btn btn-danger btn-sm ml-1 text-white" role="button">Hapus</a>
							</td>
						</tr>
						@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</div><!-- /.container-fluid -->
	<!-- Modal Tambah Data -->
	<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Kategori</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Form Tambah Data Kategori -->
					<form action="{{route('storeDivisi')}}" method="post">
						@csrf
							<div class="form-group">
								<label for="nama">Nama Divisi</label>
								<input type="text" name="nama_divisi" id="nama_divisi" class="form-control" required placeholder="Masukkan Nama Divisi">
							</div>
							<div class="text-right">
							<a href="{{route('daftarDivisi')}}" class="btn btn-danger mr-1">Batal</a>
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
					</form>
					<!-- End Form -->
				</div>
			</div>
		</div>
	</div>
	<!-- End Modal Tambah Data -->

	<!-- Modal Edit Data -->
	@foreach($divisis as $divisi)
		<div class="modal fade" id="editData{{ $divisi->id_divisi }}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="tambahDataModalLabel">Edit Divisi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form Edit Data Kategori -->
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
						<!-- End Form -->
					</div>
				</div>
			</div>
		</div>
	@endforeach
	<!-- End Modal Tambah Data -->

		<!-- javascript -->
	@section("addJavascript")
		<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{asset('js/sweetalert.min.js')}}"></script>
		<script>
			confirmDelete = function(button){
				var url = $(button).data("url");
				var nama =$(button).data("nama");
				swal({
					"title" 	 : "Konfirmasi Hapus",
					"text" 		 : "Apakah anda yakin menghapus Divisi "+ nama + "?",
					"dangermode" : true,
					"buttons" 	 : true,
				}).then(function(value){
					if(value){
						window.location = url;
					}
				})
			}

			// fungsi data table
			$(function(){
				$("#dataTable").DataTable();
			});
		</script>
	@endsection
</div>
<!-- /.content -->
@endsection
