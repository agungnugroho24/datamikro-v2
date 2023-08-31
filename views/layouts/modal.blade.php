<!-- Modal -->
<div class="modal fade" id="customdata" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customdataLabel">Formulir Pengajuan Data Mikro Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="formnotavailable">
      @csrf
      @method('POST')
      <div class="modal-body">
        <!-- ======= Permintaan Data Lain ======= -->
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Nama Data</label>
              <div class="col-sm-10">
                <input name="nama" type="text" id="nama" placeholder="Nama Data" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Tahun</label>
              <div class="col-sm-10">
                <input name="tahun" type="text" id="tahun" placeholder="Tahun" class="form-control" maxlength="4" onkeypress="return hanyaAngka(event)" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="nama" class="col-sm-2 col-form-label">Cakupan Wilayah</label>
              <div class="col-sm-10">
                <input name="cakupan" type="text" id="cakupan" placeholder="Cakupan Wilayah" class="form-control" required>
              </div>
            </div>
            <!-- <div class="form-group row">
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
            <div class="form-group row">
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
        <button type="submit" class="btn btn-sm btn-primary" id="submitnotavailable">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  $("#submitnotavailable").click(function (event) {
    event.preventDefault();
    if($("#formnotavailable").valid()) {      
      var str="Jumlah data yang diajukan maksimal 3\n" +
              "<b>Mengacu pada perban BPS</b>";
      var formData = new FormData($('#formnotavailable')[0]);
      $.ajax({
        url: "{{ route('addData') }}",
        type: 'POST',
        data: formData, 
        processData: false,
        contentType: false,
        beforeSend: function() { 
          $.LoadingOverlay("show");
        },
        success: function (data) {
          $.LoadingOverlay("hide");
          if (data==1) {
            Swal.fire(
              'Berhasil!',
              'Berhasil menambahkan data.',
              'success'
            ).then((value) => {
              window.location = "{{ route('/') }}";
            });
          }else if(data==2){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              html: '<pre>' + str + '</pre>',
              customClass: {
                popup: 'format-pre'
              }
              // text: 'Jumlah data yang diajukan maksimal 3'
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
</script>
@endpush
