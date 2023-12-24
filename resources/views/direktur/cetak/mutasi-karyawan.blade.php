<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Karyawan</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/cetak-pdf.css') }}"> -->
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
</head>

<body>
    <h3>MUTASI KARYAWAN {{ $user->nama }} <br>BULAN {{ strtoupper(\Carbon\Carbon::parse($startDate)->formatLocalized('%B')) }} -
        {{ strtoupper(\Carbon\Carbon::parse($endDate)->formatLocalized('%B')) }} <br>{{ date('Y') }}</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Mutasi</th>
                <th>Jenis</th>
                <th>Nama Kategori</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mutasiPemasukanPengeluaran as $mutasi)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $mutasi->tanggal }}</td>
                    <td>{{ $mutasi->jenis_transaksi }}</td>
                    <td>{{ $mutasi->kategori->nama_kategori }}</td>
                    <td>{{ $mutasi->jumlah }}</td>
                    <td>{{ $mutasi->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
