@php
function formatRupiah($angka){
$rupiah = "Rp. " . number_format($angka,0,',','.');
return $rupiah;
}
@endphp

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
                <a href="{{ route('cetakPemasukan', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success mx-1" role="button">Export PDF <i class="fa fa-file-pdf"></i></a>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('daftarPemasukan') }}" class="mb-3">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="d-block invisible">Filter</label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <!-- Tabel -->
                <table id="dataTable" class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Tanggal Pemasukan</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Catatan</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukans as $pemasukan)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($pemasukan->tgl_pemasukan)->locale('id')->isoFormat('D MMMM Y') }}</td>
                            <td>{{ $pemasukan->kategori->nama_kategori }}</td>
                            <td>{{"Rp ".number_format($pemasukan->jml_masuk, 0, ",", "." ) }}</td>
                            <td>{{ \Carbon\Carbon::parse($pemasukan->tgl_pemasukan)->format('d/m/Y') }}</td>
                            <td>{{ $pemasukan->kategori->nama_kategori }}</td>
                            <td>{{ formatRupiah($pemasukan->jml_masuk) }}</td>
                            <td>{{ $pemasukan->catatan }}</td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm view-button" data-url="{{ route('viewPemasukan', ['id_pemasukan'=>$pemasukan->id_pemasukan]) }}" data-toggle="modal" data-target="#viewPemasukanModal{{ $pemasukan->id_pemasukan }}">
                                    <i class="fa fa-eye"></i> Lihat
                                </button>
                                <a data-url="{{ route('editPemasukan', ['id_pemasukan'=>$pemasukan->id_pemasukan]) }}" class="btn btn-warning btn-sm edit-button" role="button" data-toggle="modal" data-target="#editPemasukanModal{{ $pemasukan->id_pemasukan }}">Edit</a>
                                <a onclick="confirmDelete(this, '{{ $pemasukan->id_pemasukan }}')" href="{{ route('deletePemasukan', $pemasukan->id_pemasukan) }}" data-nama="{{ $pemasukan->kategori->nama_kategori }}" class="btn btn-danger btn-sm ml-1 text-white delete-button" role="button">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr >
                        <td colspan="3" class="text-center">Jumlah</td>
                        <td colspan="2">{{"Rp ".number_format($total, 0, ",", "." ) }}</td>
                    </tr>
                </table>

                <!-- Modal untuk Menampilkan Bukti Pemasukan -->
                @foreach($pemasukans as $pemasukan)
                <div class="modal fade" id="viewPemasukanModal{{ $pemasukan->id_pemasukan }}" tabindex="-1" role="dialog" aria-labelledby="viewPemasukanModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewPemasukanModalLabel">Bukti Pemasukan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('storage/bukti_pemasukan/' . $pemasukan->bukti_pemasukan) }}" alt="Bukti Pemasukan" style="max-width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

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
                                <form action="{{ route('storePemasukan') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Input untuk tanggal pemasukan -->
                                    <div class="form-group">
                                        <label for="tgl_pemasukan">Tanggal Pemasukan</label>
                                        <input type="date" class="form-control" id="tgl_pemasukan" name="tgl_pemasukan" required>
                                    </div>

                                    <!-- Pilih kategori menggunakan select -->
                                    <div class="form-group">
                                        <label for="nama_kategori">Kategori</label>
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
                                <form action="{{ route('updatePemasukan', ['tbl_pemasukan' => $pemasukan->id_pemasukan]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')

                                    <!-- Input untuk tanggal pemasukan -->
                                    <div class="form-group">
                                        <label for="tgl_pemasukan_edit">Tanggal Pemasukan</label>
                                        <input type="date" class="form-control" id="tgl_pemasukan_edit" name="tgl_pemasukan" value="{{ $pemasukan->tgl_pemasukan }}" required>
                                    </div>

                                    <!-- Pilih kategori menggunakan select -->
                                    <div class="form-group">
                                        <label for="nama_kategori_edit">Kategori</label>
                                        <select class="form-control select" name="id_kategori" id="nama_kategori_edit" required>
                                            @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id_kategori }}" @if($kategoris->id_kategori ==
                                                $pemasukan->id_kategori) selected @endif>{{ $kategoris->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input untuk jumlah masuk -->
                                    <div class="form-group">
                                        <label for="jml_masuk_edit">Nominal</label>
                                        <input type="text" class="form-control" id="jml_masuk_edit" name="jml_masuk" value="{{ $pemasukan->jml_masuk }}" required>
                                    </div>

                                    <!-- Textarea untuk catatan -->
                                    <div class="form-group">
                                        <label for="catatan_edit">Catatan</label>
                                        <textarea class="form-control" id="catatan_edit" name="catatan" rows="3" required>{{ $pemasukan->catatan }}</textarea>
                                    </div>

                                    <!-- Input untuk bukti edit pemasukan -->
                                    <div class="form-group">
                                        <label for="bukti_pemasukan_edit">Bukti Pemasukan</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="bukti_pemasukan_edit" name="bukti_pemasukan" accept="image/*">
                                            <label class="custom-file-label" for="bukti_pemasukan_edit">Choose file</label>
                                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
            // Script untuk menangani klik tombol "Lihat"
            $(".view-button").on("click", function() {
                var url = $(this).data("url");
                $("#viewPemasukanModal").modal("show");
            });
            // Format Rupiah
            $('.rupiah').mask('000.000.000.000', {
                reverse: true
            });
        });
    </script>
    @endsection
</div>
<!-- /.content -->
@endsection