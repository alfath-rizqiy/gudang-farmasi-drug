<!DOCTYPE html>
<html>
<head>
    <title>Data Obat</title>
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
            font-size: 5px;
        }

        .foto-obat {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Data Obat</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Supplier</th>
                <th>Kemasan</th>
                <th>Satuan Kecil</th>
                <th>Satuan Besar</th>
                <th>Aturan Pakai</th>
                <th>Kategori</th>
                <th>Tanggal Input</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $key => $obat)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->supplier->nama_supplier ?? '-' }}</td>
                <td>{{ $obat->kemasan->nama_kemasan ?? '-' }}</td>
                <td>{{ $obat->satuankecil->nama_satuankecil ?? '-' }}</td>
                <td>{{ $obat->satuanbesar->nama_satuanbesar ?? '-' }}</td>
                <td>{{ $obat->aturanpakai->frekuensi_pemakaian ?? '-' }}</td>
                <td>{{ $obat->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $obat->created_at->format('d F Y') }}</td>
                <td>
                    @if($obat->foto)
                        <img src="{{ public_path('storage/' . $obat->foto) }}" class="foto-obat">
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
