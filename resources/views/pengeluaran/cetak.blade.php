<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai</title>
    <!-- <link rel="stylesheet" href="{{asset('css/cetak-pdf.css')}}"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(function() {
            // Format Rupiah
            $('.rupiah').mask('000.000.000.000', {
                reverse: true
            });
        });
    </script>
</head>

<body>
    <h3>DATA PENGELUARAN KARYAWAN <br>BULAN {{ strtoupper(\Carbon\Carbon::parse($startDate)->formatLocalized('%B')) }} - {{ strtoupper(\Carbon\Carbon::parse($endDate)->formatLocalized('%B')) }} <br>2023</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengeluaran</th>
                <th>Nama Kategori</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluarans as $pengeluaran)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tgl_pengeluaran)->format('d/m/Y') }}</td>
                    <td>{{ $pengeluaran->kategori->nama_kategori }}</td>
                    <td class="rupiah">{{ formatRupiah($pengeluaran->jml_keluar) }}</td>
                    <td>{{ $pengeluaran->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(function () {
            // Format Rupiah
            $('.rupiah').mask('000.000.000.000', {reverse: true});
        });
    </script>
</body>
</html>

@php
function formatRupiah($angka){
    $rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $rupiah;
}
@endphp