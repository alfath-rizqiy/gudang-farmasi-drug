<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Satuan Kecil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 6px;
            margin: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #444;
            padding: 4px 5px;
            text-align: center;
            vertical-align: middle;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            font-weight: bold;
            font-size: 12px;
        }

        td {
            font-size: 10px;
        }


    </style>
</head>
<body>
    <h2>Data Satuan Kecil</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Satuan Kecil</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($satuankecils as $key => $satuankecil)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $satuankecil->nama_satuankecil ?? '-' }}</td>
                <td>{{ $satuankecil->deskripsi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>