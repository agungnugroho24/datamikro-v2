<!-- View template master -->
@extends('layouts.index') 

@push('styles')
<style>
  .nav-tabs{
    border: none;
    background: #6c757d;
    border-radius: 1.5rem;
    width: 23%;
  }
  .nav-tabs .nav-link{
    border: none;
    height: 41px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
  }
  .nav-tabs .nav-link:hover{
    border: none;
  }
  .nav-tabs .nav-link.active{
    border: none;
    width: 100%;
    color: #000000;
    border: 2px solid #6c757d;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
  }
</style>
@endpush

<!-- Konten -->
@section('konten')
<ul class="nav nav-tabs mt-5 mb-4" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><h5>Data Mikro</h5></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><h5>Data Baru</h5></a>
  </li>
</ul>
<div class="tab-content border p-3 shadow" id="myTabContent" style="border-radius: 25px;background-color: #ffffff;margin-bottom:10%;">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <table class="table table-striped">
      <tbody>
        @foreach($data as $cate)
          @if($loop->iteration % 2 == 0)
              <td>
                <a href="{{ route('detail', $cate->slug) }}" class="text-dark">{{ $cate->name }} {{ $cate->period!='' ? '- '.$cate->period : '' }}</a>
                @if(date("Y-m-d H:i:s") < $cate->last_update)
                <span class="badge bg-danger text-light">New</span>
                @endif
              </td>            
            </tr>      
          @else
            @if($loop->iteration == 1 && count($data)==1)
              <tr>
                <td style="width: 50%;">
                  <a href="{{ route('detail', $cate->slug) }}" class="text-dark">{{ $cate->name }} {{ $cate->period!='' ? '- '.$cate->period : '' }}</a>
                  @if(date("Y-m-d H:i:s") < $cate->last_update)
                  <span class="badge bg-danger text-light">New</span>
                  @endif
                </td>
              </tr>
            @else
              @if($loop->iteration == count($data))
                <tr>
                  <td class="border-right" style="width: 50%;">
                    <a href="{{ route('detail', $cate->slug) }}" class="text-dark">{{ $cate->name }} {{ $cate->period!='' ? '- '.$cate->period : '' }}</a>
                    @if(date("Y-m-d H:i:s") < $cate->last_update)
                    <span class="badge bg-danger text-light">New</span>
                    @endif
                  </td>
                  <td>
                    &nbsp;
                  </td>
                </tr>
              @else
                <tr>
                  <td class="border-right" style="width: 50%;">
                    <a href="{{ route('detail', $cate->slug) }}" class="text-dark">{{ $cate->name }} {{ $cate->period!='' ? '- '.$cate->period : '' }}</a>
                    @if(date("Y-m-d H:i:s") < $cate->last_update)
                    <span class="badge bg-danger text-light">New</span>
                    @endif
                  </td> 
              @endif  
            @endif 
          @endif
        @endforeach
      </tbody>
    </table>
    <p style="font-size: 15px;">Catatan: Pemanfaatan Raw Data BPS harus mengikuti prosedur <a href="https://data.bappenas.go.id/assets/images/5_prosedur_permintaan.jpg" target="_blank">Pemanfaatan Data Mikro</a>.</p>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div class="alert alert-info col-lg-12" role="alert">
    {{-- <h5 class="alert-heading">Data Lainnya</h5> --}}
    <div class="d-flex" style="margin-bottom: -2%;">
      <div style="margin-top:1.4%;">
        <p>Gunakan Formulir ini bila Anda tidak menemukan Data Mikro yang dicari.</p>
      </div>
      <div class="ml-auto">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-light btn-sm border" data-toggle="modal" data-target="#customdata" data-backdrop="static" data-keyboard="false">
          <i class="fa fa-plus"></i> Tambah Data Lain
        </button>
      </div>
    </div>
    <div id="custom" style="display: block;">
      <hr>
      @foreach($notavailable as $not)
      <ul>
        <li>
          <b>{{ $not->name }} - {{ $not->tahun }} ({{ $not->cakupan }})</b>
            <button type="button" class="btn btn-danger btn-sm borderless" onclick="hapus('{{ $not->id }}')"><i class="fa fa-trash"></i></button>
          <br>{{ $not->keterangan }}
        </li>
      </ul>
      @endforeach
      @if(sizeof($notavailable) > 0)
      <a class="ml-4" href="#">
        <button type="button" class="btn btn-primary btn-sm" id="ajukan"><i class="fa fa-check-square-o"></i> Ajukan Data</button>
      </a>
      @endif
    </div>
  </div>
  <p style="font-size: 15px;">Catatan: Pemanfaatan Raw Data BPS harus mengikuti prosedur <a href="https://data.bappenas.go.id/assets/images/5_prosedur_permintaan.jpg" target="_blank">Pemanfaatan Data Mikro</a>.</p></div>
