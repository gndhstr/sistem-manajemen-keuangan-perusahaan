@extends('admin.layouts.master')

@section("addCss")
<link rel="stylesheet" href="{{asset('css/index-profil.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="font-weight-bold">
                    Profile
                </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ !is_null(Auth()->user()->foto_profil) && file_exists(public_path('storage/' . Auth()->user()->foto_profil)) ? asset('storage/' . Auth()->user()->foto_profil) : asset('img/user-photo-default.png') }}" alt="Admin"
                                class="rounded-circle p-1" width="110" height="110">
                            <div class="mt-3">
                                <div class="row">
                                    <h4>{{$profile->nama}} </h4>
                                    <h6 class="ml-1 mt-1">
                                        <a href="{{ route('Profile') }}" class="text-decoration-none text-black">
                                            <i class="fa fa-pen text-black" style="color:black;"></i>
                                        </a>
                                    </h6> 
                                </div>
                                <p class="text-secondary mb-1"> {{$profile->role_user->role}}</p>

                                @if ($profile->role == '3' || $profile->role == '4')
                                    <p class="text-muted font-size-sm">{{$profile->division->nama_divisi}}</p>
                                @else
                                <p class="text-muted font-size-sm"></p>
                                @endif
                                </p>
                                <!-- <a href="{{ route('Profile') }}" class="btn btn-default mb-3">Edit</a> -->
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Username</h6>
                                <span class="text-secondary">{{$profile->username}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Nama</h6>
                                <span class="text-secondary">{{$profile->nama}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Alamat</h6>
                                <span class="text-secondary">{{$profile->alamat}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">No.Telepon</h6>
                                <span class="text-secondary">{{$profile->nomor_telepon}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Email</h6>
                                <span class="text-secondary">{{$profile->email}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section("addJavascript")
<script src="https://kit.fontawesome.com/e2b0e4079e.js" crossorigin="anonymous"></script>
@endsection
