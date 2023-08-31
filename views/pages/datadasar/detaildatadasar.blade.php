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
        <a href="#">
          <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>
        </a>
      </div>
    </div>
  </div>
  <hr>
  <div class="text-left">
    <div class="span4">
      <h6>Ekspor Impor 2000 s.d Mei 2016</h6>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="table-responsive">          
          <table class="table table-bordered table-striped" width="100%">
            <tbody>
              <tr>
                <td>
                  <i class="fa fa-folder"></i>
                </td>
                <td>
                  <a href="#">
                    Data Ekspor Impor
                  </a>
                  <p>Data Ekspor Impor 2000 s.d 20186; Ekspor dan Impor untuk kode HS 6 digit tahun 2000-2016; Ekspor-impor menurut ISIC 5 digit 1993-2016;Impor Beras, Tahun 1975 s/d 2020 (Jan-Jun)</p>
                </td>
                <td>
                  <a href="#">Edit</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection