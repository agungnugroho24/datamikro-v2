<div role="tabpanel" class="tab-pane in active">
  @if(is_null($request) || $request->step_done < 4)
    <div class="alert alert-info">Silakan menyelesaikan Langkah sebelumnya.</div>
  @else
    <h5>Unggah Hasil Akhir</h5>
    <p>Untuk melengkapi knowledge management Bappenas, silakan Anda unggah file hasil olahan data mikro dalam format <b>XLS, XLSX, DOC, DOCX, PPT, PPTX, PDF, ZIP</b>.</p>
    <div class="form-group row mb-3">
      <label for="formFileMultiple" class="col-sm-2 col-form-label mr-3">Upload File</label>
      <fieldset>
        <div class="d-flex justify-content-center bd-highlight">
          <div class="bd-highlight">
            <input class="form-control p-1" type="file" name="files[]" id="files" multiple>
          </div>
          <div class="p-1 bd-highlight">
            <button type="button" class="btn btn-primary btn-sm" onclick="upload('{{ $request->id }}')">
              <i class="fa fa-upload"></i>
              <span>Upload</span>
            </button>
          </div>
          {{-- <div class="p-1 bd-highlight">
            <button type="reset" class="btn btn-warning btn-sm">
              <i class="fa fa-times"></i>
              <span>Cancel</span>
            </button>
          </div> --}}
        </div>
        <div class="loading"></div>
      </fieldset>
    </div>
    <div>
      <table class="table table-bordered fields-table" style="word-break: break-word;">
        <tbody>
          @foreach($hasil as $file)
            @php
              if($file->type=='docx'){
                $filetype = 'doc';
              }else{
                $filetype = $file->type; 
              }
            @endphp
            <tr>
              <td colspan="2">
                <img src="{{ url('assets/img/filetype/'.$filetype) }}.png" style="float: left; margin: 0 5px 0 0;" />
                {{ $file->name }}
              </td>
              <td class="text-center" colspan="2"> 
                {{ $file->filesize }}
              </td>
              <td class="text-center">
                  <button type="button" class="btn btn-sm btn-danger" onclick="del('{{ $file->id }}')">
                    <i class="fa fa-trash"></i>
                  </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<script type="text/javascript">
  function upload(id) {
    var data = document.getElementById('files');
    var formData = new FormData();
    formData.append("_token", "{{ csrf_token() }}")
    formData.append("id", id)
    for(var i=0;i<data.files.length;i++){
      formData.append('files[]', data.files[i]);
    }

    $.ajax({
      url: APP_URL+"/cart/upload",
      type: 'POST',
      data: formData,
      beforeSend: function() { 
        $.LoadingOverlay("show", {
          image : APP_URL+"/assets/img/spinner.gif",
        });
      },
      success: function (data) {
        $.LoadingOverlay("hide");
        if (data!="0") {
          Swal.fire(
            'Berhasil!',
            'Berhasil menambahkan data.',
            'success',
          ).then((value) => {
            step(5);
          });
        }else{
          Swal.fire("Error", "Tambah data gagal, Mohon Coba Lagi", "error");
          // $('#send').prop("disabled", false);
          // $('#send').text('Simpan');
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $.LoadingOverlay("hide");
        // Swal.fire("Error", ""+xhr.responseJSON.errors.files, "error");
        Swal.fire("Error", 'Tipe file yang Anda unggah tidak diizinkan', "error");
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }

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
             url: "{{ route('cart.deletefile') }}",  
             method: "post",  
             data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
             success:function(data){
              Swal.fire(
                'Berhasil!',
                'Berhasil menghapus data.',
                'success',
              ).then((value) => {
                step(5);
              });
            }
          });
        }
      })
    }
</script>