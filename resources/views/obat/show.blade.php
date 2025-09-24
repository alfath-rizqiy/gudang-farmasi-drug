@extends('layouts.admin')

@section('title', 'Info Obat')

@section('content')

<style>
     
    .harga-tanggal {
        font-size: 10px;   /* kecil abu-abu */
        color: #6c757d;
        margin-bottom: 1px;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Informasi Obat</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
     <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-60 py-2">
                                <div class="card-body py-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Harga (Baru)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->hargaTerbaru->harga_jual ?? '-' }}</div>
                                             <p class="harga-tanggal">{{ $obat->hargaTerbaru?->updated_at?->setTimezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-60 py-2">
                                <div class="card-body py-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Harga (Lama)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->hargaLama->harga_jual ?? '-'}}</div>
                                            <p class="harga-tanggal">{{ $obat->hargaLama?->updated_at?->setTimezone('Asia/Jakarta')->format('d M Y H:i') ?? '-' }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-60 py-2">
                                <div class="card-body py-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 py-1">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Riwayat Harga
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownRiwayat" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Lihat Riwayat
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownRiwayat">
                                                        @forelse($obat->hargas as $harga)
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                Rp{{ number_format($harga->harga_jual) }} 
                                                                <br>
                                                                <small class="text-muted">
                                                                    {{ $harga->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}
                                                                </small>
                                                            </a>
                                                        </li>
                                                        @empty
                                                        <li><span class="dropdown-item text-muted">Tidak ada riwayat harga</span></li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-60 py-2">
                                <div class="card-body py-2">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Stok</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat->stok }}</div>
                                            <p class="harga-tanggal">{{ $obat->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-box fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Grafik Obat</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div>
                                        <p><strong>Obat:</strong> {{ $obat->nama_obat }}</p>
                                        <p><strong>Supplier:</strong> {{ $obat->supplier->nama_supplier ?? '-'}}  <br>{{ $obat->supplier->telepon ?? '-'}}, {{ $obat->supplier->alamat ?? '-'}}, {{ $obat->supplier->email ?? '-'}}.</p>
                                        <p><strong>Kategori:</strong> {{ $obat->kategori->nama_kategori ?? '-'}}  <br>{{ $obat->kategori->deskripsi ?? '-'}}.</p>
                                        <p><strong>Kemasan:</strong> {{ $obat->kemasan->nama_kemasan ?? '-'}}  <br>{{ $obat->kemasan->petunjuk_penyimpanan ?? '-'}} .</p>
                                        <p><strong>Satuan:</strong> {{ $obat->satuanKecil->nama_satuankecil ?? '-'}}, {{ $obat->satuanBesar->nama_satuanbesar ?? '-'}}  <br>{{ $obat->satuanKecil->deskripsi ?? '-'}}.</p>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!-- Foto Obat -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Keterangan Obat</h6>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <!-- Kolom Foto -->
            <div class="col-md-5 text-center mb-3 mb-md-0">
                <img id="fotoPreview"
                     src="{{ $obat->foto ? asset('storage/' . $obat->foto) : asset('storage/default.png') }}"
                     class="img-fluid rounded shadow"
                     alt="Foto Obat">
            </div>

            <!-- Kolom Keterangan -->
            <div class="col-md-7">
                <p><strong>{{ $obat->nama_obat }}</strong> 
           {{ $obat->deskripsi_obat}}.</p>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
            datasets: [{
                label: 'Penjualan',
                data: [12, 19, 3, 5, 8],
                fill: true, // bikin jadi area
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

             {{-- Tombol untuk kembali ke halaman index aturan pakai --}}
            <a href="{{ route('obat.index') }}" class="btn btn-sm btn-secondary mt-1 mb-10">Kembali</a>


</div>
@endsection
