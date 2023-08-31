<!-- View template master -->
@extends('layouts.index') 

@section('banner')
<section id="hero" class="d-flex align-items-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
        <h1 data-aos="fade-up">Data Bappenas</h1>
        <h2 data-aos="fade-up" data-aos-delay="400">Tempat untuk mengajukan dan berbagi data di lingkungan Kementerian PPN/Bappenas</h2>
        <div data-aos="fade-up" data-aos-delay="800">
          <a href="#datamikro" class="btn-get-started scrollto">Lihat Data Mikro</a>
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
        <img src="{{ asset('assets/img/banner-dm.png') }}" id="bannerdm" class="img-fluid animated" alt="">
      </div>
    </div>
  </div>
</section>
@section('banner')
 
<!-- Konten -->
@section('konten')

  <!-- ======= Datamikro Section ======= -->
  <section id="datamikro" class="about">
    <div class="container">

      <div class="row no-gutters">
        <h3 data-aos="fade-up">Data Mikro - BPS</h3>
        <br><br>
        <table class="table table-bordered table-hover">
          <tbody>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Ekspor Impor</a>
              </td>
              <td>
                <a href="#" class="text-dark">Survei Penduduk Antar Sensus (Supas)</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Industri Besar Sedang (IBS)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Survei Industri Mikro Kecil (IMK)</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Master File Desa (MFD)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Survei Struktur Ongkos Usaha Tani Jagung</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Potensi Desa (Podes)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Survei Sosial Ekonomi Nasional (Susenas)</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Pendataan Program Perlindungan Sosial (PPLS)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Survei Usaha Terintegrasi (Susi)</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Rencana Kerja dan Anggaran Kementerian Negara/Lembaga (RKA-K/L)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Tabel Input-Output</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Survei Angkatan Kerja Nasional (Sakernas)</a>
              </td>
              <td>
                <a href="#" class="text-dark">Sensus Ekonomi</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Sensus Penduduk</a>
              </td>
              <td>
                <a href="#" class="text-dark">Indeks Pembangunan Desa</a>
              </td>
            </tr>
            <tr>
              <td style="width: 50%;">
                <a href="#" class="text-dark">Sensus Pertanian</a>
              </td>
              <td>
                &nbsp;
              </td>
            </tr>
              </tbody>
        </table>
      </div>

    </div>
  </section>
  <!-- End Datamikro Section -->
@endsection