<!-- View template master -->
@extends('layouts.index')

@push('styles')
<style>
  iframe {
    width: 100%;
    height: 500px;
  }
</style>
@endpush

<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Data Dasar</h3>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col">
          <a href="https://www.tutorialrepublic.com" target="myFrame">Open TutorialRepublic.com</a>
        </div>
        <div class="col">
          <iframe src="{{url('listdatadasar')}}" name="myFrame"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection