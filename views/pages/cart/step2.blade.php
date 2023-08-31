<style type="text/css">
.error {
  color:red;
}
</style>
<div role="tabpanel" class="tab-pane in active">
  @if($cookie!=null)
    @if(isset($step->step_done) && $step->step_done==1)
      <h5>Kelengkapan Dokumen</h5>
      <ol>
        <form id="formStep2">
          <li>
            <strong>Penanggung Jawab Permintaan</strong>
            <ul id="">
              <li>Nama : {{ $uke->responsible }}</li>
              <li>NIP : {{ $uke->nip }}</li>
              <li>Jabatan : {{ $uke->position }}</li>
            </ul>
          </li>
          {{--
          @if($isSusenas!=null)
          <li>
            <strong>Isi Variabel</strong> (<a href='https://microdata.bps.go.id/mikrodata/index.php/catalog/SUSENAS' target='_blank' style=''><b>Kamus data</b></a>)
            <div class="form-group row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Variabel</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="variable" name="variable" style='text-transform:uppercase' placeholder='B1R1, B2R2, dst' required>
              </div>
            </div>
          </li>
          @endif
          --}}
          <li>
            <strong>Isi Kode Klasifikasi/Arsip</strong> (<a href="#" data-toggle="modal" data-target="#exampleModal"><b>Klik disini</b></a> untuk melihat kode Klasifikasi/Arsip)
            <div class="form-group row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Kode Klasifikasi/Arsip</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="kode_arsip" name="kode_arsip" value="" style='text-transform:uppercase' required>
              </div>
            </div>
          </li>
          <li>
            <strong>Isi Form Abstraksi</strong> (Untuk memenuhi persyaratan dari BPS)
            <div class="form-group row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Judul</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="abstract_title" name="abstract_title" value="" required>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Abstraksi</label>
              <div class="col-sm-10">
                <textarea class="form-control" placeholder="Isi dengan informasi abstrak dan metadata" name="abstract_content" required></textarea>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Penulis Abstraksi</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="penulis" name="penulis" value="{{ auth()->user()->name }}" required readonly>
              </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary" id="submitStep2">Lanjut ke Langkah 3 <i class="fa fa-chevron-right"></i></button>
          </li>
        </form>
      </ol>
    @else
      <div class="well">
        <ol>
          <li>
            <strong>Penanggung Jawab Permintaan</strong>
            <ul>
              <li>Nama: {{ $request_data->responsible_name }}</li>
              <li>NIP: {{ $request_data->responsible_nip }}</li>
              <li>Jabatan: {{ $request_data->responsible_position }}</li>
            </ul>
          </li>
          <li>
            <strong>Cetak Formulir</strong>
            <ul>
              <li>Form LADU sudah dicetak</li>
              <li>Form Nota Dinas sudah dicetak</li>              
            </ul>
          </li>
          <li>
            <strong>Form Abstraksi</strong>
            <table class="">
              <tbody>
                <tr>
                  <td width="140">Judul</td>
                  <td>{{ $request_data->abstract_title }}</td>
                </tr>
                <tr>
                  <td>Abstraksi</td>
                  <td>{{ $request_data->abstract_content }}</td>
                </tr>
                <tr>
                  <td>Penulis Abstraksi</td>
                  <td>{{ $request_data->name }}</td>
                </tr>
              </tbody>
            </table>
          </li>
        </ol>
      </div>
    @endif
  @else
    <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
  @endif

  <!-- Modal Kode Arsip-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Kode Arsip</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe src="{{ asset('assets/file/kodearsip.pdf') }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#submitStep2").click(function (event) {
    event.preventDefault();
    // $("#formStep2").validate();
    if($("#formStep2").valid()) {      
      var formData = new FormData($('#formStep2')[0]);
      formData.append("_token", "{{ csrf_token() }}")
      formData.append("step", "2")
      $.ajax({
        url: "{{ route('requestData') }}",
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
            $('#step2').removeClass("active");
            $('#step4').addClass("active");
            $('#cart').html(0);
            step(4);
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