@extends('auth.master')

@section('addCss')
    <style>
        html {
            overflow: hidden;
        }

        .login-box {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Register') }}</p>

            <form action="{{ route('register') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap" name="nama" value="{{ old('nama') }}" required
                        autocomplete="nama" autofocus>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-user"></span>
                    </div>
                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" placeholder="Masukkan username" required
                        autocomplete="username">
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-id-badge"></span>
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="input-group mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{old('email')}}" placeholder="Email" required autocomplete="email">
                <div class="input-group-append input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror --}}
                <div class="input-group mb-1">
                    <select id="role" class="form-control @error('role') is-invalid @enderror" name="role"
                        value="{{ old('role') }}" required autocomplete="role">
                        <option value="direktur">Direktur</option>
                        <option value="manager">Manager</option>
                        <option value="karyawan">karyawan</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    @php
                        $user = App\tbl_divisi::get();
                    @endphp

                    <select id="divisi" class="form-control @error('divisi') is-invalid @enderror" name="divisi"
                        value="{{ old('divisi') }}" required autocomplete="divisi">
                        @foreach ($user as $division)
                            <option value="{{ $division->id_divisi }}">{{ $division->nama_divisi }}</option>
                            <option value="" hidden></option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <label for="jenis_kelamin" class="mr-2 d-flex align-items-center">Masukkan jenis kelamin: </label>
                    <select id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror"
                        name="jenis_kelamin" value="{{ old('jenis_kelamin') }}" placeholder="Masukkan jenis_kelamin"
                        required autocomplete="jenis_kelamin">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="nomor_telepon" type="text"
                        class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon"
                        value="{{ old('nomor_telepon') }}" placeholder="Masukkan nomor_telepon"
                        autocomplete="nomor_telepon">
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-id-badge"></span>
                    </div>
                    @error('nomor_telepon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <label for="alamat" class="mr-2 d-flex align-items-center">Masukkan Alamat:</label>
                    <textarea id="alamat"class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                        value="{{ old('alamat') }}" autocomplete="alamat">                    
                </textarea>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" name="password" required autocomplete="new-password">
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control" placeholder="Masukkan ulang password"
                        name="password_confirmation" required autocomplete="new-password">
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 offset-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Register') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection

@section('addJavascript')
    <script>
        $(document).ready(function() {
            toggleDivisiVisibility();

            $('#role').change(function() {
                toggleDivisiVisibility();
            });

            function toggleDivisiVisibility() {
                var selectedRole = $('#role').val(); //get role value

                if (selectedRole === 'direktur') {
                    $('#divisi').val(null);
                    $('#divisi').hide();
                } else {
                    $('#divisi').val({{ 1 }});
                    $('#divisi').show();
                }
            }
        });
    </script>
@endsection
