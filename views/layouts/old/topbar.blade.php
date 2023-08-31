<!-- ======= Top Bar Desktop ======= -->
<section id="topbar" class="">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="contact-info d-flex align-items-center">
          <img src="{{ asset('assets/img/logoppn.png') }}" id="bnr1" class="img-fluid" height="80" width="180">
          <img src="{{ asset('assets/img/logo.png') }}" id="bnr2" class="img-fluid mt-2" height="20" width="40">
        </div>
      </div>
      <div class="col mt-3">
        <div class="d-flex flex-row-reverse bd-highlight">
          <div class="p-2 bd-highlight">
            <a class="dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false">
              @if(session()->get('userdata')['avatar']!=null)
                <img src="https://akun.bappenas.go.id/bp-um/avatar/{{ session()->get('userdata')['avatar'] }}" alt="" height="30"> {{ session()->get('userdata')['nama'] }}
              @else
                <img src="assets/img/user.png" alt="" height="30"> {{ session()->get('userdata')['nama'] }}
              @endif
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
              <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </div>
          <div class="p-2 bd-highlight">
            <div class="dropdown">
              <a class="text-dark" href="{{ url('listtersedia') }}" role="button" aria-expanded="false">
                <img src="{{ asset('assets/img/notif.png') }}" alt="" height="30">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  9
                  <span class="visually-hidden">unread messages</span>
                </span>
              </a>
            </div>
          </div>
          <div class="p-2 bd-highlight">
            <div class="dropdown">
              <a class="text-dark" href="{{ url('listtersedia') }}" role="button" aria-expanded="false">
                <img src="{{ asset('assets/img/cart.png') }}" alt="" height="30">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  3
                  <span class="visually-hidden">unread messages</span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ======= End Top Bar Desktop ======= -->