{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Selamat datang di Dashboard</h1>
    </div>

        @role('admin')
            <!-- Admin -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Dashboard Admin</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="template/img/undraw_logistics_xpdj.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="{{ route('obat.index') }}/">DataObat</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="{{ route('obat.create') }}">Tambahkan Data &rarr;</a>
                                </div>
                            </div>
        @endrole

        @role('petugas')
                        <!-- Admin -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Dashboard Petugas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="template/img/undraw_logistics_xpdj.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="{{ route('obat.index') }}/">DataObat</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="{{ route('obat.create') }}">Tambahkan Data &rarr;</a>
                                </div>
                            </div>
        @endrole

        @unlessrole('admin|petugas')
            <p>Role kamu belum dikenali oleh sistem.</p>
        @endunlessrole 
        
@endsection
