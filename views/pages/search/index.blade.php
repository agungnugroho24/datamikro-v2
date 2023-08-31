<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Data Mikro</h3>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Sumber</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $row)   
            <tr>
              <td>{{ ($categories->currentpage()-1) * $categories->perpage() + $loop->iteration }}</td>
              <td><a href="{{ route('detail', $row->slug) }}" class="text-dark">{{ $row->data }}</a></td>
              <td>{{ $row->name }}</td>
              <td>{{ $row->source }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if ($categories==null)
        <div class="alert alert-secondary text-center" role="alert" style="margin-top: -2%;">
          <b>Data Not Found !</b>
        </div>
        <div class="d-flex flex-row">
          <div class="">
            Showing results 0 of 0 entries
          </div>
        </div>
        @else
          @if($categories->isEmpty())
          <div class="alert alert-secondary text-center" role="alert" style="margin-top: -2%;">
            <b>Data Not Found !</b>
          </div>
          @endif
        <div class="d-flex flex-row">
          <div class="">
            Showing results {{$categories->count()}} of {{$categories->total()}} entries
          </div>
        </div>
        <div class="float-right" style="margin-top: -2%;">
          @if(isset($query))
            {{ $categories->appends($query)->links('pagination::bootstrap-4') }}
          @else
            {{ $categories->links('pagination::bootstrap-4') }}
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">

  </script>
@endpush