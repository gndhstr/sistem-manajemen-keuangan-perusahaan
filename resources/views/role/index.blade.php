@extends('admin.layouts.master')
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
                <h1 class="m-0 text-dark">Daftar Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Role</li>
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
                <a href="{{route('createRole')}}" class="btn btn-primary" role="button" data-toggle="modal"
                    data-target="#tambahData">Tambah Data</a>
            </div>
            <div class="card-body">
                <table class="table table-hover mb-0" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1}}</td>
                            <td class="text-center">{{ $role->role}}</td>
                            <td class="text-center">
                                <a data-url="{{route('editRole',['id_role'=>$role->id_role])}}"
                                    class="btn btn-warning btn-sm" role="button" data-toggle="modal"
                                    data-target="#editData{{$role->id_role}}">Edit</a>
                                <a onclick="confirmDelete(this)"
                                    data-url="{{route('deleteRole',['id_role'=>$role->id_role])}}"
                                    data-nama="{{$role->role}}" class="btn btn-danger btn-sm ml-1 text-white"
                                    role="button">Hapus</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Data Role -->
                    <form action="{{route('storeRole')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Role</label>
                            <input type="text" name="role" id="role" class="form-control" required
                                placeholder="Masukkan Nama Role">
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
    @foreach($roles as $role)
    <div class="modal fade" id="editData{{ $role->id_role }}" tabindex="-1" role="dialog"
        aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Edit Data Kategori -->
                    <form action="{{ route('updateRole', ['id_role' => $role->id_role]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" name="role" id="role" class="form-control" required="required"
                                placeholder="Masukkan Nama Jabatan" value="{{$role->role}}">
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
        var successMessage = "{{ session('success') }}";
        if (successMessage) {
            Swal.fire({
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

        // fungsi data table
        $(function () {
            $("#dataTable").DataTable();
        });

    </script>
    @endsection
</div>
<!-- /.content -->
@endsection
