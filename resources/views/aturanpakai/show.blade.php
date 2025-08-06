@extends('layouts.admin')

@section('title', 'Detail Aturan Pakai')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Aturan Pakai</h1>
    <!-- Judul utama halaman detail -->

    <div class="card shadow mb-4">
    
        <div class="card-body">

            <h5 class="font-weight-bold mb-3">Informasi Aturan Pakai</h5>
            <p><strong>Frekuensi Pemakaian:</strong> {{ $aturanpakai->frekuensi_pemakaian }}</p>
            <p><strong>Waktu Pemakaian:</strong> {{ $aturanpakai->waktu_pemakaian }}</p>
            <p><strong>Deskripsi:</strong> {{ $aturanpakai->deskripsi }}</p>

            <hr>

            <h5 class="font-weight-bold mt-4 mb-3">Aturan Pakai Obat</h5>

            @if($aturanpakai->obats->isEmpty())
                <p>Tidak ada aturan pakai obat.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aturanpakai->obats as $index => $obat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

             {{-- Tombol untuk kembali ke halaman index aturan pakai --}}
            <a href="{{ route('aturanpakai.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

</div>
@endsection
