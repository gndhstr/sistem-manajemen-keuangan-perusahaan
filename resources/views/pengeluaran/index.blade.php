@extends('karyawan.layouts.master')

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
                <h1 class="m-0 text-dark">Pengeluaran</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengeluaran</li>
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
                <a href="{{ route('createPengeluaran') }}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahPengeluaranModal">Tambah Data</a>
            </div>
            <div class="card-body">
                <!-- Tabel -->
                <table id="dataTable" class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Keluar</th>
                            <th>Tanggal Pengeluaran</th>
                            <th>Catatan</th>
                            <th>Bukti Pengeluaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluarans as $pengeluaran)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $pengeluaran->kategori->nama_kategori }}</td>
                            <td>{{ $pengeluaran->jml_keluar }}</td>
                            <td>{{ $pengeluaran->tgl_pengeluaran }}</td>
                            <td>{{ $pengeluaran->catatan }}</td>
                            <td>{{ $pengeluaran->bukti_pengeluaran }}</td>
                            <td>
                                <a data-url="{{ route('editPengeluaran', ['id_pengeluaran'=>$pengeluaran->id_pengeluaran]) }}" 
                                class="btn btn-warning btn-sm edit-button" role="button" data-toggle="modal" 
                                data-target="#editPengeluaranModal{{ $pengeluaran->id_pengeluaran }}">Edit</a>
                                <a onclick="confirmDelete(this, '{{ $pengeluaran->id_pengeluaran }}')" 
                                href="{{ route('deletePengeluaran', $pengeluaran->id_pengeluaran) }}" 
                                data-nama="{{ $pengeluaran->kategori->nama_kategori }}" 
                                class="btn btn-danger btn-sm ml-1 text-white delete-button" role="button">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Modal untuk Menambahkan pengeluaran -->
                <div class="modal fade" id="tambahPengeluaranModal" tabindex="-1" role="dialog" aria-labelledby="tambahPengeluaranModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahPengeluaranModalLabel">Tambah Pengeluaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulir untuk menambahkan catatan pengeluaran -->
                                <form action="{{ route('storePengeluaran') }}" method="post">
                                    @csrf

                                    <!-- Pilih kategori menggunakan select -->
                                    <select class="form-control select" name="id_kategori" id="id_kategori" required>
                                        @foreach ($kategori as $kategoris)
                                        <option value="{{ $kategoris->id_kategori }}" {{ old('id_kategori') == $kategoris->id_kategori ? 'selected' : '' }}>
                                            {{ $kategoris->nama_kategori }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <!-- Input untuk jumlah keluar -->
                                    <div class="form-group">
                                        <label for="jml_keluar">Jumlah Keluar</label>
                                        <input type="text" class="form-control" id="jml_keluar" name="jml_keluar" value="{{ old('jml_keluar', 0) }}" required>
                                    </div>

                                    <!-- Input untuk tanggal pengeluaran -->
                                    <div class="form-group">
                                        <label for="tgl_pengeluaran">Tanggal Pengeluaran</label>
                                        <input type="date" class="form-control" id="tgl_pengeluaran" name="tgl_pengeluaran" required>
                                    </div>

                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan', '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="bukti_pengeluaran">Bukti Pengeluaran</label>
                                        <input type="text" class="form-control" id="bukti_pengeluaran" name="bukti_pengeluaran" value="{{ old('bukti_pengeluaran', '') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <a href="{{route('daftarPengeluaran')}}" class="btn btn-danger mr-1">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id_user_create" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id_user_edit" value="{{ auth()->user()->id }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Edit Pengeluaran -->
                @foreach($pengeluarans as $pengeluaran)
                <div class="modal fade" id="editPengeluaranModal{{ $pengeluaran->id_pengeluaran }}" tabindex="-1" role="dialog" aria-labelledby="editPengeluaranModalLabel" aria-hidden="true">
                    <!-- Sisipkan modal edit pengeluaran -->
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPengeluaranModalLabel">Edit Pengeluaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulir untuk mengedit catatan pengeluaran -->
                                <form action="{{ route('updatePengeluaran', ['tbl_pengeluaran' => $pengeluaran->id_pengeluaran]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <!-- Pilih kategori menggunakan select -->
                                    <div class="form-group">
                                        <label for="nama_kategori_edit">Nama Kategori</label>
                                        <select class="form-control select" name="id_kategori" id="nama_kategori_edit" required>
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id_kategori }}" @if($kategoris->id_kategori == $pengeluaran->id_kategori) selected @endif>{{ $kategoris->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input untuk jumlah keluar -->
                                    <div class="form-group">
                                        <label for="jml_keluar_edit">Jumlah Keluar</label>
                                        <input type="text" class="form-control" id="jml_keluar_edit" name="jml_keluar" value="{{ $pengeluaran->jml_keluar }}" required>
                                    </div>

                                    <!-- Input untuk tanggal pengeluaran -->
                                    <div class="form-group">
                                        <label for="tgl_pengeluaran_edit">Tanggal pengeluaran</label>
                                        <input type="date" class="form-control" id="tgl_pengeluaran_edit" name="tgl_pengeluaran" value="{{ $pengeluaran->tgl_pengeluaran }}" required>
                                    </div>

                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan_edit">Catatan</label>
                                        <textarea class="form-control" id="catatan_edit" name="catatan" rows="3" required>{{ $pengeluaran->catatan }}</textarea>
                                    </div>

                                    <!-- Input untuk bukti pengeluaran -->
                                    <div class="form-group">
                                        <label for="bukti_pengeluaran_edit">Bukti Pengeluaran</label>
                                        <input type="text" class="form-control" id="bukti_pengeluaran_edit" name="bukti_pengeluaran" value="{{ $pengeluaran->bukti_pengeluaran }}" required>
                                    </div>

                                    <!-- Input untuk status -->
                                    <div class="form-group">
                                        <label for="status_edit">Status</label>
                                        <input type="text" class="form-control" id="status_edit" name="status" value="{{ $pengeluaran->status }}" required>
                                    </div>

                                    <div class="text-right">
                                        <a href="{{ route('daftarPengeluaran') }}" class="btn btn-danger mr-1">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id_user_create" value="{{ $pengeluaran->id_user_create }}">
                                    <input type="hidden" name="id_user_edit" value="{{ auth()->user()->id }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @section("addJavascript")
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        confirmDelete = function(button) {
            event.preventDefault();
            var url = $(button).attr("href");
            var nama = $(button).data("nama");

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin menghapus pengeluaran " + nama + "?",
                icon: "warning",
                dangerMode: true,
                buttons: {
                    cancel: "Batal",
                    confirm: {
                        text: "Hapus",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: true,
                    }
                }
            }).then(function(value) {
                if (value) {
                    window.location = url;
                }
            });
        }

        $(function() {
            $("#dataTable").DataTable();
        });
    </script>
    @endsection
</div>
<!-- /.content -->
@endsection