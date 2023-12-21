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

        th, td {
            border: 1px solid #dddddd ;
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
    <h3>DATA PEMASUKAN KARYAWAN 
        <br>
        BULAN  {{ strtoupper(\Carbon\Carbon::parse($startDate)->translatedFormat('F')) }} -  {{ strtoupper(\Carbon\Carbon::parse($endDate)->translatedFormat('F')) }} 
        <br>
        2023
    </h3>

        
    <table>
        <thead>
            <tr>
                <th >No</th>
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
                    <td>{{ $pemasukan->tgl_pemasukan }}</td>
                    <td>{{ $pemasukan->kategori->nama_kategori }}</td>
                    <td>{{ $pemasukan->jml_masuk }}</td>
                    <td>{{ $pemasukan->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
