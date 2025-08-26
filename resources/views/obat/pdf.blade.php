<!DOCTYPE html>
<html>
<head>
    <title>Data Obat</title>
</head>
<body>
    <h2>Data Obat</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Supllier</th>
                <th>Kemasan</th>
                <th>Satuan Kecil</th>
                <th>Satuan Besar</th>
                <th>Aturan Pakai</th>
                <th>Kategori</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Input</th>
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
                <td>{{ $obat->metodepembayaran->nama_metode ?? '-' }}</td>
                <td>{{ $obat->created_at->format('d F Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
