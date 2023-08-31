
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- <h1 class="logo"><a href="index.html"></a></h1> -->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="{{ url('/') }}">Beranda</a></li>
          <li><a class="nav-link scrollto" href="{{ url('datadasar') }}">Data Dasar</a></li>
          <li class="dropdown"><a href="#"><span>Master</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('source') }}">Sumber</a></li>
              <li><a href="{{ url('kategori') }}">Input Kategori</a></li>
              <li><a href="{{ url('uke') }}">Unit Kerja</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="javascript:void(0)"><span>ACL</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('user') }}">User</a></li>
              <li><a href="{{ url('rule') }}">Rules</a></li>
              <li><a href="{{ url('role') }}">Roles</a></li>
              <li><a href="{{ url('resource') }}">Resources</a></li>
              <li><a href="{{ url('log') }}">Log Sistem</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="javascript:void(0)"><span>Permintaan</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li class="dropdown"><a href="#"><span>Permintaan Data Tersedia</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="{{ url('riwayat') }}">Riwayat</a></li>
                  <li><a href="{{ url('listtersedia') }}">Daftar Permintaan Data Tersedia</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="javascript:void(0)"><span>Permintaan Data Belum Tersedia</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="{{ url('listblmtersedia') }}">Daftar Permintaan Data Belum Tersedia</a></li>
                </ul>
              </li>
              <li><a href="{{ url('laporanuser') }}">Laporan Permintaan Data (per User)</a></li>
              <li><a href="{{ url('laporandata') }}">Laporan Permintaan Data (per Data Mikro)</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <div id="cari1">
        <div class="cari1">
          <form>
            <input type="email" name="email"><input type="submit" value="Search">
          </form>
        </div>
      </div>

    </div>
  </header><!-- End Header -->