@extends('direktur.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <style>
        .selected:hover {
            cursor: pointer;
        }

        .bg-gradient {
            background: #FF416C;
            background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
            background: linear-gradient(to right, #FF4B2B, #FF416C);
        }

        .card-body {
            width: 100%;
        }

        #data-table-karyawan {
            width: 100%;
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
                        <li class="breadcrumb-item"><a href="{{ route('dashboardDirektur') }}">Dashboard</a></li>
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
                        {{-- <span class="badge badge-info">{{ date('F') }}</span> --}}
                        <p class="small text-muted text-small mx-0 mb-0">*Data di bulan ini</p>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data-table-karyawan" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>nomor telepon</th>
                                <th>Total Pemasukan</th>
                                <th>Total Pengeluaran</th>
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
                                    <td class="text-right">
                                        <i class="fa fa-arrow-up mr-1 text-success"></i>Rp.
                                        {{ number_format($karyawan->pemasukan->isEmpty() ? 0 : $karyawan->pemasukan[0]->total_pemasukan, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right"><i class="fa fa-arrow-down mr-1 text-danger"></i>Rp.
                                        {{ number_format($karyawan->pengeluaran->isEmpty() ? 0 : $karyawan->pengeluaran[0]->total_pengeluaran, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">Rp.
                                        {{ number_format(($karyawan->pemasukan->isEmpty() ? 0 : $karyawan->pemasukan[0]->total_pemasukan) - ($karyawan->pengeluaran->isEmpty() ? 0 : $karyawan->pengeluaran[0]->total_pengeluaran), 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Karyawan -->
            @foreach ($karyawans as $karyawan)
                <div class="modal fade p-0" id="karyawan-{{ $karyawan->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="karyawan-1Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-0 d-flex align-items-center">
                                <img src="{{ asset('img/app-logo.png') }}" alt="" width="40px">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ $karyawan->division->nama_divisi }}
                                </h5>
                                <button type="button" class="close align-self-baseline" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span>
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
                                                <li class="text-sm d-flex justify-content-between">Pemasukan:<span
                                                        class="text-sm ml-1"><b>Rp.
                                                            {{ number_format($karyawan->pemasukan->isEmpty() ? 0 : $karyawan->pemasukan[0]->total_pemasukan, 2, ',', '.') }}</b></span>
                                                </li>
                                                <li class="text-sm d-flex justify-content-between">Pengeluaran:<b>Rp.
                                                        {{ number_format($karyawan->pengeluaran->isEmpty() ? 0 : $karyawan->pengeluaran[0]->total_pengeluaran, 2, ',', '.') }}</b>
                                                </li>
                                                <li
                                                    class="text-sm d-flex justify-content-between {{ ($karyawan->pemasukan->isEmpty() ? 0 : $karyawan->pemasukan[0]->total_pemasukan) - ($karyawan->pengeluaran->isEmpty() ? 0 : $karyawan->pengeluaran[0]->total_pengeluaran) > 0 ? 'text-success' : 'text-danger' }}">
                                                    Saldo:<b>Rp.
                                                        {{ number_format(($karyawan->pemasukan->isEmpty() ? 0 : $karyawan->pemasukan[0]->total_pemasukan) - ($karyawan->pengeluaran->isEmpty() ? 0 : $karyawan->pengeluaran[0]->total_pengeluaran), 2, ',', '.') }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if ($karyawan->foto_profil == '' && file_exists(public_path('storage/' . Auth()->user()->foto_profil)))
                                                <img src="{{ asset('img/user-photo-default.png') }}" alt="user-avatar"
                                                    class="img-circle img-fluid" width="200px">
                                            @else
                                                <img src="{{ asset('storage/' . $karyawan->foto_profil) }}"
                                                    alt="user-avatar" class="img-circle img-fluid" width="200px">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-gradient p-3">
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
            var dataTableConfig = {
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4, 5, 6],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            };
            
            if (window.innerWidth <= 767) {
                dataTableConfig.scrollX = true;
            }

            $("#data-table-karyawan").DataTable(dataTableConfig);
        });
    </script>
@endsection
