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
                    <h1 class="m-0 text-dark">Mutasi Keuangan Perusahaan</h1>
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
                {{-- tabel divisi --}}
                <div class="card col-lg-5">
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
                                    <th>Karyawan</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisis as $divisi)
                                    <tr class="">
                                        <td>
                                            {{ $divisi->nama_divisi }}
                                        </td>
                                        <td class="text-center">
                                            {{ $divisi->users_count }}
                                        </td>
                                        <td>
                                            <small class="text-success mr-1">
                                                <i class="fa fa-arrow-up"></i>
                                            </small>
                                            Rp.
                                            {{ number_format($divisi->pemasukans->sum('total_pemasukan'), 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <small class="text-danger mr-1">
                                                <i class="fa fa-arrow-down"></i>
                                            </small>
                                            Rp.
                                            {{ number_format($divisi->pengeluarans->sum('total_pengeluaran'), 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-muted show-divisi"
                                                data-id="{{ $divisi->id_divisi }}">
                                                <i class="fa fa-eye button-eye" id="eye{{ $divisi->id_divisi }}"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- tabel karyawan --}}
                <div class="card ml-lg-3 col-lg-6">
                    <div class="card-header border-0">
                        <h3 class="card-title">Karyawan</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="data-table-karyawan" class="table table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody id="karyawan">
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- tabel riwayat --}}
                <div class="card ml-lg-3">
                    <div class="card-header border-0">
                        <h3 class="card-title">Mutasi Terakhir</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="" class="table table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Karyawan</th>
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
        $(document).ready(function() {
            $('.show-divisi').click(function(e) {
                e.preventDefault();
                $('.button-eye').removeClass('text-primary');

                var divisiId = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: 'cashflow/' + divisiId + '/data',
                    success: function(data) {
                        console.log(data);
                        $('#data-table-karyawan').DataTable().destroy();

                        $('#eye' + divisiId).addClass('text-primary');

                        let html = '';
                        data.users.forEach(users => {
                            html += `
                                    <tr>
                                        <td>${users.nama}</td>
                                        <td>tampilkan total pemasukan berdasarkan ${users.id}</td>
                                        <td>tampilkan total pengeluaran berdasarkan${users.id}</td>
                                        <td>
                                            <a href="#" class="text-muted show-divisi">
                                                <i class="fa fa-eye button-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                        });
                        $('#karyawan').html(html);


                        // $('#data-table-karyawan').empty();

                        $("#data-table-karyawan").DataTable({
                            order: [
                                [3]
                            ],
                            columnDefs: [{
                                orderable: false,
                                targets: [0, 1, 2, 3],
                            }],
                            paging: true,
                            scrollCollapse: true,
                            scrollY: '350px',
                        });
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
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
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });

            $("#data-table-karyawan").DataTable({
                order: [
                    [3]
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [0, 1, 2, 3],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });
        });
    </script>
@endsection
