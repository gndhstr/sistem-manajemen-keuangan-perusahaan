@extends('direktur.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
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
                    <table id="data-table-karyawan" class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th class="col-2">nomor telepon</th>
                                <th>keuangan</th>
                                <th>saldo</th>
                                <th>Lihat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $karyawan)
                                <tr>
                                    <td>{{ $karyawan->nama }}</td>
                                    <td>{{ $karyawan->division->nama_divisi }}</td>
                                    <td>{{ $karyawan->nomor_telepon }}</td>
                                    <td class="row">
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
                                    <td></td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


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
                    [3]
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [5],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });
        });
    </script>
@endsection
