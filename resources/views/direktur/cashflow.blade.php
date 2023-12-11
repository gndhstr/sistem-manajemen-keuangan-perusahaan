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
                    <h1 class="m-0 text-dark">Cashflow</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">cashflow</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- main content here --}}
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Divisi</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="data-table-divisi" class="table table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Divisi</th>
                                    <th>Jumlah Karyawan</th>
                                    <th class="width-100">Pemasukan</th>
                                    <th class="width-100">Pengeluaran</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisis as $divisi)
                                    <tr>
                                        <td>
                                            {{ $divisi->nama_divisi }}
                                        </td>
                                        <td class="text-center">
                                            {{ $divisi->division }}
                                        </td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fa fa-arrow-up"></i>
                                            </small>
                                            Rp. 300.000
                                        </td>
                                        <td>
                                            <small class="text-danger mr-1">
                                                <i class="fa fa-arrow-down"></i>
                                            </small>
                                            Rp. 100.000
                                        </td>
                                        <td class="text-center">
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
                <div class="card ml-lg-3">
                    <div class="card-header border-0">
                        <h3 class="card-title">Riwayat</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="data-table-karyawan" class="table table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    {{-- <th>Divisi</th>
                                    <th>Kategori</th> --}}
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatPemasukanPengeluaran as $riwayat)
                                    <tr>
                                        <td>
                                            {{ $riwayat->user->nama }}
                                        </td>
                                        {{-- <td>
                                            {{ $riwayat->user->division->nama_divisi }}
                                        </td>
                                        <td>
                                            {{ $riwayat->kategori->nama_kategori }}
                                        </td> --}}
                                        <td>
                                            <small
                                                class="{{ $riwayat->jenis_transaksi == 'pemasukan' ? 'text-success' : 'text-danger' }} mr-1">
                                                <i
                                                    class="fa {{ $riwayat->jenis_transaksi == 'pemasukan' ? 'fa-arrow-up' : 'fa-arrow-down' }} "></i>
                                            </small>
                                            Rp. {{ number_format($riwayat->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ date_format(date_create($riwayat->created_at), 'd/m/Y') }}
                                            {{-- {{ $riwayat->created_at }} --}}
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-muted">
                                                <i class="fa fa-file-text"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
            $("#data-table-divisi").DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: [0, 1, 2, 3, 4],
                }],
                order: [
                    [4]
                ],
            });
            // $("#data-table-karyawan").DataTable({
            //     order: [
            //         [3]
            //     ],
            //     columnDefs: [{
            //         orderable: false,
            //         targets: [0, 1, 2, 3],
            //     }],
            //     bPaginate : false,
            //     info: false,
            //     scrollCollapse: false,
            // });
        });
    </script>
    <script></script>
@endsection
