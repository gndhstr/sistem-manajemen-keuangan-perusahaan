@extends('direktur.layouts.master')

@section('addCss')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <style>
        .table-primary>td {
            background-color: #c3e5ff !important;
            cursor: default;
        }

        .selected:hover {
            cursor: pointer;
            background-color: #c3e5ff;
        }

        .spinner-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
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
                <div class="card col-lg-6">
                    <div class="card-header border-0">
                        <h3 class="card-title">Divisi</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                            <span class="badge badge-info">{{ date('F') }}</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="data-table-divisi" class="table table-valign-middle">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-1">No.</th>
                                    <th>Divisi</th>
                                    <th>Total Karyawan</th>
                                    <th>Total Pemasukan</th>
                                    <th>Total Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisis as $divisi)
                                    <tr id="row-selected-{{ $divisi->id_divisi }}" class="show-divisi selected"
                                        data-id="{{ $divisi->id_divisi }}">
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ $divisi->nama_divisi }}
                                        </td>
                                        <td class="text-center">
                                            {{ $divisi->users_count }}
                                        </td>
                                        <td class="text-right">
                                            <small class="text-success mr-1">
                                                <i class="fa fa-arrow-up"></i>
                                            </small>
                                            Rp.
                                            {{ number_format($divisi->pemasukans->sum('total_pemasukan'), 2, ',', '.') }}
                                        </td>
                                        <td class="text-right">
                                            <small class="text-danger mr-1">
                                                <i class="fa fa-arrow-down"></i>
                                            </small>
                                            Rp.
                                            {{ number_format($divisi->pengeluarans->sum('total_pengeluaran'), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- tabel karyawan --}}
                <div class="card col-lg-6">
                    <div class="card-header border-0">
                        <h3 class="card-title">Karyawan</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                            <span class="badge badge-info">{{ date('F') }}</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive position-relative">
                        <div class="d-flex justify-content-center align-items-center spinner-container">
                            <div class="spinner-border text-primary" role="status" id="spinner-karyawan">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table id="data-table-karyawan" class="table table-valign-middle table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th class="col-1">No.</th>
                                    <th>Nama</th>
                                    <th>Total Pemasukan</th>
                                    <th>Total Pengeluaran</th>
                                    <th>Lihat</th>
                                </tr>
                            </thead>
                            <tbody id="karyawan">
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- tabel Mutasi Terakhir --}}
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Mutasi Terakhir</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="" class="table table-valign-middle table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Karyawan</th>
                                    <th>Divisi</th>
                                    <th>Kategori</th>
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
                                        <td>
                                            {{ $riwayat->user->division->nama_divisi }}
                                        </td>
                                        <td>
                                            {{ $riwayat->kategori->nama_kategori }}
                                        </td>
                                        <td>
                                            <small
                                                class="{{ $riwayat->jenis_transaksi == 'pemasukan' ? 'text-success' : 'text-danger' }} mr-1">
                                                <i
                                                    class="fa {{ $riwayat->jenis_transaksi == 'pemasukan' ? 'fa-arrow-up' : 'fa-arrow-down' }} "></i>
                                            </small>
                                            Rp. {{ number_format($riwayat->jumlah, 2, ',', '.') }}
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
            $('#spinner-karyawan').hide();

            $('.show-divisi').click(function(e) {
                e.preventDefault();
                $('#data-table-karyawan').hide();

                $('#spinner-karyawan').show();

                $('.selected').removeClass('table-primary');

                var divisiId = $(this).data('id');

                $('#row-selected-' + divisiId).addClass('table-primary');

                $.ajax({
                    type: 'GET',
                    url: 'cashflow/' + divisiId + '/data',
                    success: function(data) {
                        // console.log(data);
                        $('#data-table-karyawan').show();
                        $('#data-table-karyawan').DataTable().destroy();

                        let num = 1;
                        let html = '';

                        data.users.forEach(user => {
                            let pemasukan = data.pemasukans
                                .filter(pemasukan => pemasukan.id_user === user.id)
                                .reduce((sum, pemasukan) => sum + pemasukan.jml_masuk,
                                    0);

                            let pengeluaran = data.pengeluarans
                                .filter(pengeluaran => pengeluaran.id_user === user.id)
                                .reduce((sum, pengeluaran) => sum + pengeluaran
                                    .jml_keluar, 0);

                            pemasukan = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(pemasukan);

                            pengeluaran = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(pengeluaran);

                            html += `
                                    <tr>
                                        <td class="text-center">${num++}</td>
                                        <td>${user.nama}</td>
                                        <td class="text-right">
                                            <small class="text-success mr-1">
                                                <i class="fa fa-arrow-up"></i>
                                            </small>
                                            ${pemasukan}
                                        </td>
                                        <td class="text-right">
                                            <small class="text-danger mr-1">
                                                <i class="fa fa-arrow-down"></i>
                                            </small>
                                            ${pengeluaran}
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-muted show-divisi">
                                                <i class="fa fa-eye button-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                        });
                        $('#karyawan').html(html);

                        $("#data-table-karyawan").DataTable({
                            order: [
                                [0, 'asc']
                            ],
                            columnDefs: [{
                                orderable: false,
                                targets: [1, 2, 3, 4],
                            }],
                            paging: true,
                            scrollCollapse: true,
                            scrollY: '350px',
                        });
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    },
                    complete: function() {
                        $('#spinner-karyawan').hide();
                    },
                });
            });
        });
    </script>
    <script>
        $(function() {
            $("#data-table-divisi").DataTable({
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });

            $("#data-table-karyawan").DataTable({
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            });
        });
    </script>
@endsection