</div>

<div class="modal fade" id="modalOther" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customdataLabel">Formulir Pengajuan Data Mikro Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="formOther">
      @csrf
      @method('POST')
      <div class="modal-body">
        <!-- ======= Permintaan Data Lain ======= -->
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Latar Belakang</label>
              <div class="col-sm-10">
                <input name="latarbelakang" type="text" id="latarbelakang" placeholder="Latar Belakang" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Tujuan</label>
              <div class="col-sm-10">
                <input name="tujuan" type="text" id="tujuan" placeholder="Tujuan" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Metode</label>
              <div class="col-sm-10">
                <input name="metode" type="text" id="metode" placeholder="Metode" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Jenis Data</label>
              <div class="col-sm-10">
                <input name="jenis" type="text" id="jenis" placeholder="Jenis Data" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Variabel</label>
              <div class="col-sm-10">
                <input name="variabel" type="text" id="variabel" placeholder="Variabel" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Rentang Waktu</label>
              <div class="col-sm-10">
                <input name="rentangwaktu" type="text" id="rentangwaktu" placeholder="Rentang Waktu" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Rancangan Hasil</label>
              <div class="col-sm-10">
                <input name="rancanganhasil" type="text" id="rancanganhasil" placeholder="Rancangan Hasil" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Keterangan</label>
              <div class="col-sm-10">
                <textarea name="keterangan" id="keterangan" placeholder="Tulis Keterangan" class="form-control" required></textarea>
              </div>
            </div>
            <!-- <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Jumlah halaman</label>
              <div class="col-sm-10">
                <input name="lembar" type="text" id="lembar" placeholder="Minimal 1(satu) lembar" value="Minimal 1(satu) halaman" class="form-control" readonly>
              </div>
            </div> -->
            <p>
              Pastikan data yang ingin Anda ajukan tidak terdapat dalam daftar data mikro kami.
            </p>
        <!-- ======= End Permintaan Data Lain ======= -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" id="submitOther">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $("#ajukan").click(function (event) {
      event.preventDefault();
      $('#modalOther').modal("show");  
      // Swal.fire({
      //   title: 'Apakah anda yakin?',
      //   text: "Data tidak dapat dikembalikan!",
      //   icon: 'warning',
      //   showCancelButton: true,
      //   confirmButtonColor: '#3085d6',
      //   cancelButtonColor: '#d33',
      //   confirmButtonText: 'Ya!',
      //   cancelButtonText:'Tidak'
      // }).then((result) => {
      //   if (result.isConfirmed) {
      //     $.ajax({  
      //        url: "{{ route('requestOther') }}",  
      //        method: "post",  
      //        data: { '_token': "{{ csrf_token() }}" }, 
      //        success:function(data){
      //         Swal.fire(
      //           'Berhasil!',
      //           'Berhasil mengajukan data.',
      //           'success'
      //         ).then((value) => {
      //           location.reload();
      //         });
      //       }
      //     });
      //   }
      // })
    });
  
    $("#submitOther").click(function (event) {
      event.preventDefault();
      if($("#formOther").valid()) {      
        var formData = new FormData($('#formOther')[0]);
        $.ajax({
          url: "{{ route('requestOther') }}",
          type: 'POST',
          data: formData, 
          processData: false,
          contentType: false,
          beforeSend: function() { 
            $.LoadingOverlay("show");
          },
          success: function (data) {
            $.LoadingOverlay("hide");
            if (data!=0) {
              Swal.fire(
                'Berhasil!',
                'Berhasil menambahkan data.',
                'success'
              ).then((value) => {
                window.location = "{{ route('/') }}";
              });
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mohon coba lagi!'
              })
            }
          },
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Data tidak lengkap'
        })
      }
    });
  
    function hapus(id) {
      Swal.fire({
        title: 'Apakah anda yakin? ',
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
             url: "{{ route('hapus') }}",  
             method: "post",  
             data: { '_token': "{{ csrf_token() }}",id:id }, 
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