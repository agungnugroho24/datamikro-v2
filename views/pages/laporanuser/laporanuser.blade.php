<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Laporan Permintaan Data (per User)</h3>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="laporanuser" class="table table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>User Pemohon</th>
              <th>Direktorat Pemohon</th>
              <th>Ketersediaan Data</th>
              <th>Abstraksi</th>
              <th>Tanggal Permohonan</th>
              <th>Tanggal Verifikasi</th>
              <th>Verifikator</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $dat)
            <tr>
              <td>
                {{$dat->name}}
              </td>
              <td>
                {{$dat->uke}}
              </td>
              <td>
                <b>Data Tersedia:</b>
                <ul>
                  @foreach($dat->files as $file)
                  <li>{{$file->name}}</li>
                  @endforeach
                </ul>	
              </td>
              <td>
                <b>{{$dat->abstract_title}}</b>
                <p>{{$dat->abstract_content}}</p>
              </td>
              <td>
                {{$dat->request_date}}
              </td>
              <td>
                {{$dat->acc_date}}                
              </td>
              <td>
                {{$dat->verifikasi}}                
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

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#laporanuser').DataTable();
    } );
  </script>
@endpush