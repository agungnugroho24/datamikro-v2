<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  @if(session('success'))
    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
          {{ session('success') }}              
    </div>
  @endif
  <div class="text-left">
    <h3>Role</h3>
    <hr>
    <div class="span4 mb-5">
      <a href="{{ url('role/create') }}">
        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</button>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="role" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Role Name</th>
              <th>Deskripsi</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($role as $role)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $role->display_name }}</td>
              <td>{{ $role->description }}</td>
              <td>
                <div class="bd-example text-center">
                  <a href="{{ route('role.edit', $role->name) }}" style="text-decoration: none;">
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button>
                  </a>
                  @if($role->id!=1)
                  <button type="button" class="btn btn-danger btn-sm" onclick="del('{{ $role->name }}')"><i class="fa fa-trash"></i> Hapus</button>
                  @endif
                </div>
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
      $('#role').DataTable({
        "searching": false
      });
    });

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
             url: "{{ route('role.destroy') }}",  
             method: "post",  
             data: { 'name': name,'_token': "{{ csrf_token() }}" }, 
             success:function(data){
              Swal.fire(
                'Berhasil!',
                'Berhasil menghapus data.',
                'success',
              ).then((value) => {
                location.reload();
              });
            }
          });
        }
      })
    }

    $('#alert').removeClass('d-none');
    setTimeout(() => {
      $('.alert').alert('close');
    }, 2000);
  </script>
@endpush