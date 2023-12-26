@extends('admin.layouts.master')

@section("addCss")
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="font-weight-bold">
                    Account settings
                </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('indexProfile')}}">Profil</a></li>
                    <li class="breadcrumb-item active">Edit Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container light-style flex-grow-1 container-p-y">
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list"
                        href="#account-general"><i class="fa fa-user  mx-1"></i>Akun</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list"
                        href="#account-change-password"><i class="fa fa-lock mx-1"></i>Keamanan Sandi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="account-general">
                        <div class="card-body media align-items-center">
                            <form action="{{ route('updateProfile',$profile->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('storage/' . Auth()->user()->foto_profil) }}" alt=""
                                            class="d-block ui-w-80 ml-2" height="80">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label class="btn btn-outline-primary">
                                            Upload Foto
                                            <input type="file" name="foto_profil" id="foto_profil"
                                                class="account-settings-fileinput" style="display: none;">
                                        </label>
                                        <button type="reset" class="btn btn-default md-btn-flat ml-2">Reset</button>
                                    </div>
                                    <div class="text-light small ml-3 mt-1">Rasio ukuran 1 : 1 <br>
                                        Perubahan foto saat sudah klik simpan <br>Format JPG, JPEG, dan PNG dengan
                                        maksimal 2Mb
                                    </div>
                                </div>
                                <hr class="border-light m-0">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Masukkan Nama" value="{{$profile->nama}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" rows="5" name="alamat" id="alamat"
                                            placeholder="Masukkan Alamat">{{ $profile->alamat }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">No.Telepon</label>
                                        <input type="number" class="form-control" name="nomor_telepon"
                                            id="nomor_telepon" placeholder="Masukkan No. Telepon"
                                            value="{{$profile->nomor_telepon}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Masukkan Email" value="{{$profile->email}}">
                                    </div>
                                    <div class="text-right mb-5 mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
                                        <a href="{{ route('indexProfile') }}" class="btn btn-default">Batal</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="account-change-password">
                    <div class="card-body pb-2">
                        <form action="{{ route('updatePassword')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Password Sekarang</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="pw_lama" id="pw_lama">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="pw_lama">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('pw_lama')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="pw_baru" id="pw_baru">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="pw_baru">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="konfirm_pw" id="konfirm_pw">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="konfirm_pw">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mb-5 mt-3">
                                <button type="submit" class="btn btn-primary">Save changes</button>&nbsp;
                                <a href="{{ route('indexProfile') }}" class="btn btn-default">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

@endsection
@section("addJavascript")
<script src="https://kit.fontawesome.com/e2b0e4079e.js" crossorigin="anonymous"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script>
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

    //menampilkan text pada eye
    $(document).ready(function () {
        $(".toggle-password").click(function () {
            var target = $("#" + $(this).data("target"));
            var type = target.attr("type") === "password" ? "text" : "password";
            target.attr("type", type);

            // Ubah ikon mata sesuai dengan tipe password saat ini
            $(this).find("i").toggleClass("fa-eye fa-eye-slash");
        });
    });

</script>
@endsection
