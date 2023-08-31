<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Laporan Permintaan Data (per Data Mikro)</h3>
    <hr>
  </div>
  <div class="d-flex flex-row-reverse">
    <div class="p-2">
      <div class="input-daterange input-group">
        <input type="text" class="form-control" name="starti" id="starti" autocomplete="off">
        <div class="input-group-append">
            <span class="input-group-text bg-info b-0 text-white">TO</span>
        </div>
        <input type="text" class="form-control" name="end" id="end" autocomplete="off">
        <button type="button" class="btn waves-effect waves-light btn-primary mr-1" onclick="filterDs()">Filter</button> 
        <button type="button" class="btn waves-effect waves-light btn-primary" onclick="exportDs()">Export PDF</button> 
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="laporandata" class="table table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>Nama Data Mikro</th>
              <th>Direktorat Pemohon</th>
              <th>Jumlah Permintaan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $dat)
            <tr>
              <td>
                {{$dat->name}}
              </td>
              <td>
                <ul>
                  @foreach($dat->uke as $uke)
                  <li>{{$uke->name}} ({{$uke->total}})</li>
                  @endforeach
                </ul>
              </td>
              <td>
                {{ isset($dat->total->total) ? $dat->total->total : 0 }}
              </td>
            </tr>
            @endforeach
          </tbody>        
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
