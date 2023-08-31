<div role="tabpanel" class="tab-pane in active">
  @if(is_null($request) || $request->step_done < 2 || $cookie==null)
    <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
  @elseif($request->request_status=='accept' || $request->request_status=='complete')
    <h5>Verifikasi Data</h5>
    <div class="well">
      <div class="lead">Data Tersedia:</div>
      <table class="table table-condensed">
        <tbody>
          @foreach($files as $file)
          <tr>
            <td>
              <b>
              @if(date("Y-m-d H:i:s") < $file->expired)
                {{ $file->name }}
                  <a href="{{ route('securedownload', $file->token) }}" title="Klik untuk mendownload file ini">
                    <button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i></button> - </a>
                    <i>diunduh: <b id="dl_num">{{($file->download==null||$file->download=='')?'0':$file->download}}x</b></i>
              @else
                {{ $file->name }} - Expired {{ $file->expired }}
              @endif
              </b>
            </td>
          </tr>                    
          @endforeach 
        </tbody>
      </table>
      <p class="muted"><i class="text-danger">Data akan tersedia dan dapat diunduh selama 5 hari kerja sejak data diaktifkan pertama kali.</i></p>
      @if($request->step_done<4)
        <button type="submit" class="btn btn-success" id="penyampaianhasil"><i class="glyphicon glyphicon-check"></i> Penyampaian Hasil</button>
      @endif  
    </div>
  @else
    <!-- <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong><p> Data akan tersedia untuk diunduh setelah <b>Formulir LADU</b> dan <b>Nota Dinas</b> diterima oleh <b>Pusdatin</b>.</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>          
    </div> -->
    <h5>Verifikasi Data</h5>
    <ol>
      <li>
        Silakan mencetak <strong>Formulir LADU</strong> dan <strong>Nota Dinas</strong> untuk ditandatangani oleh Penanggung Jawab Permintaan
        <form>
          @if($isigt!=null && $isother!=null)
          <a href="{{ route('ladu', $request->uuid) }}"><button type="button" name="get" value="form" class="btn btn-sm btn-primary">Cetak Formulir LADU Data Mikro</button></a>
          <a href="{{ route('laduigt', $request->uuid) }}"><button type="button" name="get" value="form" class="btn btn-sm btn-primary">Cetak Formulir LADU IGT</button></a>
          @elseif($isother!=null)
          <a href="{{ route('ladu', $request->uuid) }}"><button type="button" name="get" value="form" class="btn btn-sm btn-primary">Cetak Formulir LADU Data Mikro</button></a>
          @elseif($isigt!=null)
          <a href="{{ route('laduigt', $request->uuid) }}"><button type="button" name="get" value="form" class="btn btn-sm btn-primary">Cetak Formulir LADU IGT</button></a>
          @endif          
          <a href="{{ route('memo', $request->uuid) }}"><button type="button" name="get" value="memo" class="btn btn-sm btn-success">Cetak Nota Dinas</button></a>
          </form>
          </li>
          <li>Isilah <strong>Nomor Nota Dinas</strong> pada formulir Nota Dinas yang dicetak</li>
          <li>
          Kemudian isi <strong>Nomor Nota Dinas</strong> di bawah ini sesuai dengan nomor yang dicetak
          <form id="formStep4">
          <table class="">
            <tr>
              <td width="140">Nomor Nota Dinas</td>
              <td>
                <div class="input-append">
                  <input required name="nd_number" id="nd_number" class="form-control" type="text" value="{{ $request->nd_number }}">
                  {{-- <input required name="nd_number" id="nd_number" class="form-control" type="text" min="1" max="999" value="{{ $request->nd_number }}"> --}}
                  {{-- <span class="add-on">/PP.01.02/Dt.2.2.ND/B/06/2022</span> --}}
                </div>
              </td>
            </tr>
            <tr>
              <td width="140"></td>
              <td>
                <button type="submit" class="btn btn-sm btn-primary" id="submitStep4">Ajukan Permintaan <i class="fa fa-send"></i></button>
              </td>
            </tr>
          </table>
        </form>
      </li>
    </ol>
    <div class="alert alert-info">
      Catatan: Data akan tersedia untuk diunduh setelah <u>Formulir LADU</u> dan <u>Nota Dinas</u> diterima oleh Pusdatin.
    </div>
  @endif
</div>

<script type="text/javascript">
  const getLastItem = thePath => thePath.substring(thePath.lastIndexOf('/') + 1);
  $("#submitStep4").click(function (event) {
    event.preventDefault();
    if($("#formStep4").valid()) {      
      var formData = new FormData($('#formStep4')[0]);
      formData.append("_token", "{{ csrf_token() }}");
      formData.append("step", "4");
      <?php if(isset($request->id))
      echo "formData.append('id', ".$request->id.");"
      ?>
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
            step(4);
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Mohon menunggu proses persetujuan dari Admin, silahkan cek secara berkala permintaan Anda melalui menu Riwayat Permintaan Data Tersedia'
            })
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
  $("#penyampaianhasil").click(function (event) {
    event.preventDefault();      
    var formData = new FormData();
    formData.append("_token", "{{ csrf_token() }}");
    formData.append("step", "4");
    <?php if(isset($request->id))
    echo "formData.append('id', ".$request->id.");"
    ?>
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
          $('#step4').removeClass("active");
          $('#step5').addClass("active");     
          step(5);
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon coba lagi!'
          })
        }
      },
    });
  });
</script>