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
    <h3>Rule</h3>
    <hr>
    <div class="span4 mb-5">
      <a href="{{ url('rule/add') }}">
        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</button>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="rule" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>Role Name</th>
              <th>Permission</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($role as $r)
            <tr>
              <td>{{ $r->display_name }}</td>
              <td>{{ $r->total }}</td>
              <td>
                <div class="bd-example text-center">
                  <a href="{{ route('rule.edit', $r->name) }}" style="text-decoration: none;">
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$role->links('pagination::bootstrap-4')}}
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#rule').DataTable({
        "searching": false
      });
    });

    $('#alert').removeClass('d-none');
    setTimeout(() => {
      $('.alert').alert('close');
    }, 2000);
  </script>
@endpush