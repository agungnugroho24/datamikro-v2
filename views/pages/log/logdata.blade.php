<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<!-- ======= Datamikro Section ======= -->
<section style="margin-top: 5%;margin-bottom: 15%;">
  <div class="text-left">
    <h3>Statistik Data</h3>
    <hr>
    <div class="d-flex mb-2">
      <div class="ml-auto">
        {{-- <input type="text" class="form-control" id="search" name="search" placeholder="Search by name"></input> --}}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Data</th>
              <th scope="col">Update Terakhir</th>
              <th scope="col">Jumlah Akses</th>
              <th scope="col">Jumlah Permintaan</th>
              <th scope="col">Diunduh</th>
            </tr>
          </thead>
          <tbody>
            @forelse($category as $cate)
              <tr>
                <td>{{ ($category->currentpage()-1) * $category->perpage() + $loop->iteration }}</td>
                <td class="text-dark">{{ $cate->name }}</td>
                <td>{{ ($cate->last_update!=null) ? date('d M Y H:i:s', strtotime($cate->last_update)) : '-' }}</td>
                <td>{{ $cate->access }}</td>
                <td>-</td>
                <td>{{ ($cate->unduh!=null) ? $cate->unduh : '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="6">No Data</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="d-flex flex-row">
          {{-- @elseif(app('request')->input('name') || app('request')->input('slug')) --}}
          <div class="">
            {{-- <a href="{{url('user/search')}}">See All</a><span> | </span> --}}
          </div>
        
          <div class="">
            Showing results {{$category->count()}} of {{$category->total()}} entries
            {{-- Showing results <span id="total_records"></span> of <span id="grand_total"></span> entries --}}
          </div>
        </div>
        <div class="float-right" style="margin-top: -2%;">
          @if(isset($query))
            {{ $category->appends($query)->links('pagination::bootstrap-4') }}
          @else
            {{ $category->links('pagination::bootstrap-4') }}
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Datamikro Section -->
@endsection

@push('scripts')
<script type="text/javascript">
  $("#ajukan").click(function (event) {
    event.preventDefault();
    $('#modalOther').modal("show");  
    // Swal.fire({
    //   title: 'Apakah anda yakin?',
    //   text: "Data tidak dapat dikembalikan!",
    //   icon: 'warning',
    //   showCancelButton: true,
    //   confirmButtonColor: '#3085d6',
    //   cancelButtonColor: '#d33',
    //   confirmButtonText: 'Ya!',
    //   cancelButtonText:'Tidak'
    // }).then((result) => {
    //   if (result.isConfirmed) {
    //     $.ajax({  
    //        url: "{{ route('requestOther') }}",  
    //        method: "post",  
    //        data: { '_token': "{{ csrf_token() }}" }, 
    //        success:function(data){
    //         Swal.fire(
    //           'Berhasil!',
    //           'Berhasil mengajukan data.',
    //           'success'
    //         ).then((value) => {
    //           location.reload();
    //         });
    //       }
    //     });
    //   }
    // })
  });

  $("#submitOther").click(function (event) {
    event.preventDefault();
    if($("#formOther").valid()) {      
      var formData = new FormData($('#formOther')[0]);
      $.ajax({
        url: "{{ route('requestOther') }}",
        type: 'POST',
        data: formData, 
        processData: false,
        contentType: false,
        beforeSend: function() { 
          $.LoadingOverlay("show");
        },
        success: function (data) {
          $.LoadingOverlay("hide");
          if (data!=0) {
            Swal.fire(
              'Berhasil!',
              'Berhasil menambahkan data.',
              'success'
            ).then((value) => {
              window.location = "{{ route('/') }}";
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Mohon coba lagi!'
            })
          }
        },
      });
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data tidak lengkap'
      })
    }
  });

  function hapus(id) {
    Swal.fire({
      title: 'Apakah anda yakin? ',
      text: "Data tidak dapat dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText:'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({  
           url: "{{ route('hapus') }}",  
           method: "post",  
           data: { '_token': "{{ csrf_token() }}",id:id }, 
           success:function(data){
            Swal.fire(
              'Berhasil!',
              'Berhasil menghapus data.',
              'success'
            ).then((value) => {
              location.reload();
            });
          }
        });
      }
    })
  }
</script>
@endpush