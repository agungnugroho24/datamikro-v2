<!-- View template master -->
@extends('layouts.index')

@push('styles')
<style>
.project-tab {
    width: 100%;
}
.project-tab #tabs{
    background: #007b5e;
    color: #eee;
}
.project-tab #tabs h6.section-title{
    color: #eee;
}
.project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    background-color: #0062cc;
    color: #ffffff;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
}
.project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
}
.project-tab .nav-link:hover {
    background-color: #0062cc;
    color: #ffffff;
}
.project-tab thead{
    background: #f3f3f3;
    color: #333;
}
.project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
}
</style>
@endpush
 
<!-- Konten -->
@section('konten')
@if(isset($hasil) && $hasil!=null && $hasil->name!=null && isset($hasil->name))
<script>
  var name = '{{ $hasil->name }}';
  Swal.fire(
    'Error!',
    name+' dari unit kerja anda belum menyampaikan hasil.',
    'danger'
  ).then((value) => {
    window.location = '{{ url("riwayat") }}';
  });
</script>
@endif
<div class="container py-5">
  <div class="d-flex" style="margin-bottom: -1.5%;">
    <div class="p-2">
      <a href="{{ url('/') }}">
        <button type="button" class="btn btn-outline-secondary btn-sm" style="border-radius: 50%;"><i class="fa fa-arrow-left"></i></button>
      </a>
    </div>
    <div class="p-2">
      <h3>Tracking Permintaan Data Mikro</h3>
    </div>
  </div>
  {{-- <hr> --}}
  <br><br><br>
  <section id="tabs" class="project-tab">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="step1" data-toggle="tab" href="#" role="tab" onclick="step(1)">
                Pilih Data
              </a>
              <a class="nav-item nav-link" id="step2" data-toggle="tab" href="#" role="tab" onclick="step(2)">
                Kelengkapan
              </a>
              {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#" role="tab" onclick="step(3)">
                Project Tab 3
              </a> --}}
              <a class="nav-item nav-link" id="step4" data-toggle="tab" href="#" role="tab" onclick="step(4)">
                Verifikasi Data
              </a>
              <a class="nav-item nav-link" id="step5" data-toggle="tab" href="#" role="tab" onclick="step(5)">
                Unggah Hasil
              </a>
            </div>
          </nav>
          <div class="tab-content tabs border p-3 mt-4 shadow" style="border-radius: 25px;background-color: #ffffff;" id="tabisi">
            {{-- Isi tab --}}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
  @if(isset($step_done))
    <script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
    var step_done = {!! $step_done !!};
    $(document).ready(function(){
      // $(".flip").click(function(){
      //   $(".panel").toggle();
      // });
      step(4);
      $('#step1').removeClass("active");
      $('#step4').addClass("active");
    });

    function step(id) {
      const getLastItem = thePath => thePath.substring(thePath.lastIndexOf('/') + 1);
      // console.log(getLastItem(window.location.href));
        $.ajax({
          url: APP_URL+"/step"+id+"?uuid="+getLastItem(window.location.href),
          type: 'GET', 
          beforeSend: function() { 
            $.LoadingOverlay("show");
          },
          success: function (data) {
            $.LoadingOverlay("hide");
            $('#tabisi').html(data);
          },
        });
      }
    </script>
  @else
    <script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
    $(document).ready(function(){
      // $(".flip").click(function(){
      //   $(".panel").toggle();
      // });
      step(1);
    });

    function step(id) {
        $.ajax({
          url: APP_URL+"/step"+id,
          type: 'GET', 
          beforeSend: function() { 
            $.LoadingOverlay("show");
          },
          success: function (data) {
            $.LoadingOverlay("hide");
            $('#tabisi').html(data);
          },
        });
      }
    </script>
  @endif
@endpush