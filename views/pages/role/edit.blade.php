<!-- View template master -->
@extends('layouts.index')

@push('styles')
<style>
.plus, .minus {
  display: inline-block; 
  background-repeat: no-repeat;
  background-size: 16px 16px !important;
  width: 16px;
  height: 16px; 
  /*vertical-align: middle;*/
}

.plus {
  background-image: url(https://img.icons8.com/color/48/000000/plus.png);
}

.minus {
  background-image: url(https://img.icons8.com/color/48/000000/minus.png);
}

ul {
  list-style: none;
  padding: 0px 0px 0px 20px;
}

ul.inner_ul li:before {
  content: "├";
  font-size: 18px;
  margin-left: -11px;
  margin-top: -5px;
  vertical-align: middle;
  float: left;
  width: 8px;
  color: #41424e;
}

ul.inner_ul li:last-child:before {
  content: "└";
}

.inner_ul {
  padding: 0px 0px 0px 35px;
}
</style>
@endpush
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Edit Role</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <form role="form" action="{{ route('role.edit', $role->name) }}" method="post" >
        @csrf
        <div class="form-group row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" name="display_name" placeholder="Nama Role" value="{{ old('display_name', $role->display_name) }}" placeholder="Nama Role">
            @error('display_name')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-3">
          <div class="col-sm-2">
            <label for="exampleFormControlTextarea1">Deskripsi</label>
          </div>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description">{{ old('description', $role->description) }}</textarea>
          </div>
          <ul id="" class="main_ul">
            @php
            if($data){
              $hasil = explode(',', $data->isi);            
            }else{
              $hasil = array();
            }
            @endphp
            @foreach($permission as $permission)
            <li id="">
              @if(count($permission->child) > 0)
              <span class="plus">&nbsp;</span>
              @else              
              <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
              @endif
              <input type="checkbox" id="menu[]" name="menu[]" value="{{ $permission->id }}" 
                @if(in_array($permission->id,$hasil)) checked @endif 
              />
              <span>{{ $permission->display_name }}</span>
              <ul id="" style="display: none" class="inner_ul">
                @foreach($permission->child as $child)
                <li id="">
                  <input type="checkbox" id="menu[]" name="menu[]" value="{{ $child->id }}" 
                    @if(in_array($child->id,$hasil)) checked @endif 
                  /><span> {{ $child->display_name }} </span>
                </li>
                @endforeach
              </ul>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="bd-example">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a href="{{ url('role') }}">
            <button type="button" class="btn btn-secondary btn-sm">Batal</button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function () {
  $(".plus").click(function () {
    $(this).toggleClass("minus").siblings("ul").toggle();
  })
})

function check_fst_lvl(dd) {
  //var ss = $('#' + dd).parents("ul[id^=bs_l]").attr("id");
  var ss = $('#' + dd).parent().closest("ul").attr("id");
  if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
    //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', true);
    $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
  }
  else {
    //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', false);
    $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
  }
}

function pageLoad() {
  $(".plus").click(function () {
    $(this).toggleClass("minus").siblings("ul").toggle();
  })
}
</script>
@endpush