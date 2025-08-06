<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon mx-3">
            <i class="fas fa-warehouse"></i>
        </div>
        <div class="sidebar-brand-text mx-2">Gudang Farmasi</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('obat*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseObat" aria-expanded="true" aria-controls="collapseObat">
        <i class="fas fa-fw fa-capsules"></i>
        <span>Master Data</span>
    </a>
    <div id="collapseObat" class="collapse {{ request()->is('obat*') ? 'show' : '' }}" aria-labelledby="headingObat" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Master Menu</h6>
            <a class="collapse-item {{ request()->is('obat') ? 'active' : '' }}" href="{{ route('obat.index') }}">Obat</a>
            <a class="collapse-item {{ request()->is('supplier') ? 'active' : '' }}" href="{{ route('supplier.index') }}">Supplier</a>
            <a class="collapse-item {{ request()->is('kategori') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
            <a class="collapse-item {{ request()->is('metodepembayaran') ? 'active' : '' }}" href="{{ route('metodepembayaran.index') }}">Metode Pembayaran</a>
        </div>
    </div>
</li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin ingin keluar dari aplikasi?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>


</ul>
