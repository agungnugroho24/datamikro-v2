<div role="tabpanel" class="tab-pane in active">
  @if($cart->count() > 0 || is_null($request) || $request->step_done < 2)
    <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
  @else
    <h5>Verifikasi</h5>
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
  @endif
</div>