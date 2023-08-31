<!-- View template master -->
@extends('layouts.index') 

@section('banner')
{{-- this section will be empty --}}
@stop

@include('layouts.bannerfake')
 
<!-- Konten -->
@section('konten')
 
  <!-- ======= Datamikro Section ======= -->
  <section id="datamikro" class="about">
    <div class="container">

      <div class="row no-gutters">
        <h3 data-aos="fade-up">User</h3>
        <hr>
        <br><br><br>
        <h4 data-aos="fade-up">LDAP</h4>
        <form class="form-inline mb-5">
          <div class="input-group">
            <label for="nama" class="col-sm-2 col-form-label">LDAP Username</label>
            <div class="custom-file" style="margin-left: 0.2%;">
              <input type="text" class="form-control" id="uid" placeholder="Enter LDAP username">
            </div>
            <div class="input-group-append">
               <button class="btn btn-outline-primary" type="button">Cari</button>
            </div>
          </div>
        </form>
        <h4 data-aos="fade-up">Akun</h4>
        <form>
            <div class="form-group row mb-3">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" placeholder="Nama">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="slug" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="uid" placeholder="Username">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="Abbreviation" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group row mb-3">
              <label for="uke" class="col-sm-2">Unit kerja</label>
              <div class="col-sm-10">
                <select class="form-control" id="uke">
                  <option>(Pilih unit kerja)</option>
                  <option>uke 1</option>
                  <option>uke 2</option>
                  <option>uke 3</option>
                  <option>uke 4</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label for="role" class="col-sm-2">Role</label>
              <div class="col-sm-10">
                <select class="form-control" id="role">
                  <option>(Kosong)</option>
                  <option>User Direktorat</option>
                  <option>Admin Layanan</option>
                  <option>Super Admin</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label for="docs" class="col-sm-2">Docs Access</label>
              <div class="col-sm-10">
                <select class="form-control" id="docs">
                  <option>Standard</option>
                  <option>Full Access</option>
                </select>
              </div>
            </div>
            <div class="bd-example">
                <button type="button" class="btn btn-primary btn-sm">Simpan</button>
                <a href="{{ url('user') }}">
                  <button type="button" class="btn btn-secondary btn-sm">Batal</button>
                </a>
            </div>
        </form>
      </div>

    </div>
  </section>
  <!-- End Datamikro Section -->
@endsection

@push('scripts')
  <script type="text/javascript">

  </script>
@endpush