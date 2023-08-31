<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Edit Resources</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form role="form" action="{{ route('resource.edit', $resource->name) }}" method="post" >
        @csrf
        <div class="row mb-3 mt-3">
          <label for="exampleInputEmail1" class="form-label col-sm-2">Name/Code</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="Controller@Function" id="code" name="code" value="{{ old('code', $resource->name) }}">
            @error('code')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="exampleInputPassword1" class="form-label col-sm-2">Display Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $resource->display_name) }}">
            @error('name')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="exampleFormControlTextarea1" class="form-label col-sm-2">Description</label>
          <div class="col-sm-10">
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3" name="description">{{ old('name', $resource->description) }}</textarea>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="uke" class="col-sm-2">Parent</label>
          <div class="col-sm-10">
            <select class="form-control" id="parent" name="parent">
              <option value="0" @if($resource->parent=="0") selected @endif>-- No Parent --</option>
              @foreach($parent as $parent) 
              <option value="{{ $parent->id }}" @if($resource->parent==$parent->id) selected @endif>{{ $parent->display_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{ url('resource') }}">
          <button type="button" class="btn btn-secondary btn-sm" onclick="">Batal</button>
        </a>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">

  </script>
@endpush