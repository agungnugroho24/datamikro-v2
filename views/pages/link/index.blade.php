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
    <h3>Download Link</h3>
    <hr>
    <div class="d-flex mb-2">
      <div class="mr-auto mt-2">
        <!-- <a href="#">
          <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</button>
        </a> -->
      </div>
      <!-- <div class="">
        <input type="text" class="form-control" id="search" name="search" placeholder="Search by name"></input>
      </div> -->
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th>Nama</th>
              <th>Data</th>
              <th>Request date</th>
              <th>Expired date</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
          @foreach($data as $dat)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $dat->name }}</td>
              <td>
              @foreach($dat->files as $files)  
                {{ $files->name }}</br>
              @endforeach
              </td>
              <td>{{ date_format(new DateTime($dat->request_date), "d M Y") }}</td>
              <td>{{ $dat->expired }}</td>
              <td>
                <div class="bd-example text-center">
                  <a href="#">
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <div class="float-right">
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

<!-- Delete Modal -->


@push('scripts')

  <script type="text/javascript">
    $('#alert1').removeClass('d-none');
    setTimeout(() => {
      $('.alert').alert('close');
    }, 2000);
  </script>
@endpush