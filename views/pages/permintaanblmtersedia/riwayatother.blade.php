<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Riwayat Permintaan Data Belum Tersedia</h3>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="listblmtersedia" class="table table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>Diajukan Oleh</th>
              <th>Tgl. Pengajuan</th>
              <th>Ketersediaan Data</th>
              <th>Status Pengajuan Data Mikro</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $dat)
            <tr>
              <td>
                {{$dat->name}}
              </td>
              <td>
                {{ date_format(new DateTime($dat->request_date), "d M y") }} 
                <sup>{{ date_format(new DateTime($dat->request_date), "H:i:s") }}</sup>
                <br>
              </td>
              <td>
                <b>Latar belakang:</b> {{$dat->latarbelakang}}<br>
                <b>Tujuan:</b> {{$dat->tujuan}}<br>
                <b>Metode:</b> {{$dat->metode}}<br>
                <b>Jenis data:</b> {{$dat->jenis}}<br>
                <b>Variabel:</b> {{$dat->variabel}}<br>
                <b>Rentang waktu:</b> {{$dat->rentangwaktu}}<br>
                <b>Rancangan hasil:</b> {{$dat->hasil}}<br>
                <b>Keterangan:</b> {{$dat->keterangan}}<br>
                <br>
                @foreach($dat->datas as $isi)
                  <b>{{$isi->name}} - {{$isi->tahun}} ({{$isi->cakupan}})</b><br>

                  @if(!$loop->last)
                    <hr>
                  @endif
                @endforeach
              </td>
              <td class="col-md-3">
                <ul class="list-group">
                  <li class="list-group-item" style="background-color: transparent;border: none;">
                    @if($dat->scan_surat=='' || $dat->scan_surat==null)
                      Belum dibuatkan surat pengajuan data ke BPS.
                    @else
                      <i class="fa fa-check-square-o"></i> Surat pengajuan data sudah dikirim ke BPS.<br>Scan Surat: <a href="{{ route('downloadsurat', $dat->id) }}"><span class="label">{{ substr($dat->scan_surat, strrpos($dat->scan_surat, '/') + 1) }}</span></a>
                    @endif
                  </li>                  
                  @if($dat->bps_check!='' || $dat->bps_check!=null)
                  <li class="list-group-item" style="background-color: transparent;border: none;">
                    @php 
                    $status = json_decode($dat->bps_check);
                    @endphp
                    @foreach($status as $stat)
                    <i class="fa fa-check-square-o"></i> Sudah dilakukan pengecekan ke BPS ({{$stat->date}}), 
                    @if($stat->status==1)
                    <span class="badge badge-success">Tersedia</span>
                    @else
                    <span class="badge badge-danger">Belum Tersedia</span>
                    @endif
                    </br>
                    @endforeach
                  </li>
                  @else
                  <li class="list-group-item" style="background-color: transparent;border: none;">
                    Pusdatin akan melakukan pengecekan permintaan data secara berkala ke BPS.
                  </li>
                  @endif
                </ul>
              </td>     
            </tr>
            @empty
              <tr><td colspan="6" class="text-center">No Data Found</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  function del(id) {
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
           url: "{{ route('delOther') }}",  
           method: "post",  
           data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
           success:function(data){
            Swal.fire(
              'Berhasil!',
              'Berhasil menghapus data.',
              'success'
            ).then((value) => {
              window.location = "{{ route('listblmtersedia') }}";
            });
          }
        });
      }
    })
  }


  $("#statusButton").click(function (event) {
    event.preventDefault();
    if($("#statusForm").valid()) {
      var formData = new FormData($('#statusForm')[0]);
      $.ajax({
        url: "{{ route('statusOther') }}",
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
              window.location = "{{ route('listblmtersedia') }}";
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

  $("#suratButton").click(function (event) {
    event.preventDefault();
    if($("#suratForm").valid()) {
      var formData = new FormData($('#suratForm')[0]);
      $.ajax({
        url: "{{ route('suratOther') }}",
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
              window.location = "{{ route('listblmtersedia') }}";
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
</script>
@endpush
