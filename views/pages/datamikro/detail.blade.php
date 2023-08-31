<?php
// Turn off all error reporting
error_reporting(0);
?>
<!-- View template master -->
@extends('layouts.index')

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
      <h3>{{ $category->name }}</h3>
    </div>
  </div>
  <hr>
  <div class="border p-3 shadow" style="border-radius: 25px;border-radius: 25px;background-color: #ffffff;margin-bottom:10%;">
    <div class="text-left">
      <div class="span4">
        <h4>Deskripsi</h4>
        <p>
          {{ $category->description }}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-7">
        <h4>Ikhtisar</h4>
        <div class="table-responsive">
          <table class="table table-bordered fields-table">
            <!-- <tr>
              <th class="span3">
                Unit Kerja
              </th>
              <td>
                Pusat Data dan Informasi Perencanaan Pembangunan
              </td>
            </tr> -->
            <tr>
              <th class="table-info col-sm-4">
                Lembaga Sumber Data
              </th>
              <td>
                {{ ($metadata==null) ? '' : $metadata->name }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Frekuensi
              </th>
              <td>
                {{ ($metadata==null) ? '' : $metadata->frequency }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Tag
              </th>
              <td>
                {{$tag->tag}}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Level Penyajian
              </th>
              <td>
                <ul class="" style="list-style-type: none; /* Remove bullets */">
                  @if($metadata->individu == 1) 
                  <li class="" style="border: none;"><i class="fa fa-check-square-o"></i> <label> Individu</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->lokus == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Lokus</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->desa == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Desa</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->lokus == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Kecamatan</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->kecamatan == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Kab/Kota</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->lokus == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Provinsi</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif

                  @if($metadata->kabkot == 1) 
                  <li class=" " style="border: none;"><i class="fa fa-check-square-o"></i> <label>Nasional</label></li>
                  @else
                  <li class=" " style="border: none;"></li>
                  @endif
                </ul>
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Jenis Kegiatan
              </th>
              <td>                
                @if($metadata->jeniskeg == 1) 
                Kompilasi
                @elseif($metadata->jeniskeg == 2) 
                Survei
                @else
                -
                @endif
              </td>
            </tr>
            <tr>
              <th class="table-info">
                {{-- Periode Data --}}
                Tahun Ketersediaan Data
              </th>
              <td>                
                {{ ($metadata==null) ? '' : $metadata->period }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Dipublikasikan Pada
              </th>
              <td>
                {{ date('d M Y H:i:s', strtotime($category->created_at)) }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Diperbarui Pada
              </th>
              <td>
                {{ date('d M Y H:i:s', strtotime($category->updated_at)) }}
              </td>
            </tr>
          </table>

          <h4>Cakupan Data</h4>
          <table class="table table-bordered fields-table">
            <tr>
              <th class="table-info col-sm-4">
                Unit Analisis
              </th>
              <td>
                {{ ($metadata==null) ? '' : $metadata->analysis }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Granularitas
              </th>
              <td>
                {{ ($metadata==null) ? '' : $metadata->granularity }}
              </td>
            </tr>
            <tr>
              <th class="table-info">
                Cakupan Wilayah
              </th>
              <td>
                {{ ($metadata==null) ? '' : $metadata->coverage }}
              </td>
            </tr>
          </table>

          <h4>Aktivitas</h4>
          <table class="table table-bordered fields-table">
            <tr>
              <th class="table-info col-sm-4">Diakses</th>
              <td>{{ $category->access }}</td>
            </tr>
            <tr>
              <th class="table-info">Diunduh</th>
              <td>{{ $download }}</td>
            </tr>
          </table>

          @if($datarenbang!='' && $datarenbang->count()>0)
          <h4>Tabel Data Terkait</h4>
          <table class="table table-bordered fields-table">
            @foreach($datarenbang as $data)
            <tr>
              <td>
                <a target="_blank" href="{{ $data->url }}">{{ $data->title }}</a>
              </td>
            </tr>
            @endforeach
					</table>
          @endif
        </div>
      </div>
      <div class="col-5">
        <h4>Daftar File</h4>
        <div class="table-responsive">
          <table class="table table-bordered table-hover fields-table" style="word-break: break-word;">
            @foreach($files as $file)
              @php
                if($file->type=='docx'){
                  $filetype = 'doc';
                }else{
                  $filetype = $file->type; 
                }
              @endphp
              <tr>
                <td class="col-8">
                  <img src="{{ url('assets/img/filetype/'.$filetype) }}.png" style="float: left; margin: 0 5px 0 0;" />
                  {{ $file->name }}
                </td>
                <th style="text-align:center;">   
                  <button type="button" class="btn btn-sm btn-light border" style="width:121px;@if(in_array($file->id, $cart)) display: none; @endif" id="add{{$file->id}}" onclick="cart('{{ $file->id }}', 'add')">
                    <i class="fa fa-cart-plus"></i> Keranjang
                  </button>           	
                  <button type="button" class="btn btn-sm btn-danger" style="width:121px;@if(!in_array($file->id, $cart)) display: none;@endif " id="delete{{$file->id}}" onclick="cart('{{ $file->id }}', 'delete')" >
                    <i class="fa fa-times"></i> Batal
                  </button>
                  <br>
                  <p style="font-size: 0.7rem">{{ $file->filesize }}</p>
                </th>
              </tr>            
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  function cart(id, action) {
      $.ajax({
        url: "{{ route('cart') }}",
        type: 'POST',
        data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
        beforeSend: function() { 
          $.LoadingOverlay("show", {
            image : "https://dev.bappenas.go.id/datamikro/assets/img/spinner.gif",
          });
        },
        success: function (data) {
          $.LoadingOverlay("hide");
          $('#cart').html(data);
          if (action=='add') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Cek Keranjang Permintaan',
              timer: 3000
            });
            $('#add'+id).css("display","none");
            $('#delete'+id).css("display","block");
          }else{
            $('#add'+id).css("display","block");
            $('#delete'+id).css("display","none");
          }
        },
      });
    }
</script>
@endpush