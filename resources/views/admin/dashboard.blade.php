@extends('layouts.master')

@section("addCss")
<link rel="stylesheet" href="{{asset('css/card.css')}}">
@endsection
@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">{{$greeting}}, {{ Auth::user()->nama }}</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div><!-- /.col -->
		</div>
	</div>
</div>


<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-xl-3 " >
				<a href="{{route('daftarDivisi')}}"  class="card bg-c-blue order-card text-decoration-none text-white" >
					<div class="card-block">
						<h4 class="m-b-20">Divisi</h4>
						<h1 class="text-right"><i class="fa fa-users f-left"></i><span>{{$dataDivisi}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-xl-3">
				<a href="{{route('daftarRole')}}" class="card bg-c-yellow order-card text-white">
					<div class="card-block">
						<h4 class="m-b-20">Role</h4>
						<h1 class="text-right"><i class="fa fa-briefcase f-left"></i><span>{{$dataRole}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-xl-3">
				<a href="{{route('daftarUser')}}" class="card bg-c-green order-card text-white">
					<div class="card-block">
						<h4 class="m-b-20">User</h4>
						<h1 class="text-right"><i class="fa fa-user f-left "></i><span>{{$dataUser}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-xl-3">
				<a href="{{route('daftarKategori')}}" class="card bg-c-pink order-card text-white">
					<div class="card-block">
						<h4 class="m-b-20">Kategori</h4>
						<h1 class="text-right"><i class="fa fa-money f-left"></i><span>{{$dataKategori}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</a>
			</div>

		</div>	
	</div>
</div>

<!--  -->
<!-- <div class="container">
		<div class="row">
			<div class="col-md-4 col-xl-3 " >
				<div class="card bg-c-blue order-card" >
					<div class="card-block">
						<h4 class="m-b-20">Divisi</h4>
						<h1 class="text-right"><i class="fa fa-users f-left"></i><span>{{$dataDivisi}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-xl-3">
				<div class="card bg-c-green order-card">
					<div class="card-block">
						<h4 class="m-b-20">User</h4>
						<h1 class="text-right"><i class="fa fa-user f-left "></i><span>{{$dataUser}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-xl-3">
				<div class="card bg-c-yellow order-card">
					<div class="card-block">
						<h4 class="m-b-20">Role</h4>
						<h1 class="text-right"><i class="fa fa-briefcase f-left"></i><span>{{$dataRole}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-xl-3">
				<div class="card bg-c-pink order-card">
					<div class="card-block">
						<h4 class="m-b-20">Kategori</h4>
						<h1 class="text-right"><i class="fa fa-money f-left"></i><span>{{$dataKategori}}</span></h1>
						<p class="m-b-0">Klik Lebih lanjut<span class="f-right"><i class="fa fa-arrow-circle-right link"></i></span></p>
					</div>
				</div>
			</div>
		</div>
</div> -->



<!-- /.content -->
@endsection