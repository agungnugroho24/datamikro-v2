<!-- View template master -->
@extends('layouts.index') 

<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Kategori</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form class="form-inline mb-5">
        <div class="input-group">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
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
          <div class="col-sm-2">
            <label for="description">Description</label>
          </div>
          <div class="col-sm-10">
            <textarea class="form-control" id="description"></textarea>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="uke" class="col-sm-2">Parent</label>
          <div class="col-sm-10">
            <select class="form-control" id="uke">
              <option>(Data dasar)</option>
              <option>data 1</option>
              <option>data 2</option>
              <option>data 3</option>
              <option>data 4</option>
            </select>
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
        <div class="bd-example">
          <button type="button" class="btn btn-primary btn-sm">Simpan</button>
          <a href="{{ url('user') }}">
            <button type="button" class="btn btn-secondary btn-sm">Batal</button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">

  </script>
@endpush