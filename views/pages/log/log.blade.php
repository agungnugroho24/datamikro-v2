<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Activity Log</h3>
    <hr>
    <div class="d-flex mb-2">
      <div class="ml-auto">
        {{-- <input type="text" class="form-control" id="search" name="search" placeholder="Search by name"></input> --}}
        <form class="form-inline" action="{{ route('log.dt') }}" method="get">
          <div class="input-group">
            <input type="text" name="name" placeholder="Cari nama atau unit kerja" class="form-control">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit">
                Cari
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="log" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th width="14%">Waktu</th>
              <th>Nama</th>
              <th>Aktivitas Data</th>
              <th>Unit Kerja</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $dat)
              @php
                $now = date('d F Y');
                $date = date('d F Y', strtotime($dat->created_at));
                $time = date('H:i:s', strtotime($dat->created_at));
                if($dat->type=='login'){
                  $activity = 'User login ke sistem';
                }else if($dat->type=='create'){
                  $activity = 'Create data <b>'.$dat->data.'</b>';
                }else if($dat->type=='update'){
                  $activity = 'Update data <b>'.$dat->data.'</b>';
                }else if($dat->type=='delete'){
                  $activity = 'Delete data <b>'.$dat->data.'</b>';
                }else if($dat->type=='read'){
                  $activity = 'Membaca data <b>'.$dat->data.'</b>';
                }else if($dat->type=='download'){
                  $activity = 'Download data <b>'.$dat->data.'</b>';
                }
              @endphp
              <tr>
                <td>
                  @if($now==$date)
                  {{ $time }}
                  @else
                  {{ $date }} <sup>{{ $time }}</sup>
                  @endif
                </td>
                {{-- <td>{{ $dat->user_name }}</td> --}}
                <td>{{ $dat->name }}</td>
                <td>{!! $activity !!}</td>
                <td>{{ $dat->uke_name }}</td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center">No Data Found</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex">
          <div class="">
            @if(app('request')->input('name') || app('request')->input('display_name'))
            <a href="{{ route('log.dt') }}">See All</a><span> | </span>
            @endif
          </div>
          <div class="ml-1">
            Showing results {{$data->count()}} of {{$data->total()}} entries
          </div>
          <div class="ml-auto p-2">
            @if(isset($query))
            {{ $data->appends($query)->links('pagination::bootstrap-4') }}
            @else
            {{ $data->links('pagination::bootstrap-4') }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    // $(document).ready(function(){
    //   fetch_log_data();
    //   function fetch_log_data(query = '')
    //   {
    //     $.ajax({
    //     url:"{{ route('log.dt') }}",
    //     method:'GET',
    //     data:{query:query},
    //     dataType:'json',
    //     success:function(data)
    //     {
    //       $('tbody').html(data.table_data);
    //       $('#total_records').text(data.total_data);
    //       $('#grand_total').text(data.grand_total);
    //     }
    //     })
    //   }

    //   $(document).on('keyup', '#search', function(){
    //     var query = $(this).val();
    //     fetch_log_data(query);
    //   });
    // });
    // $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

    var APP_URL = {!! json_encode(url('/')) !!};
    $('#search').on('keyup',function(){
      $value=$(this).val();
        $.ajax({
          type : 'get',
          url: "{{ route('log.dt') }}",
          data:{'search':$value},
          success:function(data){
          $('tbody').html(data);
        }
      });
    })
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>
@endpush