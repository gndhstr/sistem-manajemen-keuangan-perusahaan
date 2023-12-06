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
				<h1 class="m-0 text-dark">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Anggaran</li>
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
							<th class="text-center">Divisi</th>
							<th class="text-center">Kategori</th>
							<th class="text-center">Rencana</th>
							<th class="text-center">Aktualisasi</th>
							<th class="text-center">Tanggal</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($anggarans as $anggaran)
						<tr>
							<td class="text-center">{{ $loop->index + 1}}</td>
        					<td class="text-center">{{ $anggaran->divisi->nama_divisi }}</td>
							<td class="text-center">{{ $anggaran->kategori->nama_kategori }}</td>
							<td class="text-center">{{ $anggaran->rencana_anggaran}}</td>
							<td class="text-center">{{ $anggaran->aktualisasi_anggaran}}</td>
							<td class="text-center">{{ $anggaran->tgl_anggaran}}</td>
							<td class="text-center">
								<a data-url="{{route('editAnggaran',['id_anggaran'=>$anggaran->id_anggaran])}}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{$anggaran->id_anggaran}}" >Edit</a>
								<a onclick="confirmDelete(this)"  data-url="{{route('deleteAnggaran',['id_anggaran'=>$anggaran->id_anggaran])}}" class="btn btn-danger btn-sm ml-1 text-white" role="button">Hapus</a>
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
					<h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Anggaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Form Tambah Data Role -->
					<form action="{{route('storeAnggaran')}}" method="post">
						@csrf
							<div class="form-group">

								<label for="kategori">Kategori</label>
								<div class="input-group">
									@php
										$kategoris = App\tbl_kategori::get();
									@endphp

									<select id="kategori" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori') }}" required autocomplete="kategori">
										@foreach ($kategoris as $kategori)
											<option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
										@endforeach
										<option value="" hidden></option>
									</select>
									@error('kategori')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror

								</div>

								<label for="rencana_anggaran">Rencana Anggaran</label>
								<input type="text" name="rencana_anggaran" id="rencana_anggaran" class="form-control" required placeholder="Masukkan Rencana Anggaran">
								<label for="aktualisasi_anggaran">Aktualisasi Anggaran</label>
								<input type="text" name="aktualisasi_anggaran" id="aktualisasi_anggaran" class="form-control" required placeholder="Masukkan Aktualisasi Anggaran">
								<label for="tanggal">Tanggal</label>
								<input type="date" name="tanggal" id="tanggal" class="form-control" required placeholder="Masukkan Tanggal Anggaran">
							</div>
							<div class="text-right">
							<a href="{{route('anggaran')}}" class="btn btn-danger mr-1">Batal</a>
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
@foreach($anggarans as $anggaran)
    <div class="modal fade" id="editData{{ $anggaran->id_anggaran }}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Update Anggaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Edit Data Kategori -->
                    <form action="{{ route('updateAnggaran', $anggaran->id_anggaran) }}" method="post">
                        @csrf
                        @method('POST') 

                        <div class="form-group">

                            <label for="kategori">Kategori</label>
                            <div class="input-group">
                                @php
                                    $kategoris = App\tbl_kategori::get();
                                @endphp

                                <select id="kategori" class="form-control @error('kategori') is-invalid @enderror" name="kategori" required autocomplete="kategori">
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" {{ $anggaran->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                    <option value="" hidden></option>
                                </select>
                                @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="rencana_anggaran">Rencana Anggaran</label>
                            <input type="text" name="rencana_anggaran" id="rencana_anggaran" class="form-control" required placeholder="Masukkan Rencana Anggaran" value="{{ $anggaran->rencana_anggaran }}">

                            <label for="aktualisasi_anggaran">Aktualisasi Anggaran</label>
                            <input type="text" name="aktualisasi_anggaran" id="aktualisasi_anggaran" class="form-control" required placeholder="Masukkan Aktualisasi Anggaran" value="{{ $anggaran->aktualisasi_anggaran }}">

                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required placeholder="Masukkan Tanggal Anggaran" value="{{ $anggaran->tgl_anggaran }}">
                        </div>
                        <div class="text-right">
                            <a href="{{ route('anggaran') }}" class="btn btn-danger mr-1">Batal</a>
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
				swal({
					"title" 	 : "Konfirmasi Hapus",
					"text" 		 : "Apakah anda yakin menghapus data ini ?",
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