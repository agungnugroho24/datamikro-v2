<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Tambah Kategori Data Dasar</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form role="form" action="{{ route('category.store') }}" method="post" >
        @csrf
        <div class="form-group row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Kategori Data Dasar" value="{{ old('name') }}">
              @error('name')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
          </div>
        </div>        
        <div class="form-group row mb-3">
          <label for="slug" class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
              <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required readonly>
              @error('slug')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="description">Description</label>
          </div>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
          </div>
        </div>
        <!-- <div class="form-group row mb-3">
          <label for="uke" class="col-sm-2">Parent</label>
          <div class="col-sm-10">
            <select class="form-select" id="">
              <option selected disabled>(Data dasar)</option>
              <option>data 1</option>
              <option>data 2</option>
              <option>data 3</option>
              <option>data 4</option>
            </select>
          </div>
        </div> -->
        <!-- <div class="form-group row mb-3">
          <label for="uke" class="col-sm-2">Unit kerja</label>
          <div class="col-sm-10">
            <select class="form-select" id="">
              <option selected disabled>(Pilih unit kerja)</option>
              <option>uke 1</option>
              <option>uke 2</option>
              <option>uke 3</option>
              <option>uke 4</option>
            </select>
          </div>
        </div> -->
        <div class="bd-example">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a href="{{ url('datadasar') }}">
              <button type="button" class="btn btn-secondary btn-sm">Batal</button>
            </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch(APP_URL+'/category/checkSlug?name='+name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug);
    });
  </script>
@endpush