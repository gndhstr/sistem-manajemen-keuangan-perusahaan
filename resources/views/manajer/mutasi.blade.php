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
				<h1 class="m-0 text-dark">Mutasi Karyawan</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Mutasi Keuangan</li>
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
				<table class="table table-hover mb-0" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Saldo</th>
							<th class="text-center">Detail</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
                        @php
                            $JmlMasuk = $pemasukans->where('id_user', $user->id)->sum('jml_masuk');
                            $JmlKeluar = $pengeluarans->where('id_user', $user->id)->sum('jml_keluar');
                            $result = $JmlMasuk - $JmlKeluar;
                        @endphp
						<tr>
							<td class="text-center">{{ $loop->index + 1}}</td>
							<td class="text-center">{{ $user->nama}}</td>
        					<td class="text-center">Rp. {{ number_format($result, 0, ',', '.') }} </td>
							<td class="text-center">
								<a data-url="{{route('editUser',['id'=>$user->id])}}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{$user->id}}">Detail</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		@foreach($users as $user)
		<div class="modal fade" id="editData{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editDataModalLabel">Mutasi Keuangan {{ $user -> nama}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="card-body">
							<table class="table table-hover mb-0" id="tabelModal">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Tanggal</th>
										<th class="text-center">Pemasukan</th>
										<th class="text-center">Pengeluaran</th>
										<th class="text-center">Catatan</th>
										<th class="text-center">Bukti</th>
									</tr>
								</thead>
								<tbody>
								@php
									$mutasis = $pemasukans->concat($pengeluarans)->where('id_user', $user->id)->sortByDesc(function($mutasi) {
										return isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran;
									});
								@endphp
								@forelse ($mutasis as $mutasi)
									<tr>
										<td class="text-center">{{ $loop->index + 1 }}</td>
										<td class="text-center">{{ isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran }}</td>	
										<td class="text-center">
											<small class="text-success mr-1">
                                                <i class="fa fa-arrow-up"></i>
                                            </small>
											Rp. {{ number_format(isset($mutasi->jml_masuk) ? floatval($mutasi->jml_masuk) : 0, 0, ',', '.') }}
										</td>
										<td class="text-center">
											<small class="text-danger mr-1">
                                                <i class="fa fa-arrow-down"></i>
                                            </small>
											Rp. {{ number_format(isset($mutasi->jml_keluar) ? floatval($mutasi->jml_keluar) : 0, 0, ',', '.') }}
										</td>
										<td class="text-center">{{ $mutasi->catatan }}</td>				
										<td class="text-center">
											<a data-url="{{ route('editUser', ['id' => $user->id]) }}" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#editData{{ $user->id }}">Lihat</a>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="4" class="text-center">No data available</td>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	</div><!-- /.container-fluid -->


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
				$("#dataTable").DataTable({
					"columnDefs": [
						{ "width": "50px", "targets": 0 } // Ganti 50px sesuai dengan lebar yang Anda inginkan
					]
				});

				$("#tabelModal").DataTable({
				});
			});

		</script>
	@endsection
</div>
<!-- /.content -->
@endsection
