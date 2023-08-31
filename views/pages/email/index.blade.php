<!-- View template master -->
@extends('layouts.index')

@push('styles')
<!-- jQuery -->

@endpush

<!-- Konten -->
@section('konten')
  <!-- ======= Datamikro Section ======= -->
  <div class="container py-5" style="margin-bottom: 5%;">
    @if(session('success'))
    <div id="alert1" class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>{{ session('success') }}</strong>            
    </div>
    @endif
    <div class="text-left">
      <h3>Daftar Penerima Email</h3>
      <hr>
      <div class="d-flex mb-2">
        <div class="mr-auto mt-2">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Tambah</button>
        </div>
        <div class="ml-auto">
          <input type="text" class="form-control" id="search" name="search" placeholder="Search by name"></input>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table id="user" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center" style="width:100px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {{-- @foreach($user as $row)        
                <tr style="display: none;">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->uke_name }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->username }}</td>
                  <td>{{ $row->role }}</td>
                  <td>{{ $row->last_login_at }}</td>
                  <td class="bd-example text-center">
                    <a href="{{ route('user.edit', $row->username) }}">
                      <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</button>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="del('{{ $row->id }}')"><i class="fa fa-trash"></i> Hapus</button>
                  </td>
                </tr>
              @endforeach --}}
            </tbody>
          </table>
          {{-- @if ($user->isEmpty())
          <div class="alert alert-warning text-center" role="alert">
            <b>Data Not Found !</b>
          </div> --}}
          <div class="d-flex flex-row">
            {{-- @elseif(app('request')->input('name') || app('request')->input('slug')) --}}
            <div class="">
              {{-- <a href="{{url('user/search')}}">See All</a><span> | </span> --}}
            </div>
            {{-- @endif --}}
            <div class="">
              {{-- Showing results {{$user->count()}} of {{$user->total()}} entries --}}
              Showing results <span id="total_records"></span> of <span id="grand_total"></span> entries
            </div>
          </div>
          <div class="float-right" style="margin-top: -2%;">
            {{-- @if(isset($query))
              {{ $user->appends($query)->links('pagination::bootstrap-4') }}
            @else
              {{ $user->links('pagination::bootstrap-4') }}
            @endif --}}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Datamikro Section -->

<!-- Delete Modal -->

<div class="modal modal-danger fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Penerima Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('email.updateUser') }}" method="post">
        @csrf
        @method('POST')
        {{-- <input id="recipient" name="recipient" type="hidden" value="1"> --}}
        <div class="form-group">
          <label for="">Pilih user</label>
          <input type="hidden" name="recipient" value="1">
          {{-- <input id="recipient" name="recipient" type="hidden" value="1"> --}}
          <select name="id" id="id" class="form-group" style="width: 100%;">
            <option value="0">-- Select user --</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-danger">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>

@foreach($user as $data)
<div class="modal modal-danger fade" id="deleteModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Penerima Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('email.softDel', $data->id) }}" method="post">
        @csrf
        @method('POST')
        <input id="recipient" name="recipient" type="hidden" value="0">
        <p class="text-center">Apakah Anda yakin menghapus <b>{{ $data->name }}</b>?</p>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script type="text/javascript">
    $(document).on('click','.delete',function(){
      let id = $(this).attr('data-id');
      $('#id').val(id);
    });

    $(document).ready(function() {
      $("#recipient").change(function() {
        var id = $(this).children(":selected").attr("id");
      });
      
      // Initialize select2
      $("#id").select2({
        dropdownParent: $('#addModal .modal-content'),
        ajax: {
          url: "{{ route('email.autocomplete') }}",
          type: "GET",
          delay: 250,
          dataType: 'json',
          data: function(params) {
              return {
                  query: params.term, // search term
                  "_token": "{{ csrf_token() }}",
              };
          },
          processResults: function(response) {
              return {
                  results: response
              };
          },
          cache: true
        }
      });
    });

    $("#alert1").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert1").slideUp(500);
    });

    $(document).ready(function(){
      fetch_email_data();
      function fetch_email_data(query = '')
      {
        $.ajax({
          url:"{{ route('email.search') }}",
          method:'GET',
          data:{query:query},
          dataType:'json',
          success:function(data)
          {
            $('tbody').html(data.table_data);
            $('#total_records').text(data.total_data);
            $('#grand_total').text(data.grand_total);
          }
        })
      }

      $(document).on('keyup', '#search', function(){
        var query = $(this).val();
        fetch_email_data(query);
      });
    });
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

    // function del(id) {
    //   Swal.fire({
    //     title: 'Apakah anda yakin?',
    //     text: "Data tidak dapat dikembalikan!",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Ya!',
    //     cancelButtonText:'Tidak'
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       $.ajax({  
    //          url: "{{ route('user.destroy') }}",  
    //          method: "post",  
    //          data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
    //          success:function(data){
    //           Swal.fire(
    //             'Berhasil!',
    //             'Berhasil menghapus data.',
    //             'success'
    //           ).then((value) => {
    //             location.reload();
    //           });
    //         }
    //       });
    //     }
    //   })
    // }
  </script>
@endpush