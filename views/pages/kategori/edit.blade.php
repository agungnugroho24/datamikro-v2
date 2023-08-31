<?php
// Turn off all error reporting
error_reporting(0);
?>
<!-- View template master -->
@extends('layouts.index') 

@push('styles')
<style>
  .box1 { border:1px solid #ccc; height: 100px; overflow-y: scroll;}
  .box2 { border:1px solid #ccc; height: 165px; overflow-y: scroll;}
</style>
@endpush
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left mb-3">
    <h3>Edit Kategori Data Dasar</h3>
    {{-- <hr> --}}
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form role="form" action="{{ route('category.edit', $category->slug) }}" method="post" >
        @csrf
        <div class="form-group row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Kategori Data Dasar" value="{{ old('name', $category->name) }}">
              @error('name')
              <div class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
          </div>
        </div>        
        <div class="form-group row mb-3">
          <label for="slug" class="col-sm-2 col-form-label">Slug</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required readonly>
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="description">Description</label>
          </div>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description">{{ old('description', $category->description) }}</textarea>
          </div>
        </div>

        <hr>
        <legend>Ikhtisar</legend>
        <div class="form-group row mb-3">
          <label for="tags" class="col-sm-2 col-form-label">Sumber Data</label>
          <div class="col-sm-10">
            <div class="box2 p-2">
              @foreach($source as $source)
              <input type="radio" name="source" id="source" value="{{ $source->id }}" {{ ($metadata==null) ? '' : ($source->id==$metadata->source_id) ? 'checked' : '' }} /> {{ $source->name }}<br/>
              @endforeach
            </div>
          </div>
        </div> 
        <div class="form-group row mb-3">
          <label for="frequency" class="col-sm-2 col-form-label">Frekuensi Updating Data</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="frequency" name="frequency" value="{{ old('frequency', ($metadata==null) ? '' : $metadata->frequency) }}">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="tags" class="col-sm-2 col-form-label">Kata Kunci/Tag</label>
          <div class="col-sm-10">
              <select class="form-control" id="tags" name="tags[]" multiple>
                @foreach($tag as $tag)
                <option value="{{$tag->tag}}" selected>{{$tag->tag}}</option>
                @endforeach
              </select>
          </div>
        </div> 
        <div class="form-group row mb-3">
          <label for="time_period" class="col-sm-2 col-form-label">Level Penyajian</label>
          <div class="col-sm-10">
            <div class="box2 p-2">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="individu" name="individu" value="1" {{ $metadata->individu ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Individu
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="lokus" name="lokus" value="1" {{ $metadata->lokus ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Lokus
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="desa" name="desa" value="1" {{ $metadata->desa ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Desa
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="kecamatan" name="kecamatan" value="1" {{ $metadata->kecamatan ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Kecamatan
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="kabkot" name="kabkot" value="1" {{ $metadata->kabkot ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Kab/Kota
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="provinsi" name="provinsi" value="1" {{ $metadata->provinsi ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Provinsi
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="nasional" name="nasional" value="1" {{ $metadata->nasional ? 'checked' : '' }}>
                <label class="form-check-label" for="gridCheck1">
                  Nasional
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="time_period" class="col-sm-2 col-form-label">Jenis Kegiatan</label>
          <div class="col-sm-10">
            <select class="form-control" id="jeniskeg" name="jeniskeg">
              <option value="0" @if($metadata->jeniskeg=="0") selected @endif disabled>-- Pilih --</option>
              <option value="1" @if($metadata->jeniskeg=="1") selected @endif>Kompilasi</option>
              <option value="2" @if($metadata->jeniskeg=="2") selected @endif>Survei</option>
            </select>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="time_period" class="col-sm-2 col-form-label">Tahun Ketersediaan Data</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="period" name="period" value="{{ old('period', ($metadata==null) ? '' : $metadata->period) }}">
          </div>
        </div>
        <hr>
        <legend>Dataset Summary</legend>      
        <div class="form-group row mb-3">
          <label for="released_at" class="col-sm-2 col-form-label">Tanggal Dirilis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="released_date" name="released_date" value="{{ old('released_date', ($metadata==null) ? '' : $metadata->released_date) }}">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="next_update" class="col-sm-2 col-form-label">Pembaruan Selanjutnya</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="update" name="update" value="{{ old('update', ($metadata==null) ? '' : $metadata->update) }}">
          </div>
        </div>
        
        <hr>
        <legend>Data Coverage</legend>
        <div class="form-group row mb-3">
          <label for="unit" class="col-sm-2 col-form-label">Unit Analysis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="analysis" name="analysis" value="{{ old('analysis', ($metadata==null) ? '' : $metadata->analysis) }}">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="granularity" class="col-sm-2 col-form-label">Granularity</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="granularity" name="granularity" value="{{ old('granularity', ($metadata==null) ? '' : $metadata->granularity) }}">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="geo_coverage" class="col-sm-2 col-form-label">Cakupan Geografis</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="coverage" name="coverage" value="{{ old('coverage', ($metadata==null) ? '' : $metadata->coverage) }}">
          </div>
        </div>
                  
        <hr>
        <legend>External Links</legend>
        <div class="form-group row mb-3">
          <label for="ext_link_name" class="col-sm-2 col-form-label">Nama Tautan</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="link_name" name="link_name" value="{{ old('link_name', ($metadata==null) ? '' : $metadata->link_name) }}">
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="ext_link_source" class="col-sm-2 col-form-label">Sumber Tautan</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="link" name="link" value="{{ old('link', ($metadata==null) ? '' : $metadata->link) }}">
          </div>
        </div>

        <hr>
        <legend>Files</legend>
        <div class="form-group row mb-3">
          <label for="formFileMultiple" class="col-sm-2 col-form-label mr-3">Upload File</label>
          <fieldset>
            <div class="d-flex justify-content-center bd-highlight">
              <div class="bd-highlight">
                <input class="form-control p-1" type="file" name="files[]" id="files" multiple>
              </div>
              <div class="p-1 bd-highlight">
                <button type="button" class="btn btn-primary btn-sm" onclick="upload()" id="buttonUpload">
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
            <div class="laoding"></div>
          </fieldset>
        </div>

        <table class="table table-bordered fields-table" style="word-break: break-word;">
        	@foreach($files as $file)
	        	@php
	        		if($file->type=='docx'){
		        		$filetype = 'doc';
		        	}else{
		        		$filetype = $file->type; 
			        }
	        	@endphp
    				<tr>
    					<td>
    					  <img src="{{ url('assets/img/filetype/'.$filetype) }}.png" style="float: left; margin: 0 5px 0 0;" />
    					  {{ $file->name }}
    					</td>
    					<td class="text-center col-1"> 
    					  {{ $file->filesize }}
    					</td>
    					<td class="text-center">
    					    <button type="button" class="btn btn-sm btn-danger" onclick="del('{{ $file->id }}')">
    					      <i class="fa fa-trash"></i>
    					    </button>
    					</td>
    				</tr>
          	@endforeach
        </table>
        <div class="bd-example">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a href="{{ url('datadasar') }}">
            <button type="button" class="btn btn-secondary btn-sm">Batal</button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@push('scripts')
  <script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!};
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch(APP_URL+'/category/checkSlug?name='+name.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug);
    });

    $("#tags").select2({
      tags: true,
      tokenSeparators: [',', ' '],
      multiple: true
    });

    function upload() {
      var data = document.getElementById('files');
      var formData = new FormData();
      formData.append("_token", "{{ csrf_token() }}")
      formData.append("id", "{{ $category->id }}")
      for(var i=0;i<data.files.length;i++){
        formData.append('files[]', data.files[i]);
      }

      $.ajax({
        url: APP_URL+"/category/upload",
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
      				location.reload();
      			});
          }else{
            Swal.fire("Error", "Tambah data gagal, Mohon Coba Lagi", "error");
            // $('#send').prop("disabled", false);
            // $('#send').text('Simpan');
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          $.LoadingOverlay("hide");
          Swal.fire("Error", ""+xhr.responseJSON.errors.files, "error");
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
             url: "{{ route('category.deletefile') }}",  
             method: "post",  
             data: { 'id': id,'_token': "{{ csrf_token() }}" }, 
             success:function(data){
              Swal.fire(
                'Berhasil!',
                'Berhasil menghapus data.',
                'success',
              ).then((value) => {
                location.reload();
              });
            }
          });
        }
      })
    }
  </script>
@endpush