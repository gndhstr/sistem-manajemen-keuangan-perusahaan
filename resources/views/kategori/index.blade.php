@extends((Auth::user()->role == 3) ? 'manajer.layouts.master' : 'admin.layouts.master')
<!-- css -->
@section("addCss")
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/table-responsive.css')}}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-right">
                <a href="{{route('createKategori')}}" class="btn btn-primary" role="button" data-toggle="modal"
                    data-target="#tambahDataModal"><i class="fa fa-plus"></i></a>
            </div>
            <div class="card-body tabel-responsive">
                <!-- <div class="d-flex justify-content-between mb-2">
                    <h3 class="">Data Kategori</h3>
                    <div>
                        <a href="{{route('createKategori')}}" class="btn btn-primary" role="button" data-toggle="modal"
                            data-target="#tambahDataModal">Tambah Data</a>
                    </div>
                </div> -->
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
                            <td data-label="No" class="text-center">{{ $loop->index + 1}}</td>
                            <td data-label="Kategori" class="text-center">{{ $kategori->nama_kategori}}</td>
                            <td data-label="Jenis" class="text-center">{{ $kategori->jenis_kategori}}</td>
                            <td class="text-center">
                                <a data-url="{{route('editKategori',['id_kategori'=>$kategori->id_kategori])}}"
                                    class="btn btn-warning btn-sm " role="button" data-toggle="modal"
                                    data-target="#editData{{$kategori->id_kategori}}"><i class="fa fa-pen"></i></a>
                                <a onclick="confirmDelete(this)"
                                    data-url="{{route('deleteKategori',['id_kategori'=>$kategori->id_kategori])}}"
                                    data-nama="{{$kategori->nama_kategori}}"
                                    class="btn btn-danger btn-sm ml-1 text-white" role="button"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.container-fluid -->

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
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
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required
                                placeholder="Masukkan Nama Kategori">
                        </div>
                        <div class="form-group">
                            <label for="nama">Jenis</label>
                            <select name="jenis_kategori" id="jenis_kategori" class="form-control" required="required">
                                @foreach(['Pengeluaran', 'Pemasukan'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
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
    <!-- End Modal Tambah Data -->

    <!-- Modal Edit Data -->
    @foreach($kategoris as $kategori)
    <div class="modal fade" id="editData{{$kategori->id_kategori}}" tabindex="-1" role="dialog"
        aria-labelledby="editDataModalLabel" aria-hidden="true">
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
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required
                                placeholder="Masukkan Nama Kategori" value="{{$kategori->nama_kategori}}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kategori">Jenis</label>
                            <select name="jenis_kategori" id="jenis_kategori" class="form-control" required="required">
                                @foreach(['Pengeluaran', 'Pemasukan'] as $option)
                                <option value="{{ $option }}"
                                    {{ $kategori->jenis_kategori == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                                @endforeach
                            </select>
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
    <!-- End Modal Edit Data -->


    @section("addJavascript")
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/e2b0e4079e.js" crossorigin="anonymous"></script>
    <script>
        confirmDelete = function (button) {
            var url = $(button).data("url");
            var nama = $(button).data("nama");
            swal({
                "text": "Konfirmasi Hapus",
                "text": "Apakah anda yakin menghapus Divisi " + nama + "?",
                "icon": "warning",
                "dangerMode": true,
                "buttons": true,
            }).then(function (value) {
                if (value) {
                    window.location = url;
                }
            })
        }
        //ubah ukuran text alert succes
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

        //tabel 
        const textCenterTdElements = document.querySelectorAll('.table td.text-center');

        // Fungsi untuk menyesuaikan kelas pada elemen <td> dan <table>
        function adjustLayout() {
            const windowWidth = window.innerWidth;

            // Jika lebar layar kurang dari atau sama dengan 500px
            if (windowWidth <= 500) {
                // Hapus kelas text-center dari elemen <td>
                textCenterTdElements.forEach(td => {
                    td.classList.remove('text-center');
                });


            } else {
                // Jika lebar layar lebih dari 500px, tambahkan kembali kelas yang dihapus sebelumnya
                textCenterTdElements.forEach(td => {
                    td.classList.add('text-center');
                });


            }
        }

        // Panggil fungsi pertama kali saat dokumen dimuat
        adjustLayout();

        // Tambahkan event listener untuk menanggapi perubahan ukuran layar
        window.addEventListener('resize', adjustLayout);

        $(function () {
            $("#dataTable").DataTable();
        });

    </script>
    @endsection
</div>
<!-- /.content -->
@endsection
