<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Formulir Pengajuan Data Mikro Baru</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form action="" method="">
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Nama Data</label>
          <div class="col-sm-10">
            <input name="nama" type="text" id="inputData" placeholder="Nama Data" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Tahun</label>
          <div class="col-sm-10">
            <input name="tahun" type="text" id="inputTahun" placeholder="Tahun" class="form-control" maxlength="4" onkeypress="return hanyaAngka(event)" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Cakupan Wilayah</label>
          <div class="col-sm-10">
            <input name="cakupan" type="text" id="inputCakupan" placeholder="Cakupan Wilayah" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Latar Belakang</label>
          <div class="col-sm-10">
            <input name="latarbelakang" type="text" id="inputLatarBelakang" placeholder="Latar Belakang" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Tujuan</label>
          <div class="col-sm-10">
            <input name="tujuan" type="text" id="inputTujuan" placeholder="Tujuan" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Metode</label>
          <div class="col-sm-10">
            <input name="metode" type="text" id="inputMetode" placeholder="Metode" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Jenis Data</label>
          <div class="col-sm-10">
            <input name="jenisdata" type="text" id="inputJenisData" placeholder="Jenis Data" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Variabel</label>
          <div class="col-sm-10">
            <input name="variabel" type="text" id="inputVariabel" placeholder="Variabel" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Rentang Waktu</label>
          <div class="col-sm-10">
            <input name="rentangwaktu" type="text" id="inputRentangWaktu" placeholder="Rentang Waktu" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Rancangan Hasil</label>
          <div class="col-sm-10">
            <input name="rancanganhasil" type="text" id="inputrancanganhasil" placeholder="Rancangan Hasil" class="form-control" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Keterangan</label>
          <div class="col-sm-10">
            <textarea name="keterangan" id="inputKeterangan" placeholder="Tulis Keterangan" class="form-control" required></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="nama" class="col-sm-2 col-form-label">Jumlah halaman</label>
          <div class="col-sm-10">
            <input name="lembar" type="text" id="inputLembar" placeholder="Minimal 1(satu) lembar" value="Minimal 1(satu) halaman" class="form-control" readonly>
          </div>
        </div>
        <p>
          Pastikan data yang ingin Anda ajukan tidak terdapat dalam daftar data mikro kami.
        </p>
        <div class="bd-example">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a href="{{ url('/')}}">
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
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
  </script>
@endpush