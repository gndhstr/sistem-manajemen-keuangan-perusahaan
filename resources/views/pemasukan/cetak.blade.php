<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA PEMASUKAN </title>
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
</head>

<body>
    <h3>DATA PEMASUKAN KARYAWAN</h3>
    <h3>PERIODE {{\Carbon\Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM Y') }} -
        {{ \Carbon\Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM Y') }} </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pemasukan</th>
                <th>Nama Kategori</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasukans as $pemasukan)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($pemasukan->tgl_pemasukan)->locale('id')->isoFormat('D MMMM Y') }}</td>
                <td>{{ $pemasukan->kategori->nama_kategori }}</td>
                <td>{{  "Rp ".number_format($pemasukan->jml_masuk, 0, ",", "." )  }}</td>
                <td>{{ $pemasukan->catatan }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Jumlah</td>
                <td>{{"Rp ".number_format($total, 0, ",", "." ) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
