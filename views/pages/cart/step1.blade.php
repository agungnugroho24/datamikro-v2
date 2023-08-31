  <div role="tabpanel" class="tab-pane in active">
    <div id="step-pilih" style="z-index:0;">
      @if($uuid!=null)
        <h5>Pilih Data</h5>
        <p>Data Tersedia:</p>
        <table class="table table-condensed">
          @foreach($data as $data)
          <tr>
            <td>
              <b>{{ $data->name }}</b>
            </td>            
          </tr>
          @endforeach
        </table>
        <span class="muted"><i class="text-info">Tanggal pengajuan: {{ date_format(new DateTime($request_data->request_date), "d M y") }}<sup>{{ date_format(new DateTime($request_data->request_date), "H:i:s") }}</sup></i></span>      
      @else
        @if($cookie!=null)
          <h5>Pilih Data</h5>
          <p>Data Tersedia:</p>
          <table class="table table-condensed">
            @foreach($data as $data)
            <tr>
              <td>
                <b>{{ $data->name }}</b>
              </td>            
            </tr>
            @endforeach
          </table>
          <span class="muted"><i class="text-info">Tanggal pengajuan: {{ date_format(new DateTime($request_data->request_date), "d M y") }}<sup>{{ date_format(new DateTime($request_data->request_date), "H:i:s") }}</sup></i></span>
        @else
          @if($cart->count() > 0)
            <h5>Pilih Data</h5>
            <p>Data Tersedia:</p>
            <table class="table table-condensed">
              @foreach($cart as $cart)
              <tr>
                <td>
                  <b>{{ $cart->name }}</b>
                  <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="del( '{{$cart->id}}' )">
                    <i class="fa fa-times"></i>
                  </button>
                </td>            
              </tr>
              @endforeach
            </table>
            <button type="submit" class="btn btn-sm btn-primary" onclick="kirim()">Lanjut ke langkah 2 <i class="fa fa-chevron-right"></i></button>
          @else
            <div class="alert alert-info">Keranjang Kosong, tidak ada data yang dapat ditampilkan.</div>   
          @endif       
        @endif
      @endif
    </div>
  </div>


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
           url: "{{ route('cart') }}",  
           method: "post",  
           data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
           success:function(data){
            Swal.fire(
              'Berhasil!',
              'Berhasil menghapus data.',
              'success'
            ).then((value) => {
              $('#cart').html(data);
              step(1);
            });
          }
        });
      }
    })
  }

  function kirim() {
    $.ajax({
      url: "{{ route('requestData') }}",
      type: 'POST',
      data: { 'step': 1,'_token': "{{ csrf_token() }}" }, 
      beforeSend: function() { 
        $.LoadingOverlay("show");
      },
      success: function (data) {
        $.LoadingOverlay("hide");
        if (data!=0) {
          $('#step1').removeClass("active");
          $('#step2').addClass("active");
          step(2);
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon coba lagi!'
          })
        }
      },
    });
  }
</script>