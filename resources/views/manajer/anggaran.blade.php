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
				<h1 class="m-0 text-dark">Anggaran</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="{{route('dashboardManajer')}}">Dashboard</a></li>
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
				<a href="{{route('createRole')}}" class="btn btn-primary fa fa-plus" role="button" data-toggle="modal" data-target="#tambahData"></a>
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
							<td class="text-center">Rp. {{ number_format($anggaran->rencana_anggaran, 2, ',', '.') }}</td>
							<td class="text-center">Rp. {{ number_format($anggaran->aktualisasi_anggaran, 2, ',', '.') }}</td>
							<td class="text-center">{{ date('d/m/Y', strtotime($anggaran->tgl_anggaran))}}</td>
							<td class="text-center">
								<a data-url="{{route('editAnggaran',['id_anggaran'=>$anggaran->id_anggaran])}}" class="btn btn-warning btn-sm fa fa-pencil" role="button" data-toggle="modal" data-target="#editData{{$anggaran->id_anggaran}}" ></a>
								<button onclick="confirmDelete(this)"  data-url="{{route('deleteAnggaran',['id_anggaran'=>$anggaran->id_anggaran])}}" class="btn btn-danger btn-sm ml-1 text-white fa fa-trash" role="button"></button>
							</td>
						</tr>
						@endforeach

					</tbody>
				</table>
			</div>
		</div>
		<div class="card border-3">
                        <div class="card-header border-0 pb-0">
                            <div class="card-tools">
                                {{--  card Tools --}}
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="mb-5 text-center">
								<h3>Grafik Anggaran Tahunan ({{ $tahun }})</h3>
                            </div>
                            <!-- /.d-flex -->
                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="280"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fa fa-square text-primary"></i> Aktualisasi
                                </span>

                                <span>
                                    <i class="fa fa-square" style="color: #20c997"></i> Rencana
                                </span>
                            </div>
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
                                <input type="text" name="kategori" id="kategori" class="form-control" required value="Anggaran Divisi" readonly>
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
                            <input type="text" name="kategori" id="kategori" class="form-control" required value="Anggaran Divisi" readonly>

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
		<script src="{{ asset('js/Chart.js') }}"></script>
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
				$("#dataTable").DataTable({
                    scrollCollapse: true,
                    scrollY: '350px',
                });
			});
		</script>
		 <script>
        var successMessage = "{{ session('berhasil') }}";
        if (successMessage) {
            swal({
                // title: "Sukses",
                text: successMessage,
                icon: "success",
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'OK',
                timer: 5000,
                customClass: {
                    // title: 'swal-title',
                    content: 'swal-text',
                }
            });
        }
        $(function() {
            var tanggalBulanans = @json($tanggalBulanans);
            for (const key in tanggalBulanans) {
                if (tanggalBulanans.hasOwnProperty(key)) {
                    const element = tanggalBulanans[key];
                }
            }

            var rencanaBulanans = @json($rencanaBulanans);
            for (const key in rencanaBulanans) {
                if (rencanaBulanans.hasOwnProperty(key)) {
                    const element = rencanaBulanans[key];
                }
            }

            var aktualisasiBulanans = @json($aktualisasiBulanans);
            for (const key in aktualisasiBulanans) {
                if (aktualisasiBulanans.hasOwnProperty(key)) {
                    const element = aktualisasiBulanans[key];
                }
            }

            // Chart
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true

            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart($visitorsChart, {
                type: 'bar',
                data: {
                    labels: [tanggalBulanans[6], tanggalBulanans[5], tanggalBulanans[4], tanggalBulanans[3],
                        tanggalBulanans[2], tanggalBulanans[1], tanggalBulanans[0]
                    ],
                    datasets: [{
                            type: 'line',
                            data: [aktualisasiBulanans[6], aktualisasiBulanans[5], aktualisasiBulanans[
                                    4],
                                aktualisasiBulanans[3],
                                aktualisasiBulanans[2], aktualisasiBulanans[1], aktualisasiBulanans[
                                    0]
                            ],
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false
                            // pointHoverBackgroundColor: '#007bff',
                            // pointHoverBorderColor    : '#007bff'
                        },
                        {
                            type: 'bar',
                            data: [rencanaBulanans[6], rencanaBulanans[5], rencanaBulanans[
                                    4],
                                rencanaBulanans[3],
                                rencanaBulanans[2], rencanaBulanans[1], rencanaBulanans[
                                    0]
                            ],
                            backgroundColor: '#20c997',
                            borderColor: '#ced4da',
                            pointBorderColor: '#ced4da',
                            pointBackgroundColor: '#ced4da',
                            fill: false,
                            barPercentage: 0.5,
                            // pointHoverBackgroundColor: '#ced4da',
                            // pointHoverBorderColor    : '#ced4da'
                        }
                    ]
                },
                options: {
                    // responsive: true,
                    maintainAspectRatio: false, // Set this to true to maintain aspect ratio                                        
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: '#c7c7c7',
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value) {
                                    // if (value >= 1000) {
                                    //     value /= 1000
                                    //     value += 'k'
                                    // }
                                    value = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(value);

                                    return value;
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle,
                            // barPercentage: 0.5, // Deprecated
                            // categoryPercentage: 0.5 // Deprecated
                        }]
                    }
                }
            })
        });
    </script>
	@endsection
</div>
<!-- /.content -->
@endsection
