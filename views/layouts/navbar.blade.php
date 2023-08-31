<!-- ======= Navbar ======= -->
<div class="pb-3">
  <div class="container-fluid ">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light p-0">
      <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{ url('/') }}">
          <div style="float:left">
            <img src="{{ asset('assets/img/logo_bappenas.png') }}" width="20" style="margin-top: -25px;">&nbsp;&nbsp;
            <span style="display: inline-block;padding-left: 5px;">
                <b class="font-weight-bold" style="display: block;">DATA MIKRO</b>
                <small style="display: block;font-size: 12px;color: #a3a3a3;">Perencanaan Pembangunan</small>
            </span>
          </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav ml-auto">
            <form class="form-inline" action="{{ url('data/search') }}" method="get">
              <div class="input-group">
                <input type="text" name="name" placeholder="Cari data" class="form-control" style="border-top-left-radius: 1.5rem;border-bottom-left-radius: 1.5rem;">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="submit" style="border-top-right-radius: 1.5rem;border-bottom-right-radius: 1.5rem;">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <li class="nav-item active2">
              <a class="nav-link" href="{{ url('/') }}">Beranda</a>
            </li>            
            @if(Laratrust::hasRole('superadmin') || Laratrust::hasRole('operator'))
              {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('datadasar') }}">Data Mikro</a>
              </li> --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Master Data
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ url('datadasar') }}">Data Mikro</a></li>
                  <li><a class="dropdown-item" href="{{ url('source') }}">Sumber Data</a></li>
                  {{-- <li><a class="dropdown-item" href="{{ url('category/add') }}">Input Kategori</a></li> --}}
                  {{-- <li><a class="dropdown-item" href="{{ url('uke') }}">Unit Kerja</a></li> --}}
                </ul>
              </li>
              @if(Laratrust::hasRole('superadmin'))
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  ACL
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  {{-- <li><a href="{{ url('rule') }}" class="dropdown-item">Rules</a></li> --}}
                  <li><a href="{{ url('role') }}" class="dropdown-item">Roles</a></li>
                  <li><a href="{{ url('resource') }}" class="dropdown-item">Resources</a></li>
                  <li><a href="{{ url('user') }}" class="dropdown-item">User</a></li>
                </ul>
              </li>
              @endif
            @endif
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Permintaan
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Permintaan Data Tersedia</a>
                  <ul class="dropdown-menu mr-custom">
                    <li><a class="dropdown-item" href="{{ url('riwayat') }}">Riwayat</a></li>
		                @if(Laratrust::hasRole('superadmin') || Laratrust::hasRole('operator'))
                    <li><a class="dropdown-item" href="{{ url('listtersedia') }}">Daftar Permintaan Tersedia</a></li>
                    {{-- <li><a class="dropdown-item" href="{{ url('link') }}">Expired Download Link</a></li> --}}
                    @endif
                  </ul>
                </li>
                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Permintaan Data Belum Tersedia</a>
                  <ul class="dropdown-menu mr-custom">
                    <li><a class="dropdown-item" href="{{ url('riwayatother') }}">Riwayat</a></li>
                    @if(Laratrust::hasRole('superadmin') || Laratrust::hasRole('operator'))
                    <li><a class="dropdown-item" href="{{ url('listblmtersedia') }}">Daftar Permintaan Belum Tersedia</a></li>
                    @endif
                  </ul>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Laporan
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                @if(Laratrust::hasRole('superadmin') || Laratrust::hasRole('operator'))
                <li><a class="dropdown-item" href="{{ url('laporanuser') }}">Laporan (per User)</a></li>
                <li><a class="dropdown-item" href="{{ url('laporandata') }}">Laporan (per Data Mikro)</a></li>
                {{-- <li><a href="{{ url('logdata') }}" class="dropdown-item">Statistik Data</a></li> --}}
                @endif
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('track') }}">
                <img src="{{ asset('assets/img/buy.png') }}" alt="" height="20">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="margin-left: -0.20%;" id="cart">
                  {{ $count_cart }}
                </span>
              </a>
            </li>
            @if(Laratrust::hasRole('superadmin') || Laratrust::hasRole('operator'))
            <li class="nav-item">
              <a class="nav-link" href="{{ url('listtersedia') }}">
                <img src="{{ asset('assets/img/bell.gif') }}" alt="" height="20">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" style="margin-left: -0.35%;">
                  {{ $notif }}
                </span>
              </a>
            </li>
            @endif
            <li class="nav-item dropdown">
              
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="tooltip2" id="tooltip2">
                    @if(session()->get('userdata')['avatar']!=null)
                      <img src="https://akun.bappenas.go.id/bp-um/avatar/{{ session()->get('userdata')['avatar'] }}" alt="" height="20"> {{ session()->get('userdata')['nama'] }}
                    @else
                      <i class="fa fa-user" style="font-size: 0.95rem"></i> {{ session()->get('userdata')['nama'] }}
                    @endif
                  <span class="tooltiptext2 mt-3">Login as {{ $user_role->display_name }}</span>
                  </div>
                </a>
                
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if(Laratrust::hasRole('superadmin'))
                  <li><a href="{{ url('email') }}" class="dropdown-item">Assign Email</a></li>
                  <li><a href="{{ url('log') }}" class="dropdown-item">Activity log</a></li>
                @endif
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>
<!-- End Navbar -->