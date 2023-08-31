<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Riwayat Permintaan Data Tersedia</h3>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="riwayat" class="table table-striped table-bordered rounded" style="width:100%">
          <thead>
            <tr>
              <th>No. LADU</th>
              <th>No. Nota Dinas</th>
              <th>Tgl. Request</th>
              <th>Progres</th>
              <th>Status</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
              @forelse($data as $dat)
              @php
              $step = $dat->step_done;
              @endphp
              <tr>
                <td><a href="{{ route('tracking', $dat->uuid) }}">{{ $dat->ladu_no.'/P02.SP/'.date('m', strtotime($dat->request_date)).'/'.date('Y', strtotime($dat->request_date)) }}</a></td>
                <td>{{ $dat->nd_number }}</td>
                <td>{{ $dat->request_date }}</td>
                <td>Langkah {{ ($dat->step_done==4) ? 3 : $dat->step_done}} dari 3</td>
                <td>{{ $dat->request_status }}</td>
                <td>{{ $dat->notes }}</td>
              </tr>
              @empty
                <tr><td colspan="6" class="text-center">No Data Found</td></tr>
              @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">

  </script>
@endpush