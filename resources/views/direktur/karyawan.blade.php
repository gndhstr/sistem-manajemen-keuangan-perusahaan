@extends('direktur.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <style>
        .selected:hover {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Karyawan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            {{-- main content here --}}
            <div class="card mr-lg-5 col-lg-12">
                <div class="card-header border-0">
                    <h3 class="card-title">Karyawan</h3>
                    <div class="card-tools">
                        {{-- tools --}}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="data-table-karyawan" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1">No.</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th class="col-2">nomor telepon</th>
                                <th>keuangan</th>
                                <th>saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $karyawan)
                                <tr data-toggle="modal" data-target="#karyawan-{{ $karyawan->id }}" class="selected">
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="text-center">{{ $karyawan->nama }}</td>
                                    <td class="text-center">{{ $karyawan->division->nama_divisi }}</td>
                                    <td class="text-center">{{ $karyawan->nomor_telepon }}</td>
                                    <td class="row text-center">
                                        <div class="col-10">
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-danger" style="width: 30%"></div>
                                            </div>
                                            <div class="progress progress-xs mt-1">
                                                <div class="progress-bar progress-bar-danger bg-secondary"
                                                    style="width: 30%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2"><span class="badge bg-success">55%</span></div>
                                    </td>
                                    <td class="text-right">Rp. 50.000,00</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Karyawan box-->
            <div class="card d-flex flex-fill col-lg-5 col-md-8 col-sm-12 p-0">
                <div class="card-header  border-bottom-0">
                    Divisi A
                </div>
                <div class="card-body pt-0">
                    <h2 class="lead"><b>KuruKuru</b></h2>
                    <div class="row">
                        <div class="col-7">
                            <p class="text-sm">Bergabung:<b> {{ date('d/m/Y') }} </b></p>
                            <ul class="ml-4 mb-0 fa-ul ">
                                <li class="small"><span class="fa-li"><i class="fa fa-lg fa-venus-mars"></i></span> Jenis
                                    Kelamin: Laki-laki
                                </li>
                                <li class="small"><span class="fa-li"><i class="fa fa-lg fa-building"></i></span>
                                    Alamat: xx
                                    Jalan 123, Kota xx 04312, NJ</li>
                                <li class="small"><span class="fa-li"><i class="fa fa-lg fa-phone"></i></span>
                                    Telefon: 0801-2312-1233</li>
                            </ul>
                            <ul class="fa-ul mx-0">
                                <li class="mt-3 small text-muted text-small mx-0 mb-0">*data bulan ini</li>
                                <li class="text-sm d-flex justify-content-between">Saldo:<b>Rp. 3000.000,00</b></li>
                                <li class="text-sm d-flex justify-content-between">Pengeluaran:<b>Rp.
                                        3000.000,00</b></li>
                                <li class="text-sm d-flex justify-content-between">Pemasukan:<i
                                        class="fa fa-sm fa-plus text-success ml-auto mt-1"></i><span
                                        class="text-success ml-1"><b>Rp.
                                            3000.000,00</b></span></li>
                            </ul>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger bg-success" style="width: 30%"></div>
                            </div>
                        </div>
                        <div class="col-5 text-center">
                            <img src="https://i.pinimg.com/736x/fd/1b/1b/fd1b1b147db290c8421136b32c4c437e.jpg"
                                alt="user-avatar" class="img-circle img-fluid" width="200px">
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-teal pb-4">
                    <div class="text-right">
                        {{-- footer right --}}
                    </div>
                </div>
            </div>         

            <!-- Modal -->
            @foreach ($karyawans as $karyawan)
                <div class="modal fade p-0" id="karyawan-{{ $karyawan->id }}" tabindex="-1" role="dialog" aria-labelledby="karyawan-1Title"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $karyawan->division->nama_divisi }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="card-body pt-0">
                                    <h2 class="lead"><b>{{ $karyawan->nama }}</b></h2>
                                    <div class="row">
                                        <div class="col-7">
                                            <p class="text-sm">Bergabung:<b> {{ date('d/m/Y') }} </b></p>
                                            <ul class="ml-4 mb-0 fa-ul ">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fa fa-lg fa-venus-mars"></i></span> Jenis
                                                    Kelamin: {{ $karyawan->jenis_kelamin }}
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fa fa-lg fa-building"></i></span>
                                                    Alamat: {{ $karyawan->alamat }}</li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fa fa-lg fa-phone"></i></span>
                                                    Telefon: {{ $karyawan->nomor_telepon }}</li>
                                            </ul>
                                            <ul class="fa-ul mx-0">
                                                <li class="mt-3 small text-muted text-small mx-0 mb-0">*data bulan ini</li>
                                                <li class="text-sm d-flex justify-content-between">Saldo:<b>Rp.
                                                        3000.000,00</b></li>
                                                <li class="text-sm d-flex justify-content-between">Pengeluaran:<b>Rp.
                                                        3000.000,00</b></li>
                                                <li class="text-sm d-flex justify-content-between">Pemasukan:<i
                                                        class="fa fa-sm fa-plus text-success ml-auto mt-1"></i><span
                                                        class="text-success ml-1"><b>Rp.
                                                            3000.000,00</b></span></li>
                                            </ul>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-danger bg-success"
                                                    style="width: 30%"></div>
                                            </div>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img src="{{ $karyawan->foto_profil }}"
                                                alt="user-avatar" class="img-circle img-fluid" width="200px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-teal p-3">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('addJavascript')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $("#data-table-karyawan").DataTable({
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4, 5],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });
        });
    </script>
@endsection
