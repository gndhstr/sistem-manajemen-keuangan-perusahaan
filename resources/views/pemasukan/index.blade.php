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
                <h1 class="m-0 text-dark">Pemasukan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemasukan</li>
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
                <a href="{{ route('createPemasukan') }}" class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambahPemasukanModal">Tambah Data</a>
                <a href="{{route('cetakPemasukan')}}" class="btn btn-success mx-1" role="button" >Export PDF <i class="fa fa-file-pdf"></i></a>
            </div>
            <div class="card-body">
                <!-- Tabel -->
                <table id="dataTable" class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pemasukan</th>
                            <th>Catatan</th>
                            <th>Bukti Pemasukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukans as $pemasukan)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $pemasukan->kategori->nama_kategori }}</td>
                            <td>{{ $pemasukan->jml_masuk }}</td>
                            <td>{{ $pemasukan->tgl_pemasukan }}</td>
                            <td>{{ $pemasukan->catatan }}</td>
                            <td>{{ $pemasukan->bukti_pemasukan }}</td>
                            <td>
                                <a data-url="{{ route('editPemasukan', ['id_pemasukan'=>$pemasukan->id_pemasukan]) }}" class="btn btn-warning btn-sm edit-button" role="button" data-toggle="modal" data-target="#editPemasukanModal{{ $pemasukan->id_pemasukan }}">Edit</a>
                                <a onclick="confirmDelete(this, '{{ $pemasukan->id_pemasukan }}')" href="{{ route('deletePemasukan', $pemasukan->id_pemasukan) }}" data-nama="{{ $pemasukan->kategori->nama_kategori }}" class="btn btn-danger btn-sm ml-1 text-white delete-button" role="button">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Modal untuk Menambahkan Pemasukan -->
                <div class="modal fade" id="tambahPemasukanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPemasukanModalLabel" aria-hidden="true">
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
                                <form action="{{ route('storePemasukan') }}" method="post">
                                    @csrf

                                    <!-- Pilih kategori menggunakan select -->
                                    <select class="form-control select" name="id_kategori" id="id_kategori" required>
                                        @foreach ($kategori as $kategoris)
                                        <option value="{{ $kategoris->id_kategori }}" {{ old('id_kategori') == $kategoris->id_kategori ? 'selected' : '' }}>
                                            {{ $kategoris->nama_kategori }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <!-- Input untuk jumlah masuk -->
                                    <div class="form-group">
                                        <label for="jml_masuk">Jumlah Masuk</label>
                                        <input type="text" class="form-control" id="jml_masuk" name="jml_masuk" value="{{ old('jml_masuk', 0) }}" required>
                                    </div>

                                    <!-- Input untuk tanggal pemasukan -->
                                    <div class="form-group">
                                        <label for="tgl_pemasukan">Tanggal Pemasukan</label>
                                        <input type="date" class="form-control" id="tgl_pemasukan" name="tgl_pemasukan" required>
                                    </div>

                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan', '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="bukti_pemasukan">Bukti Pemasukan</label>
                                        <input type="text" class="form-control" id="bukti_pemasukan" name="bukti_pemasukan" value="{{ old('bukti_pemasukan', '') }}" required>
                                    </div>

                                    <div class="text-right">
                                        <a href="{{route('daftarPemasukan')}}" class="btn btn-danger mr-1">Batal</a>
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

                <!-- Modal untuk Edit Pemasukan -->
                @foreach($pemasukans as $pemasukan)
                <div class="modal fade" id="editPemasukanModal{{ $pemasukan->id_pemasukan }}" tabindex="-1" role="dialog" aria-labelledby="editPemasukanModalLabel" aria-hidden="true">
                    <!-- Sisipkan modal edit pemasukan -->
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPemasukanModalLabel">Edit Pemasukan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulir untuk mengedit catatan pemasukan -->
                                <form action="{{ route('updatePemasukan', ['tbl_pemasukan' => $pemasukan->id_pemasukan]) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <!-- Pilih kategori menggunakan select -->
                                    <div class="form-group">
                                        <label for="nama_kategori_edit">Nama Kategori</label>
                                        <select class="form-control select" name="id_kategori" id="nama_kategori_edit" required>
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id_kategori }}" @if($kategoris->id_kategori == $pemasukan->id_kategori) selected @endif>{{ $kategoris->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input untuk jumlah masuk -->
                                    <div class="form-group">
                                        <label for="jml_masuk_edit">Jumlah Masuk</label>
                                        <input type="text" class="form-control" id="jml_masuk_edit" name="jml_masuk" value="{{ $pemasukan->jml_masuk }}" required>
                                    </div>

                                    <!-- Input untuk tanggal pemasukan -->
                                    <div class="form-group">
                                        <label for="tgl_pemasukan_edit">Tanggal Pemasukan</label>
                                        <input type="date" class="form-control" id="tgl_pemasukan_edit" name="tgl_pemasukan" value="{{ $pemasukan->tgl_pemasukan }}" required>
                                    </div>

                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan_edit">Catatan</label>
                                        <textarea class="form-control" id="catatan_edit" name="catatan" rows="3" required>{{ $pemasukan->catatan }}</textarea>
                                    </div>

                                    <!-- Input untuk bukti pemasukan -->
                                    <div class="form-group">
                                        <label for="bukti_pemasukan_edit">Bukti Pemasukan</label>
                                        <input type="text" class="form-control" id="bukti_pemasukan_edit" name="bukti_pemasukan" value="{{ $pemasukan->bukti_pemasukan }}" required>
                                    </div>

                                    <!-- Input untuk status -->
                                    <div class="form-group">
                                        <label for="status_edit">Status</label>
                                        <input type="text" class="form-control" id="status_edit" name="status" value="{{ $pemasukan->status }}" required>
                                    </div>

                                    <div class="text-right">
                                        <a href="{{ route('daftarPemasukan') }}" class="btn btn-danger mr-1">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id_user_create" value="{{ $pemasukan->id_user_create }}">
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
    <script src="https://kit.fontawesome.com/e2b0e4079e.js" crossorigin="anonymous"></script>
    <script>
        confirmDelete = function(button) {
            event.preventDefault();
            var url = $(button).attr("href");
            var nama = $(button).data("nama");

            swal({
                title: "Konfirmasi Hapus",
                text: "Apakah Anda yakin menghapus Pemasukan " + nama + "?",
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
