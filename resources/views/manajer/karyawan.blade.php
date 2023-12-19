@extends('manajer.layouts.master')
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
				<a href="{{route('createRole')}}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahData">Tambah Data</a>
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
								<a data-url="{{route('updateKaryawan',['id'=>$user->id])}}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{$user->id}}">Edit</a>
								<button onclick="confirmDelete(this)"  data-url="{{route('deleteKaryawan',['id'=>$user->id])}}"data-nama="{{ $user->nama}}" class="btn btn-danger btn-sm ml-1 text-white" role="button">Hapus</button>
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
					<h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Karyawan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Form Tambah Data Role -->
					<form action="{{route('storeKaryawan')}}" method="post">
							@csrf
								<div class="form-group">
									<label for="nama">Nama</label>
									<input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan Nama">
								</div>
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" name="username" id="username" class="form-control" required placeholder="Masukkan Username">
								</div>
								<div class="form-group">
									<label for="jenis_kelamin">Jenis Kelamin</label>
									<select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required="required">
										<option value="Laki-Laki">Laki-Laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
								</div>
								<div class="form-group">
									<label for="nomor_telepon">Nomor Telepon</label>
									<input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" required placeholder="Masukkan Nomor Telepon">
								</div>
								<div class="form-group">
									<label for="alamat">Alamat</label>
									<input type="text" name="alamat" id="alamat" class="form-control" required placeholder="Masukkan Alamat">
								</div>
								<div class="text-right">
									<a href="{{route('karyawan')}}" class="btn btn-danger mr-1">Batal</a>
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
	<!-- Modal Edit Data -->
    @foreach($users as $user)
		<div class="modal fade" id="editData{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editDataModalLabel">Edit Karyawan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form Edit Data Role -->
						<form action="{{ route('updateKaryawan', ['id' => $user->id]) }}" method="post">
							@csrf
							@method('POST') 
							<div class="form-group">
								<label for="nama">Nama</label>
								<input type="text" name="nama" id="nama" class="form-control" required placeholder="Masukkan Nama" value="{{ $user->nama }}">
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" class="form-control" required placeholder="Masukkan Username" value="{{ $user->username }}">
							</div>
							<div class="form-group">
								<label for="jenis_kelamin">Jenis Kelamin</label>
								<select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required="required">
									<option value="Laki-Laki" {{ $user->jenis_kelamin === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
									<option value="Perempuan" {{ $user->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
								</select>
							</div>
							<div class="form-group">
								<label for="nomor_telepon">Nomor Telepon</label>
								<input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" required placeholder="Masukkan Nomor Telepon" value="{{ $user->nomor_telepon }}">
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<input type="text" name="alamat" id="alamat" class="form-control" required placeholder="Masukkan Alamat" value="{{ $user->alamat }}">
							</div>
							<div class="text-right">
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
			confirmDelete = function(button) {
				var url = $(button).data("url");
				swal({
					"title": "Konfirmasi Hapus",
					"text": "Apakah anda yakin menghapus data ini?",
					"dangermode": true,
					"buttons": true,
				}).then(function(value) {
					if (value) {
						var form = document.createElement('form');
						form.action = url;
						form.method = 'POST';
						form.innerHTML = '<input type="hidden" name="_method" value="POST">' +
							'{{ csrf_field() }}';
						document.body.appendChild(form);
						form.submit();
					}
				});
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
