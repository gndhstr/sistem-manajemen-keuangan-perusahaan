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
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .tabelModal {
            width: 100%;
        }        

        @media screen and (max-width: 700px) {
            .spinner-container {
                top: 75%;
            }
        }

        @media screen and (min-width: 701px) {
            .spinner-container {
                top: 45%;
            }
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
                        <li class="breadcrumb-item"><a href="{{ route('dashboardDirektur') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mutasi</li>
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
                {{-- Filter rentang waktu Card --}}
                <div class="card col-lg-6 mr-lg-5 mb-0">
                    <h3 class="card-title mt-3 ml-3">Rentang Waktu</h3>
                    <form method="get" action="{{ route('mutasiDirektur') }}" class="m-3">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="startDate">Start Date:</label>
                                <input type="date" name="startDate" id="startDate" class="form-control"
                                    value="{{ request('startDate') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="endDate">End Date:</label>
                                <input type="date" name="endDate" id="endDate" class="form-control"
                                    value="{{ request('endDate') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="d-block invisible">Filter</label>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- tabel divisi --}}
                <div class="card col-lg-6">
                    <div class="card-header border-0">
                        <h3 class="card-title">Divisi</h3>
                        <div class="card-tools">
                            {{-- tools --}}
                            {{-- <span class="badge badge-info">{{ date('F') }}</span> --}}
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
                            {{-- <span class="badge badge-info">{{ date('F') }}</span> --}}
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
                                    <th>Nominal</th>
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
                                            {{ date_format(date_create($riwayat->tanggal), 'd/m/Y') }}
                                            {{-- {{ $riwayat->created_at }} --}}
                                        </td>
                                        <td class="text-center">
                                            @if ($riwayat->jenis_transaksi == 'pemasukan')
                                                <button class="btn btn-primary btn-sm view-button"
                                                    data-url="{{ route('viewBukti', ['id_pemasukan' => $riwayat->id]) }}"
                                                    data-dismiss="modal" data-toggle="modal"
                                                    data-target="#viewPemasukanModal{{ $riwayat->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-sm view-button"
                                                    data-url="{{ route('viewBukti', ['id_pengeluaran' => $riwayat->id]) }}"
                                                    data-dismiss="modal" data-toggle="modal"
                                                    data-target="#viewPengeluaranModal{{ $riwayat->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal mutasi karyawan --}}
                @foreach ($users as $user)
                    <div class="modal fade" id="karyawan-{{ $user->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="karyawanModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="karyawanModalLabel">Mutasi Keuangan {{ $user->nama }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body pt-0">
                                        <div class="row d-flex justify-content-end mb-lg-2">
                                            <a href="{{ route('cetakMutasiKaryawanDirektur', ['startDate' => request('startDate'), 'endDate' => request('endDate'), 'id' => $user->id]) }}"
                                                class="btn btn-success mb-1 mt-0 align-self-baseline"
                                                role="button">Export PDF<i class="fa fa-file-pdf"></i></a>
                                        </div>
                                        <div class="d-lg-table width-100 tabelModal table-responsive">
                                            <table class="table table-hover mb-0" id="tabelModal">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Pemasukan</th>
                                                        <th class="text-center">Pengeluaran</th>
                                                        <th class="text-center">Catatan</th>
                                                        <th class="text-center">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        if (!$startDate && !$endDate) {
                                                            $startDate = $time->now()->startOfMonth();
                                                            $endDate = $time->now()->endOfMonth();
                                                        } elseif (!$endDate) {
                                                            $endDate = $time->now()->endOfMonth();
                                                        }

                                                        // dd($startDate);
                                                        $mutasis = $pemasukans
                                                            ->concat($pengeluarans)
                                                            ->where('id_user', $user->id)
                                                            ->sortByDesc(function ($mutasi) {
                                                                return isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran;
                                                            })
                                                            ->filter(function ($mutasi) use ($startDate, $endDate) {
                                                                $tgl_mutasi = isset($mutasi->tgl_pemasukan) ? $mutasi->tgl_pemasukan : $mutasi->tgl_pengeluaran;
                                                                return $tgl_mutasi >= $startDate && $tgl_mutasi <= $endDate;
                                                            });
                                                    @endphp
                                                    @forelse ($mutasis as $mutasi)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                                            <td class="text-center">
                                                                {{ isset($mutasi->tgl_pemasukan) ? (new DateTime($mutasi->tgl_pemasukan))->format('d/m/Y') : (new DateTime($mutasi->tgl_pengeluaran))->format('d/m/Y') }}
                                                            </td>
                                                            <td class="text-center">
                                                                <small class="text-success mr-1">
                                                                    <i class="fa fa-arrow-up"></i>
                                                                </small>
                                                                Rp.
                                                                {{ number_format(isset($mutasi->jml_masuk) ? floatval($mutasi->jml_masuk) : 0, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-center">
                                                                <small class="text-danger mr-1">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                </small>
                                                                Rp.
                                                                {{ number_format(isset($mutasi->jml_keluar) ? floatval($mutasi->jml_keluar) : 0, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-center">{{ $mutasi->catatan }}</td>
                                                            <td class="text-center">
                                                                @if ($mutasi->jml_keluar == '' || $mutasi->jml_keluar == null)
                                                                    <button class="btn btn-primary btn-sm view-button"
                                                                        data-url="{{ route('viewBukti', ['id_pemasukan' => $mutasi->id_pemasukan]) }}"
                                                                        data-toggle="modal"
                                                                        data-target="#viewPemasukanModal{{ $mutasi->id_pemasukan }}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-primary btn-sm view-button"
                                                                        data-url="{{ route('viewBukti', ['id_pengeluaran' => $mutasi->id_pengeluaran]) }}"
                                                                        data-toggle="modal"
                                                                        data-target="#viewPengeluaranModal{{ $mutasi->id_pengeluaran }}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No data available</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- modal lihat view pemasukan --}}
                @foreach ($pemasukans as $pemasukan)
                    <div class="modal fade" id="viewPemasukanModal{{ $pemasukan->id_pemasukan }}" tabindex="-1"
                        role="dialog" aria-labelledby="viewPemasukanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPemasukanModalLabel">Bukti Pemasukan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (file_exists(public_path('storage/bukti_pemasukan/' . $pemasukan->bukti_pemasukan)))
                                        <img src="{{ asset('storage/bukti_pemasukan/' . $pemasukan->bukti_pemasukan) }}"
                                            alt="Bukti Pemasukan" style="max-width: 100%;">
                                    @else
                                        <img src="{{ asset('img/user-photo-default.png') }}"
                                            class="img-circle elevation-2" alt="User Image">
                                    @endif
                                    {{-- <img src="{{ asset('storage/bukti_pemasukan/' . $pemasukan->bukti_pemasukan) }}"
                                        alt="Bukti Pemasukan" style="max-width: 100%;"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- modal lihat view pengeluaran --}}
                @foreach ($pengeluarans as $pengeluaran)
                    <div class="modal fade" id="viewPengeluaranModal{{ $pengeluaran->id_pengeluaran }}" tabindex="-1"
                        role="dialog" aria-labelledby="viewPengeluaranModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPengeluaranModalLabel">Bukti Pengeluaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (file_exists(public_path('storage/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran)))
                                        <img src="{{ asset('storage/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) }}"
                                            alt="Bukti Pengeluaran" style="max-width: 100%;">
                                    @else
                                        <img src="{{ asset('img/user-photo-default.png') }}"
                                            class="img-circle elevation-2" alt="User Image">
                                    @endif
                                    {{-- <img src="{{ asset('storage/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) }}"
                                        alt="Bukti Pengeluaran" style="max-width: 100%;"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('addJavascript')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // responsivitas 
    </script>
    <script>
        $(document).ready(function() {
            if (!startDate.value && !endDate.value) {
                endDate.value = @json($endDate);
                startDate.value = @json($startDate);
            }

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
                    url: 'mutasi/' + divisiId + '/data',
                    data: {
                        startDate: startDate.value,
                        endDate: endDate.value
                    },
                    success: function(data) {
                        // console.log(data.startDate, data.endDate);
                        // console.log(data);
                        $('#data-table-karyawan').show();
                        $('#data-table-karyawan').DataTable().destroy();

                        let num = 1;
                        let html = '';

                        data.users.forEach(user => {
                            let pemasukan = data.pemasukans
                                .filter(pemasukan => pemasukan.id_user === user.id &&
                                    pemasukan.tgl_pemasukan >= data.startDate &&
                                    pemasukan.tgl_pemasukan <= data.endDate)
                                .reduce((sum, pemasukan) => sum + pemasukan.jml_masuk,
                                    0);

                            let pengeluaran = data.pengeluarans
                                .filter(pengeluaran => pengeluaran.id_user === user
                                    .id &&
                                    pengeluaran.tgl_pengeluaran >= data.startDate &&
                                    pengeluaran.tgl_pengeluaran <= data.endDate)
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
                                    <tr data-toggle="modal" data-target="#karyawan-${user.id}" class="selected">
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
                                    </tr>
                                `;
                        });
                        $('#karyawan').html(html);

                        var dataTableKaryawanConfig = {
                            order: [
                                [0, 'asc']
                            ],
                            columnDefs: [{
                                orderable: false,
                                targets: [1, 2, 3],
                            }],
                            paging: true,
                            scrollCollapse: true,
                            scrollY: '350px',
                        };

                        if (window.innerWidth <= 767) {
                            dataTableKaryawanConfig.scrollX = true;
                        }

                        $("#data-table-karyawan").DataTable(dataTableKaryawanConfig);
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
            // Data table Divisi Config
            var dataTableDivisiConfig = {
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            };

            // Data table Karyawan Config
            var dataTableKaryawanConfig = {
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3],
                }],
                paging: true,
                scrollCollapse: true,
                scrollY: '350px',
            };

            var dataTableModalConfig = {                
                columnDefs: [{
                    orderable: false,
                    targets: [1, 2, 3, 4, 5],
                }],
            };

            //Responsivitas
            if (window.innerWidth <= 767) {
                dataTableDivisiConfig.scrollX = true;
                dataTableKaryawanConfig.scrollX = true;
                dataTableModalConfig.scrollX = true;
            }

            //Create Datatable
            $("#data-table-divisi").DataTable(dataTableDivisiConfig);
            $("#data-table-karyawan").DataTable(dataTableKaryawanConfig);
            $("#tabelModal").DataTable(dataTableModalConfig);
        });
    </script>
@endsection
