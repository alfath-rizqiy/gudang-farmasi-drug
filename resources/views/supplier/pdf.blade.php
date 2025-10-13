<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Supplier</title>
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
    <h2>Data Supplier</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $key => $supplier)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $supplier->nama_supplier ?? '-' }}</td>
                <td>{{ $supplier->telepon ?? '-' }}</td>
                <td>{{ $supplier->email ?? '-' }}</td>
                <td>{{ $supplier->alamat ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>