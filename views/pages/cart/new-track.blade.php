<!-- View template master -->
@extends('layouts.index')

@push('styles')
<style>
a:hover,a:focus{
  outline: none;
  text-decoration: none;
}
.tab .nav-tabs{ border-bottom: 5px solid #006600; }
.tab .nav-tabs li a{
  display: block;
  padding: 10px;
  border: 2px solid #006600;
  border-radius: 0;
  background: #fff;
  font-size: 20px;
  font-weight: 700;
  color: #006600;
  text-align: center;
  margin: 0 5px 30px 0;
  z-index: 1;
  position: relative;
  transition: all 0.3s ease 0s;
}
.tab .nav-tabs li a:hover,
.tab .nav-tabs li.active a{
  color: #006600;
  border: 2px solid #006600;
}
.tab .nav-tabs li a:before{
  content: "";
  width: 15px;
  height: 15px;
  background: #006600;
  border-radius: 50%;
  margin: 0 auto;
  position: absolute;
  bottom: -40px;
  left: 0;
  right: 0;
}
.tab .nav-tabs li.active a:before{
  background: #00CC66;
  border: 2px solid #fff;
  box-shadow: 0 0 3px 1px rgba(0, 0, 0, 0.25);
  transform: scale(2);
}
.tab .tab-content{
  padding: 20px;
  margin-top: 0;
  border-radius: 0 0 5px 5px;
  font-size: 15px;
  color: #000000;
  background: #fff;
  line-height: 30px;
}
.tab .tab-content h3{
  font-size: 24px;
  margin-top: 5px;
}
@media only screen and (max-width: 479px){
  .tab .nav-tabs li{
    width: 100%;
    text-align: center;
  }
  .tab .nav-tabs li a{
    margin-right: 0;
    margin-bottom: 20px;
  }
  .tab .nav-tabs li a:before,
  .tab .nav-tabs li.active a:before{
    width: 0;
    height: 0;
    background: none;
    box-shadow: none;
    border: none;
    bottom: -10px;
    transform: scale(1);
  }
  .tab .nav-tabs li.active a:before{
    border-top: 10px solid #00CC66;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
  }
}
</style>
@endpush
 
<!-- Konten -->
@section('konten')
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
  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="tab" role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs text-center" role="tablist">
          <li role="presentation" class="active mr-4" id="step1">
            <a href="#Section1" aria-controls="home" role="tab" data-toggle="tab" onclick="step(1)">
              <h5 class="responsive-font-example">
              Pilih Data
              </h5>
            </a>
          </li>
          <li role="presentation" class="mr-4" id="step2">
            <a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab" onclick="step(2)">
              <h5 class="responsive-font-example">
              Kelengkapan
              </h5>
            </a>
          </li>
          <!-- <li role="presentation" class="mr-4" id="step3">
            <a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab" onclick="step(3)">
              <h5 class="responsive-font-example">
              Verifikasi ND
              </h5>
            </a>
          </li> -->
          <li role="presentation" class="mr-4" id="step4">
            <a href="#Section4" aria-controls="messages" role="tab" data-toggle="tab" onclick="step(4)">
              <h5 class="responsive-font-example">
              Verifikasi Data
              </h5>
            </a>
          </li>
          <li role="presentation" class="mr-4" id="step5">
            <a href="#Section5" aria-controls="messages" role="tab" data-toggle="tab" onclick="step(5)">
              <h5 class="responsive-font-example">
              Unggah Hasil Akhir
              </h5>
            </a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabs border p-3 mt-4" style="border-radius: 25px;" id="tabisi">
          <!-- <div role="tabpanel" class="tab-pane in active" id="Section1">
            <div id="step-pilih" style="z-index:0;">
              <h5>Pilih Data</h5>
              <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
              <p>Data Tersedia:</p>
              <table class="table table-condensed">
                <td>
                  <b>Data Ekspor Impor - Kompilasi Data Statistik Impor 2016.zip</b>
                  <button id="deletefromcart" type="button" class="btn btn-danger btn-sm" title="Hapus" data-rowid="1c49511bd1f8d98fc11423ffaabed2c9">
                    <i class="fa fa-times"></i>
                  </button>
                </td>
                <tr>
                  <td>
                    <span style="color:red;font-style:italic;">This file is not available to download.</span>
                  </td>
                </tr>
              </table>
              <span class="muted">Tanggal pengajuan: Hari ini, 07:24:37</span>
              <div class="alert alert-info">Keranjang Kosong, tidak ada data yang dapat ditampilkan.</div>
              <form class="form-inline">
                <button type="submit" class="btn btn-sm btn-primary">Lanjut ke langkah 2 <i class="fa fa-chevron-right"></i></button>
              </form>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="Section2">
            <h5>Kelengkapan Dokumen</h5>
            <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
            <div class="alert alert-info">Anda belum di assign ke Unit Kerja manapun, silakan hubungi pusdatin di ext. 2307/1403</div>
            <ol>
              <form>
                <li>
                  <strong>Penanggung Jawab Permintaan</strong>
                  <table class="" id="" style="display:none">
                    <tr>
                      <td colspan="2">Silakan tulis nama Pejabat Plt. (Pelaksana Tugas) sebagai Pemohon Data:</td>
                    </tr>
                    <tr>
                      <td width="140">Nama</td>
                      <td><input required type="text" name="namapenerima" class="span5" placeholder="Nama" title="Nama" value=""></td>
                    </tr>
                    <tr>
                      <td>NIP</td>
                      <td><input type="text" name="nippenerima" class="span3" placeholder="NIP" title="NIP (opsional)" value=""></td>
                    </tr>
                    <tr>
                      <td>Jabatan</td>
                      <td><input required readonly type="text" name="jabatanpenerima" class="span6" placeholder="Jabatan" title="Jabatan" value=""></td>
                    </tr>
                  </table>
                  <ul id="">
                    <li>Nama : Mohammad Irfan Saleh, ST, MPP, Ph.D</li>
                    <li>NIP : 197510252002121002</li>
                    <li>Jabatan : Plt_kepala Pusat Data dan Informasi Perencanaan Pembangunan</li>
                  </ul>
                </li>
                <li>
                  <strong>Isi Variabel</strong> (<a href='https://microdata.bps.go.id/mikrodata/index.php/catalog/SUSENAS' target='_blank' style=''><b>Kamus data</b></a>)
                  <div class="form-group row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Variabel</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="variabel" name="variabel" style='text-transform:uppercase' placeholder='B1R1, B2R2, dst' required>
                    </div>
                  </div>
                </li>
                <li>
                  <strong>Isi Kode Klasifikasi/Arsip</strong> (<a href="https://data.bappenas.go.id/kode_arsip" target="_blank"><b>Klik disini</b></a> untuk melihat kode Klasifikasi/Arsip)
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
                      <input type="text" class="form-control" id="penulis" name="penulis" value="paijo.dermawan" required readonly>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Lanjut ke Langkah 3 <i class="fa fa-chevron-right"></i></button>
                </li>
              </form>
            </ol>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="Section3">
            <h5>Verifikasi</h5>
            <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
            <ul>
              <li>
                <strong>Kesesuaian Nota Dinas yang diterima</strong>
                <div class="form-group row">
                  <label for="nama" class="col-sm-2 col-form-label">Nomor Nota Dinas</label>
                  <div class="col-sm-10">
                    <p>/PP.01.02/Dt.2.2.ND/B/06/2022</p>
                    <button type="button" class="btn btn-sm btn-success" onclick="" disabled="" title="Klik untuk membuka link download"><i class="fa fa-check"></i> Sesuai</button>
                    <button type="button" class="btn btn-sm btn-danger flip" id="declinebtn" title="Klik untuk memberikan keterangan"><i class="fa fa-times"></i> Tidak sesuai</button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="nama" class="col-sm-2 col-form-label">Keterangan</label>
                  <div class="col-sm-10">
                    <div id="declinediv" class="panel" style="display: none;">
                      <h4>Pesan penolakan untuk permintaan data #467</h4>
                      <form method="">
                        Silakan tulis Catatan/Pesan untuk Pemohon Data:<br>
                        <textarea required="" class="form-control col-sm-12 mb-2" name="notes" id="notes"></textarea>
                        <button type="submit" class="btn btn-sm btn-danger mb-2">Tolak</button>
                      </form>
                    </div>
                    <div id="successmsg" class="alert alert-success">Nota Dinas sudah sesuai dengan yang diterima.</div>	
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="Section4">
            <h5>Verifikasi Data</h5>
            <div class="alert alert-info">
              Silakan menyelesaikan Langkah sebelumnya.
            </div>
            <ol>
              <li>
                Silakan mencetak <strong>Formulir LADU</strong> dan <strong>Nota Dinas</strong> untuk ditandatangani oleh Penanggung Jawab Permintaan
                <form method="post" action="https://data.bappenas.go.id/cart/download/467">
                  <input type="hidden" name="namapenerima" value="Mia Amalia, ST, MSi, Ph.D">
                  <input type="hidden" name="jabatanpenerima" value="Plt_direktur Pembangunan Daerah">
                  <input type="hidden" name="nippenerima" value="197503262000032001">
                  <button type="submit" name="get" value="form" class="btn btn-sm btn-primary">Cetak Formulir LADU Data Mikro</button>
                  <button type="submit" name="get" value="memo" class="btn btn-sm btn-success">Cetak Nota Dinas</button>
                  </form>
                  </li>
                  <li>Isilah <strong>Nomor Nota Dinas</strong> pada formulir Nota Dinas yang dicetak</li>
                  <li>
                  Kemudian isi <strong>Nomor Nota Dinas</strong> di bawah ini sesuai dengan nomor yang dicetak
                  <form method="post" action="https://data.bappenas.go.id/cart/kirimnonota/467">
                  <table class="">
                    <tr>
                      <td width="140">Nomor Nota Dinas</td>
                      <td>
                        <div class="input-append">
                          <input required name="nd_number" class="span1" type="number" min="1" max="999" value="">
                          <span class="add-on">/PP.01.02/Dt.2.2.ND/B/06/2022</span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td width="140"></td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-primary">Ajukan Permintaan <i class="fa fa-send"></i></button>
                      </td>
                    </tr>
                  </table>
                </form>
              </li>
            </ol>
            <div class="alert alert-info">
              Catatan: Data akan tersedia untuk diunduh setelah <u>Formulir LADU</u> dan <u>Nota Dinas</u> diterima oleh Pusdatin.
            </div>
            <p class="text-muted">Data akan tersedia dan dapat diunduh selama 5 hari kerja sejak data diaktifkan pertama kali.</p>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="Section5">
            <h5>Unggah Hasil Akhir</h5>
            <p>Untuk melengkapi knowledge management Bappenas, silakan Anda unggah file hasil olahan data mikro dalam format PDF di sini.</p>
            <div class="form-group row mb-3">
              <label for="formFileMultiple" class="col-sm-2 col-form-label mr-3">Upload File</label>
              <fieldset>
                <div class="d-flex justify-content-center bd-highlight">
                  <div class="bd-highlight">
                    <input class="form-control p-1" type="file" name="files[]" id="files" multiple>
                  </div>
                  <div class="p-1 bd-highlight">
                    <button type="button" class="btn btn-primary btn-sm" onclick="upload()">
                      <i class="fa fa-upload"></i>
                      <span>Upload</span>
                    </button>
                  </div>
                  <div class="p-1 bd-highlight">
                    <button type="reset" class="btn btn-warning btn-sm">
                      <i class="fa fa-times"></i>
                      <span>Cancel</span>
                    </button>
                  </div>
                </div>
                <div class="loading"></div>
              </fieldset>
            </div>
            <div>
              <table class="table table-bordered fields-table" style="word-break: break-word;">
                <tbody>
                  <tr>
                    <td>
                    <img src="https://dev.bappenas.go.id/datamikro/assets/img/filetype/xlsx.png" style="float: left; margin: 0 5px 0 0;">
                    dataloguser2.xlsx
                    </td>
                    <td class="text-center col-1"> 
                    11 KB
                    </td>
                    <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="del('3')">
                      <i class="fa fa-trash"></i>
                    </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <img src="https://dev.bappenas.go.id/datamikro/assets/img/filetype/csv.png" style="float: left; margin: 0 5px 0 0;">
                    results-survey731378.csv
                    </td>
                    <td class="text-center col-1"> 
                    17 KB
                    </td>
                    <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="del('5')">
                      <i class="fa fa-trash"></i>
                    </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <img src="https://dev.bappenas.go.id/datamikro/assets/img/filetype/pdf.png" style="float: left; margin: 0 5px 0 0;">
                    S-127 (10 MARET 22).pdf
                    </td>
                    <td class="text-center col-1"> 
                    3 MB
                    </td>
                    <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="del('6')">
                      <i class="fa fa-trash"></i>
                    </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
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