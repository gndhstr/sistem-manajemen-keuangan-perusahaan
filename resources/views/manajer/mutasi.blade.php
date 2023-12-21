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
                <h1 class="m-0 text-dark">Mutasi Keuangan</h1>
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
                                    <a data-url="{{route('editUser',['id'=>$user->id])}}" class="btn btn-warning btn-sm fa fa-search" role="button" data-toggle="modal" data-target="#editData{{$user->id}}"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($users as $user)
            @php
                $JmlMasuk = $pemasukans->where('id_user', $user->id)->sum('jml_masuk');
                $JmlKeluar = $pengeluarans->where('id_user', $user->id)->sum('jml_keluar');
                $result = $JmlMasuk - $JmlKeluar;
            @endphp
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
                            <div class="card-header">
                                <div class="btn btn-outline-primary" role="button" data-toggle="modal" data-target="#tambahData">Saldo : Rp. {{ number_format($result, 0, ',', '.') }}</div>
                                <a href="{{route('createRole')}}" class="btn btn-primary" role="button" data-dismiss="modal" data-toggle="modal" data-target="#tambahPemasukanModalLabel" data-userid="{{ $user->id }}">Tambah Saldo</a>
                            </div>
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
                                            <!-- <th class="text-center">Aksi</th> -->
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
                                                    <button class="btn btn-primary btn-sm view-button" data-url="{{ route('viewBukti', ['id_pemasukan'=>$mutasi->id_pemasukan]) }}" data-dismiss="modal" data-toggle="modal" data-target="#viewPemasukanModal{{ $mutasi->id_pemasukan }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </td>
                                                <!-- <td class="d-flex">
                                                @if(isset($mutasi->jml_keluar))
                                                <a class="btn btn-warning btn-sm fa fa-pencil" role="button" data-dismiss="modal" data-toggle="modal" data-target="#editMutasi{{$mutasi->id_pengeluaran}}"></a>
								                <button onclick="confirmDelete(this)"  data-url="{{route('deleteMutasiPengeluaran',['id'=>$user->id])}}"data-nama="{{ $user->nama}}" class="btn btn-danger btn-sm ml-1 text-white fa fa-trash" role="button"></button>
                                                @else
                                                <a class="btn btn-warning btn-sm fa fa-pencil" role="button" data-dismiss="modal" data-toggle="modal" data-target="#editMutasi{{$mutasi->id_pemasukan}}"></a>
								                <button onclick="confirmDelete(this)"  data-url="{{route('deleteMutasiPemasukan',['id'=>$user->id])}}"data-nama="{{ $user->nama}}" class="btn btn-danger btn-sm ml-1 text-white fa fa-trash" role="button"></button>
                                                @endif
                                                </td> -->
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


        @foreach($users as $user)
        @php
            $mutasis = $pemasukans->concat($pengeluarans)->where('id_user', $user->id)->sortByDesc(function($mutasi) {
                return isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran;
            });
        @endphp

        @forelse ($mutasis as $mutasi)
            <!-- Modal for viewing pemasukan -->
            <div class="modal fade" id="viewPemasukanModal{{ $mutasi->id_pemasukan }}" tabindex="-1" role="dialog" aria-labelledby="viewPemasukanModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewPemasukanModalLabel">Bukti Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('storage/bukti_pemasukan/' . ($mutasi->bukti_pemasukan ?: $mutasi->bukti_pengeluaran)) }}" alt="Bukti Pemasukan" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Handle jika tidak ada data -->
            <p>Tidak ada bukti pemasukan</p>
        @endforelse
        @endforeach



        @foreach($mutasis as $mutasi)
        @if(isset($mutasi->id_pemasukan))
            <div class="modal fade" id="editMutasi{{ $mutasi->id_pemasukan }}" tabindex="-1" role="dialog" aria-labelledby="editMutasiModalLabel" aria-hidden="true">
        @elseif(isset($mutasi->id_pengeluaran))
            <div class="modal fade" id="editMutasi{{ $mutasi->id_pengeluaran }}" tabindex="-1" role="dialog" aria-labelledby="editMutasiModalLabel" aria-hidden="true">
        @endif
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMutasiModalLabel">Edit Mutasi Keuangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulir untuk mengedit catatan pemasukan/pengeluaran -->
                        @if(isset($mutasi->id_pemasukan))
                            <form action="{{ route('mutasiPengeluaran', ['id_pengeluaran' => $mutasi->id_pengeluaran]) }}" method="post">
                        @elseif(isset($mutasi->id_pengeluaran))
                            <form action="{{ route('mutasiPemasukan', ['id_pemasukan' => $mutasi->id_pemasukan]) }}" method="post">
                        @endif
                        
                            @csrf
                            @method('PUT')

                            <!-- Input hidden untuk mengetahui jenis mutasi -->
                            <input type="hidden" name="jenis_mutasi" value="{{ isset($mutasi->id_pemasukan) ? 'pemasukan' : 'pengeluaran' }}">
                            <input type="hidden" name="mutasi_id" value="{{ isset($mutasi->id_pemasukan) ? $mutasi->id_pemasukan : $mutasi->id_pengeluaran }}">

                            <!-- Input untuk jumlah masuk/keluar -->
                            <div class="form-group">
                                <label for="jumlah_mutasi">Jumlah {{ isset($mutasi->id_pemasukan) ? 'Masuk' : 'Keluar' }}</label>
                                <input type="text" class="form-control" id="jumlah_mutasi" name="jumlah_mutasi" value="{{ isset($mutasi->jml_masuk) ? $mutasi->jml_masuk : $mutasi->jml_keluar }}" required>
                            </div>

                            <!-- Input untuk tanggal mutasi -->
                            <div class="form-group">
                                <label for="tgl_mutasi">Tanggal Mutasi</label>
                                <input type="date" class="form-control" id="tgl_mutasi" name="tgl_mutasi" value="{{ isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran }}" required>
                            </div>

                            <!-- Textarea untuk catatan -->
                            <div class="form-group">
                                <label for="catatan_mutasi">Catatan</label>
                                <textarea class="form-control" id="catatan_mutasi" name="catatan_mutasi" rows="3" required>{{ $mutasi->catatan }}</textarea>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-danger mr-1" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach($users as $user)
        <div class="modal fade" id="tambahPemasukanModalLabel" tabindex="-1" role="dialog" aria-labelledby="tambahPemasukanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPemasukanModalLabel">Tambah Pemasukan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulir untuk menambahkan catatan pemasukan -->
                        <form action="{{ route('storeSaldo') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Input untuk tanggal pemasukan -->
                                    <div class="form-group">
                                        <label for="tgl_pemasukan">Tanggal Pemasukan</label>
                                        <input type="date" class="form-control" id="tgl_pemasukan" name="tgl_pemasukan" required>
                                    </div>

                                    <!-- Pilih kategori menggunakan select -->
                                    <div class="form-group">
                                        <label for="nama_kategori">Nama Kategori</label>
                                        <select class="form-control select" name="id_kategori" id="nama_kategori" required>
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id_kategori }}" {{ old('id_kategori') == $kategoris->id_kategori ? 'selected' : '' }}>
                                                {{ $kategoris->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input untuk jumlah masuk -->
                                    <div class="form-group">
                                        <label for="jml_masuk">Nominal</label>
                                        <input type="text" class="form-control" id="jml_masuk" name="jml_masuk" value="{{ old('jml_masuk', 0) }}" required>
                                    </div>


                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan', '') }}</textarea>
                                    </div>

                                    <!-- Textarea untuk Bukti Pemasukan -->
                                    <div class="form-group">
                                        <label for="bukti_pemasukan">Bukti Pemasukan</label>
                                        <input type="file" name="bukti_pemasukan" accept="image/*" required>
                                    </div>

                                    <div class="text-right">
                                        <a href="{{route('daftarPemasukan')}}" class="btn btn-danger mr-1">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                                    <input type="hidden" name="id_user" value="{{ $user->id }}">
                                    <input type="hidden" name="id_user_create" value="{{ $user->id }}">
                                    <input type="hidden" name="id_user_edit" value="{{ $user->id }}">
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- javascript -->
    @section("addJavascript")
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('js/sweetalert.min.js')}}"></script>
        <script>
            confirmDelete = function(button){
                var url = $(button).data("url");
                swal({
                    "title"      : "Konfirmasi Hapus",
                    "text"       : "Apakah anda yakin menghapus data ini ?",
                    "dangermode" : true,
                    "buttons"    : true,
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
                })
            }

            $(function(){
                $("#dataTable").DataTable({
                    "columnDefs": [
                        { "width": "50px", "targets": 0 } // Ganti 50px sesuai dengan lebar yang Anda inginkan
                    ]
                });

                $("#tabelModal").DataTable({
                    "pageLength": 5,
                    "lengthChange": false,
                });


                $('#tambahPemasukanModalLabel').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var userId = button.data('userid');

                    $('#tambahPemasukanModalLabel input[name="user_id"]').val(userId);
                });
            });

        </script>
    @endsection
</div>
<!-- /.content -->
@endsection
