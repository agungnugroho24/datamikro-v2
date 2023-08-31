<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  @if(session('success'))
    <div id="alert1" class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
          {{ session('success') }}              
    </div>
  @endif
  <div class="text-left">
    <h3>Resources</h3>
    <hr>
    <div class="d-flex mb-2">
      <div class="mr-auto mt-2">
        <a href="{{ url('resource/add') }}">
          <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</button>
        </a>
      </div>
      <div class="">
        <form class="form-inline" action="{{ url('resource/search') }}" method="get">
          <div class="input-group">
            <input type="text" name="name" placeholder="Search by name" class="form-control">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit">
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
        <table id="" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Name/Code</th>
              <th>Display Name</th>
              <th>Description</th>
              <th>Parent</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($resource as $res) 
            <tr>
              <td class="text-center">
                {{ $loop->iteration }}
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{ $res->name }}
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{ $res->display_name }}
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{ $res->description }}                
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{ $res->parent }}                
              </td>
              <td class="text-center">
                <a href="{{ route('resource.edit', $res->name) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button></a>
                <button type="button" class="btn btn-danger btn-sm" onclick="del('{{ $res->name }}')"><i class="fa fa-trash"></i> Hapus</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if ($resource->isEmpty())
        <div class="alert alert-secondary text-center" role="alert" style="margin-top: -2%;">
          <b>Data Not Found !</b>
        </div>
        <div class="d-flex flex-row">
          @elseif(app('request')->input('name') || app('request')->input('display_name'))
          <div class="">
            <a href="{{url('resource/search')}}">See All</a><span> | </span>
          </div>
          @endif
          <div class="">
            Showing results {{$resource->count()}} of {{$resource->total()}} entries
          </div>
        </div>
        <div class="float-right" style="margin-top: -2%;">
          @if(isset($query))
            {{ $resource->appends($query)->links('pagination::bootstrap-4') }}
          @else
            {{ $resource->links('pagination::bootstrap-4') }}
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
@foreach($resource as $data)
<div class="modal modal-danger fade" id="deleteModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Data Resource</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('resource.delete', $data->id) }}" method="post">
        @csrf
        <input id="id" name="id" type="hidden">
        <p class="text-center">Apakah Anda yakin menghapus data resource <b>{{ $data->name }}</b> dan <b>{{ $data->display_name }}</b>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-danger">Ya</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection

@push('scripts')
  <script type="text/javascript">
    // $(document).on('click','.delete',function(){
    //   let id = $(this).attr('data-id');
    //   $('#id').val(id);
    // });

    function del(name) {
      Swal.fire({
        title: 'Apakah anda yakin?',
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
             url: "{{ route('resource.destroy') }}",  
             method: "post",  
             data: { 'name': name,'_token': "{{ csrf_token() }}" }, 
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

    // $('#alert1').removeClass('d-none');
    // setTimeout(() => {
    //   $('.alert').alert('close');
    // }, 2000);

    // var APP_URL = {!! json_encode(url('/')) !!};
    // $('#search').on('keyup',function(){
    //   $value=$(this).val();
    //     $.ajax({
    //       type : 'get',
    //       url: APP_URL+"/resource/search",
    //       data:{'search':$value},
    //       success:function(data){
    //       $('tbody').html(data);
    //     }
    //   });
    // })
    // $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>
@endpush