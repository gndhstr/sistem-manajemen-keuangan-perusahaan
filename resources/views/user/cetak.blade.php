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
    <h3>DAFTAR PEGAWAI <br> TAHUN 2023</h3>
    <table>
        <thead>
            <tr>
                <th >No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Divisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->role_user ? $user->role_user->role : "-" }}</td>
                    <td>{{ $user->division ? $user->division->nama_divisi : "-" }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
