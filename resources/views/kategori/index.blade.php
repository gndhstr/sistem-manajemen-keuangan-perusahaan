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
				<h1 class="m-0 text-dark">Daftar Kategori</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Kategori</li>
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
				<a href="{{route('createKategori')}}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahDataModal">Tambah Data</a>
			</div>
			<div class="card-body">
				<table class="table table-hover mb-0" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama Kategori</th>
							<th class="text-center">Jenis</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($kategoris as $kategori)
						<tr>
							<td class="text-center">{{ $loop->index + 1}}</td>
							<td class="text-center">{{ $kategori->nama_kategori}}</td>
							<td class="text-center">{{ $kategori->jenis_kategori}}</td>
							<td class="text-center">
								<a data-url="{{route('editKategori',['id_kategori'=>$kategori->id_kategori])}}" class="btn btn-warning btn-sm " role="button" data-toggle="modal" data-target="#editData{{$kategori->id_kategori}}">Edit</a>
								<a onclick="confirmDelete(this)"  data-url="{{route('deleteKategori',['id_kategori'=>$kategori->id_kategori])}}" data-nama="{{$kategori->nama_kategori}}" class="btn btn-danger btn-sm ml-1 text-white" role="button">Hapus</a>
							</td>
						</tr>
						@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</div><!-- /.container-fluid -->

	<!-- Modal Tambah Data -->
	<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
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
						<a href="{{route('daftarKategori')}}" class="btn btn-danger mr-1">Batal</a>
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
	@foreach($kategoris as $kategori)
		<div class="modal fade" id="editData{{$kategori->id_kategori}}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editDataModalLabel">Edit Data Kategori</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form Edit Data Kategori -->
						<form action="{{route('updateKategori',['id_kategori'=>$kategori->id_kategori])}}" method="post">
							@csrf
							<div class="form-group">
								<label for="nama">Nama Kategori</label>
								<input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required placeholder="Masukkan Nama Kategori" value="{{$kategori->nama_kategori}}">
							</div>
							<div class="form-group">
								<label for="jenis_kategori">Jenis</label>
								<select name="jenis_kategori" id="jenis_kategori" class="form-control" required="required">
									@foreach(['Pengeluaran', 'Pemasukkan'] as $option)
										<option value="{{ $option }}" {{ $kategori->jenis_kategori == $option ? 'selected' : '' }}>
											{{ $option }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="text-right">
								<a href="{{route('daftarKategori')}}" class="btn btn-danger mr-1">Batal</a>
								<button type="submit" class="btn btn-success">Simpan</button>
							</div>
						</form>
						<!-- End Form -->
					</div>
				</div>
			</div>
		</div>
	@endforeach
	<!-- End Modal Edit Data -->


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
				"dangerMode" : true,
				"buttons" 	 : true,
			}).then(function(value){
				if(value){
					window.location = url;
				}
			})
		}

		$(function(){
			$("#dataTable").DataTable();
		});
		</script>
	@endsection
</div>
<!-- /.content -->
@endsection