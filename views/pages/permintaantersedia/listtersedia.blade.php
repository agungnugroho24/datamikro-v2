<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Daftar Permintaan Data Tersedia</h3>
    <hr>
    <div class="d-flex mb-2">
      <div class="ml-auto">
        <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian"></input>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table id="listtersedia" class="table table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>Detail Pemohon</th>
              <th class="col-4">Kelengkapan Administrasi</th>
              <th>Data Tersedia</th>
              <th>Penyampaian Hasil</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $dat)
            <tr>
              <td>
                <a href="{{ route('tracking', $dat->uuid) }}">{{ $dat->ladu_no.'/P02.SP/'.date('m', strtotime($dat->request_date)).'/'.date('Y', strtotime($dat->request_date)) }}</a><br>
                Diajukan oleh:<br>
                <span class="label label-info">{{ $dat->name }}</span><br>
                {{ date_format(new DateTime($dat->request_date), "d M y") }}
                <sup><br>{{ date_format(new DateTime($dat->request_date), "H:i:s") }}</sup><br>
                <div class="lead"><a href="https://data.bappenas.go.id/cart/tracking/460" title="Rincian Langkah"><i class="glyphicon glyphicon-time"></i></a></div>
                {{ $dat->uke }}
              </td>
              <td>
                <b><i class="glyphicon glyphicon-check"></i> Penanggung Jawab Permintaan</b>
                <ul>
                  <li>Nama: <b>{{ $dat->responsible_name }}</b></li>
                  <li>NIP: <b>{{ $dat->responsible_nip }}</b></li>
                  <li>Jabatan: <b>{{ $dat->responsible_position }}</b></li>
                  <li>Unit Kerja: <b>{{ $dat->uke }}</b></li>
                  <!-- <li>Ext: <b></b></li> -->
                </ul>
                <b><i class="glyphicon glyphicon-check"></i> Kelengkapan Dokumen</b>
                <ul>
                  <li>Nomor Nota Dinas: <b>{{ $dat->nd_number }}</b></li>
                </ul>
                <b><i class="glyphicon glyphicon-check"></i> Abstraksi</b>
                <ul>
                  <li>Judul: <b>{{ $dat->abstract_title }}</b></li>
                  <li>Isi: <b>{{ $dat->abstract_content }}</b></li>
                  <li>Penulis: <b>{{ $dat->name }}</b></li>
                </ul>
              </td>
              <td>
                <table class="table table-borderless">
                  @foreach($dat->files as $files)
                  <tr style="background-color: transparent;">
                    <td>
                      {{ $files->name }} <i>diunduh: <b>{{ ($files->download==null||$files->download=='')?'0':$files->download}}x</b></i>
                    </td>
                  </tr>
                  @endforeach				
                </table>
              </td>
              <td>
                <div class="row">
                  @foreach($dat->hasils as $file)
                    @php
                      if($file->type=='docx'){
                        $filetype = 'doc';
                      }else{
                        $filetype = $file->type; 
                      }
                    @endphp
                    <div class="col"><a href="{{ route('downloadhasil', $file->id) }}"><img src="{{ url('assets/img/filetype/'.$filetype) }}.png" width="30" style=""></a></div>
                  @endforeach
                </div>
              </td>
              <td>
                @if($dat->request_status=='accept' || $dat->request_status=='complete')
                  Diverifikasi oleh {{ $dat->verifikasi }} pada {{ $dat->acc_date }}
                  <br>
                @endif
                <span class="label label-success">{{ $dat->request_status }}</span>
              </td>
              <td>
                <div class="d-flex flex-column">
                  <div class="">
                    <button type="button" class="btn btn-sm btn-info btn-block mb-1" onclick="modalLadu('{{ $dat->uuid }}')">Cetak LADU</button>
                  </div>
                  <div class="">
                    <button type="button" class="btn btn-sm btn-success btn-block mb-1" @if($dat->request_status=='accept') disabled @endif onclick="accept('{{ $dat->uuid }}')" data-toggle="tooltip" data-placement="left" title="Aktivasi link untuk unduh data">Aktifkan Link</button>
                  </div>
                  <div class="">
                    <button type="button" class="btn btn-sm btn-danger btn-block mb-1" @if($dat->request_status=='reject') disabled @endif onclick="modal('{{ $dat->uuid }}','reject')" data-toggle="tooltip" data-placement="left" title="Menolak permintaan user">Reject</button>
                  </div>
                  <div class="">
                    <button type="button" class="btn btn-sm btn-warning btn-block mb-1" @if($dat->request_status=='pending') disabled @endif onclick="modal('{{ $dat->uuid }}','pending')" data-toggle="tooltip" data-placement="left" title="Mengubah status permintaan menjadi ditunda">Pending</button>
                  </div>
                  <div class="">
                    <button type="button" class="btn btn-sm btn-primary btn-block mb-1" @if($dat->request_status=='complete' || $dat->files[0]->expired==null) disabled @endif onclick="complete('{{ $dat->uuid }}')" data-toggle="tooltip" data-placement="left" title="Penyampaian hasil akhir selesai">Complete</button>
                  </div>
                  <div class="">
                    @if(($dat->request_status=='complete' || $dat->request_status=='accept') && date("Y-m-d H:i:s") > $dat->files[0]->expired)
                  <button type="button" class="btn btn-sm btn-info btn-block mb-1" onclick="modalExpired('{{ $dat->uuid }}', '{{ $dat->files[0]->expired }}')"> Edit Expired</button>
                  @endif
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if ($data->isEmpty())
          <div class="alert alert-warning text-center" role="alert">
            {{-- <b>Data Not Found !</b> --}}
          </div>
          <div class="d-flex flex-row">
            {{-- @elseif(app('request')->input('name') || app('request')->input('slug')) --}}
            <div class="">
              {{-- <a href="{{url('user/search')}}">See All</a><span> | </span> --}}
            </div>
          @else
            <div class="">
              Showing results {{$data->count()}} of {{$data->total()}} entries
              {{-- Showing results <span id="total_records"></span> of <span id="grand_total"></span> entries --}}
            </div>
          @endif
          </div>
        <div class="float-right" style="margin-top: -2%;">
          @if(isset($query))
            {{ $data->appends($query)->links('pagination::bootstrap-4') }}
          @else
            {{ $data->links('pagination::bootstrap-4') }}
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalStatus" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('status') }}" method="post">
                  @csrf
                  @method('POST')
                  <input id="uuid" name="uuid" value="" type="hidden">
                  <input id="status" name="status" value="" type="hidden">
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Catatan</label>
                      <div class="col-sm-12">
                          <textarea id="notes" name="notes" required="" placeholder="Enter Details" class="form-control"></textarea>
                      </div>
                  </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalExpired" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Edit Tanggal Expired Link</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('expired') }}" method="post">
                  @csrf
                  @method('POST')
                  <input id="id" name="id" type="hidden">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Tanggal Expired</label>
                    <div class="col-sm-12 input-group date" id="datetimepicker">
                      <input type="text" class="form-control" id="date" name="date" required/>
                      <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          </div>
                      </div>
                    </div>
                  </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLadu" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Cetak LADU</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('lampiran') }}" method="post">
                  @csrf
                  @method('POST')
                  <input id="laduid" name="laduid" value="" type="hidden">
                  <button type="submit" name="get" value="memo" class="btn btn-success">Form Nota Dinas</button>
                  <span id="ladu">      
                  </span>
                  {{-- <button type="submit" name="get" value="userreport" class="btn btn-info">Get Report</button> --}}
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
  <script type="text/javascript">
    // $(document).ready(function() {
    //   $('#listtersedia').DataTable();
    // } );
    $('#datetimepicker').datetimepicker({
        "showClose": true,
        "showClear": true,
        "showTodayButton": true,
        "format": "YYYY-MM-DD hh:mm:ss",
    });

    function accept(uuid) {
      window.location.replace("{{ url('accept') }}/"+uuid);
    }

    function complete(uuid) {
      window.location.replace("{{ url('complete') }}/"+uuid);
    }

    function modal(uuid,status) {
      $('#modalStatus').modal("show");  
      $('#uuid').val(uuid); 
      $('#status').val(status);
      $('#modelHeading').html("Status "+status);
    }

    function modalExpired(uuid, tgl) {
      $('#modalExpired').modal("show");  
      $('#id').val(uuid); 
      $('#date').val(tgl);
    }

    function modalLadu(uuid) {
      $('#ladu').empty();
      $.ajax({
        type : 'get',
        url: "{{ route('laduType') }}",
        data:{'uuid':uuid},
        success:function(data){
          data = JSON.parse(data);
          console.log(data);
          $('#modalLadu').modal("show");  
          $('#laduid').val(uuid); 
          if (data.isigt>0 && data.isother>0) {
            var button = '<button type="submit" name="get" value="form" class="btn btn-primary">Form LADU Data Mikro</button> <button type="submit" name="get" value="igt" class="btn btn-primary">Form LADU IGT</button>';
            $("#ladu").append(button);
          }else if(data.isigt>0){
            var button = '<button type="submit" name="get" value="igt" class="btn btn-primary">Form LADU IGT</button>';
            $("#ladu").append(button);            
          }else if(data.isother>0){
            var button = '<button type="submit" name="get" value="form" class="btn btn-primary">Form LADU Data Mikro</button>';
            $("#ladu").append(button);            
          }
        }
      });
    }

    var APP_URL = {!! json_encode(url('/')) !!};
    $('#search').on('keyup',function(){
      $value=$(this).val();
      $.ajax({
        type : 'get',
        url: "{{ route('listtersedia.dt') }}",
        data:{'search':$value},
        success:function(data){
          $('tbody').html(data);
        }
      });
    })
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>
@endpush