<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                My Account
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Change Password</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Logout</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Security
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User Access</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{url("master/satuan")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Satuan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/barang")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/gudang")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gudang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/departemen")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Departemen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/konsumen")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Konsumen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/akun")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Master Akun</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("master/bank")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Master Bank</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{url("transaksi/barang-masuk")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang Masuk</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("transaksi/barang-keluar")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang Keluar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pencatatan Harian</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Laporan Arus Barang
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{url("laporan/saldo-barang")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Saldo Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url("laporan/arus-barang")}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Arus Barang</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
                Jurnal
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Piutang</p>
                </a>
            </li>
        </ul>
    </li>

</ul>