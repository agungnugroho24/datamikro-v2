<!-- View template master -->
@extends('layouts.index')

<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>All Data Mikro</h3>
    <hr>
    <div class="span4 mb-5">
      <a href="{{url('category/add')}}">
        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Kategori</button>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" width="100%">
            <tbody>
              @foreach($category as $cate)
	              <tr>
	                <td>
	                  <i class="fa fa-folder"></i>
	                </td>
	                <td>
	                  <a href="{{ route('detail', $cate->slug) }}" class="text-dark">{{ $cate->name }}</a>
	                </td>
	                <td class="text-center">
	                  <div class="bd-example">
	                    <a href="{{route('category.edit', $cate->slug) }}">
                        {{-- <a href="{{route('underconstruction') }}"> --}}
	                      <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</button>
	                    </a>
                      <button type="button" class="btn btn-danger btn-sm" onclick="del('{{ $cate->slug }}')"><i class="fa fa-trash"></i> Delete</button>
	                  </div>
	                </td>
	              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="float-right">
            {{$category->links('pagination::bootstrap-4')}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    function del(slug) {
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
             url: "{{ route('category.destroy') }}",  
             method: "post",  
             data: { 'slug': slug,'_token': "{{ csrf_token() }}" }, 
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