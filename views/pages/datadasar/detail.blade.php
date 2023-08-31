<!-- View template master -->
@extends('layouts.index')

<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="d-flex" style="margin-bottom: -1.5%;">
    <div class="p-2">
      <a href="{{ url('datadasar') }}">
        <button type="button" class="btn btn-outline-secondary btn-sm" style="border-radius: 50%;"><i class="fa fa-arrow-left"></i></button>
      </a>
    </div>
    <div class="p-2">
      <h3>Ekspor Impor</h3>
    </div>
    <div class="ml-auto p-2">
      <div class="col text-right">
        {{-- <a href="#">
          <button type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit</button>
        </a> --}}
      </div>
    </div>
  </div>
  <hr>
  <div class="text-left">
    <div class="span4">
      <h4>Deskripsi</h4>
      <p>
        Data Ekspor Impor 2000 s.d 20186; Ekspor dan Impor untuk kode HS 6 digit tahun 2000-2016; Ekspor-impor menurut ISIC 5 digit 1993-2016;Impor Beras, Tahun 1975 s/d 2020 (Jan-Jun)
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <h4>Ikhtisar</h4>
        <table class="table table-bordered fields-table">
          <tr>
            <th class="span3">
              Unit Kerja
            </th>
            <td>
              Pusat Data dan Informasi Perencanaan Pembangunan
            </td>
          </tr>
          <tr>
            <th class="span3">
              Lembaga Sumber Data
            </th>
            <td>
              BPS
            </td>
          </tr>
          <tr>
            <th>
              Tag
            </th>
            <td>
              ekspor, impor
            </td>
          </tr>
          <tr>
            <th>
              Kelompok Data
            </th>
            <td>
              Consumer and Producer Price Index
            </td>
          </tr>
          <tr>
            <th>
              Periode Data
            </th>
            <td>
              2000-2020
            </td>
          </tr>
          <tr>
            <th>
              Frekuensi
            </th>
            <td>
              Tahunan, Bulanan
            </td>
          </tr>
          <tr>
            <th>
              Dipublikasikan Pada
            </th>
            <td>
              12 Mar 2015 07:48:32
            </td>
          </tr>
          <tr>
            <th>
              Diperbarui Pada
            </th>
            <td>
              10 Nov 2021 17:13:26
            </td>
          </tr>
        </table>

        <h4>Cakupan Data</h4>
        <table class="table table-bordered fields-table">
          <tr>
            <th class="span3">
              Unit Analisis
            </th>
            <td>
              -
            </td>
          </tr>
          <tr>
            <th>
              Granularitas
            </th>
            <td>
              -
            </td>
          </tr>
          <tr>
            <th>
              Cakupan Wilayah
            </th>
            <td>
              Nasional
            </td>
          </tr>
        </table>

        <h4>Daftar File</h4>
        <table class="table table-bordered fields-table" style="word-break: break-word;">
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Impor 2016.zip
            </td>
            <th style="text-align:center;">
              <a href="#">
                <button type="button" class="btn btn-sm btn-light border">
                  <i class="fa fa-download"></i> Download
                </button>
              </a>
              <br>
                18,90 MB
            </th>
          </tr>
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Exspor 2019.zip
            </td>
            <th style="text-align:center">
              <a href="#">
                <button type="button" class="btn btn-sm btn-light border">
                  <i class="fa fa-download"></i> Download
                </button>
              </a>
              <br>
                10,99 MB
            </th>
          </tr>
          <tr>
            <td>
              <img src="https://data.bappenas.go.id/assets/images/file-types/zip.png" style="float: left; margin: 0 5px 0 0;" />
              Kompilasi Data Statistik Exspor 2018.zip
            </td>
            <th style="text-align:center">
              <a href="#">
                <button type="button" class="btn btn-sm btn-light border">
                  <i class="fa fa-download"></i> Download
                </button>
              </a>
              <br>
              11,18 MB
            </th>
          </tr>
        </table>
        <h4>Aktivitas</h4>
        <table class="table table-bordered fields-table">
          <tr>
            <th>Diakses</th>
            <td>1238</td>
          </tr>
          <tr>
            <th>Diunduh</th>
            <td>82</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection