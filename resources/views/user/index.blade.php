@extends('admin.layouts.master')
<!-- css -->
@section("addCss")
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('css/table-responsive.css')}}">
@endsection
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-right mb-2">
                <h3 class=""></h3>
                <div>
                    <a href="{{route('createUser')}}" class="btn btn-primary" role="button" data-toggle="modal"
                        data-target="#tambahData"><i class="fa fa-plus"></i></a>
                    <a href="{{route('cetakUser')}}" class="btn btn-success mx-1" role="button"><i
                            class="fa fa-print"></i></a>
                </div>
            </div>
            <div class="card-body  tabel-responsive">
                <!-- <div class="d-flex justify-content-between mb-2">
                    <h3 class="">Data User</h3>
                    <div>
                        <a href="{{route('createUser')}}" class="btn btn-primary" role="button" data-toggle="modal"
                            data-target="#tambahData"><i class="fa fa-plus"></i></a>
                        <a href="{{route('cetakUser')}}" class="btn btn-success mx-1" role="button"><i
                                class="fa fa-print"></i></a>
                    </div>
                </div> -->
                <table class="table table-hover mb-0" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Divisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td data-label="No" class="text-center">{{ $loop->index + 1}}</td>
                            <td data-label="Nama" class="text-center">{{ $user->nama}}</td>
                            <td data-label="Role" class="text-center">
                                {{ $user->role_user ? $user->role_user->role : "-"}}</td>
                            <td data-label="Divisi" class="text-center">
                                {{ $user->division ? $user->division->nama_divisi : "-"}}</td>
                            <td data-label="Aksi" class="text-center">
                                <a data-url="{{route('editUser',['id'=>$user->id])}}" class="btn btn-warning btn-sm"
                                    role="button" data-toggle="modal" data-target="#editData{{$user->id}}"><i
                                        class="fa fa-pen"></i></a>
                                <a onclick="confirmDelete(this)" data-url="{{route('deleteUser',['id'=>$user->id])}}"
                                    data-nama="{{ $user->nama}}" class="btn btn-danger btn-sm ml-1 text-white"
                                    role="button"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.container-fluid -->

    <!-- Modal Tambah Data -->
    @foreach($users as $user)
    <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Data Role -->
                    <form action="{{route('storeUser')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required
                                placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required="required">
                                @foreach($roles as $role)
                                <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="id_divisi" id="id_divisi" class="form-control" required="required">
                                @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id_divisi }}">{{ $divisi->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <!-- username -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required
                                placeholder="Masukkan Username">
                        </div>

                        <!-- password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required
                                placeholder="Masukkan Password">
                        </div>
                        <div class="form-group">
                            <label for="password">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required
                                placeholder="Masukkan Email">
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


    <!-- Modal Edit Data -->
    @foreach($users as $user)
    <div class="modal fade" id="editData{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Data Role -->
                    <form action="{{route('updateUser',['id'=>$user->id])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required
                                placeholder="Masukkan Nama" value="{{$user->nama}}">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required="required">
                                @foreach($roles as $role)
                                <option value="{{ $role->id_role }}" {{$role->id_role == $user->role ? "selected": ""}}>
                                    {{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="id_divisi" id="id_divisi" class="form-control" required="required">
                                @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id_divisi }}"
                                    {{$divisi->id_divisi == $user->id_divisi ? "selected": ""}}>
                                    {{ $divisi->nama_divisi }}</option>
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
    <!-- End Modal Tambah Data -->

    <!-- javascript -->
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
                "text": "Apakah anda yakin menghapus " + nama + "?",
                "icon": "warning",
                "dangermode": true,
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

        // fungsi data table
        $(function () {
            $("#dataTable").DataTable();
        });

    </script>
    @endsection
</div>
<!-- /.content -->
@endsection
