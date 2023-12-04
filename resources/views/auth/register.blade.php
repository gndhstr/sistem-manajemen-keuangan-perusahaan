@extends('auth.master')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Register') }}</p>

        <form action="{{route('register')}}" method="post">
            @csrf

            <div class="input-group mb-3">
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Masukkan nama lengkap" name="nama" value="{{ old('nama') }}" required autocomplete="nama"
                    autofocus>
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
                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username"
                    value="{{old('username')}}" placeholder="Masukkan username" required autocomplete="username">
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

        @if (Route::has('login'))
        <hr>
        <p class="mb-0 text-center">
            <a href="{{ route('login') }}" class="text-center">{{ __('Sudah punya akun? Login sekarang') }}</a>
        </p>
        @endif
    </div>
    <!-- /.login-card-body -->
</div>
@endsection