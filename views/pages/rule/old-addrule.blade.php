<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container py-5">
  <div class="text-left">
    <h3>Tambah Rule</h3>
    <hr>
  </div>
  <div class="row border p-3" style="border-radius: 25px;">
    <div class="col-lg-12">
      <div class="col-lg-12">
        <form accept-charset="utf-8">
          <ul id="tree3">
            <li><a href="#" class="text-uppercase">Dashboard</a>
              <ul>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch1">
                    <label class="form-check-label" for="switch1">Open dashboard page</label>
                  </div>
                </li>
              </ul>
            </li>
            <li><a href="#" class="text-uppercase">Users</a>
              <ul>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch2">
                    <label class="form-check-label" for="switch2">Add User</label>
                  </div>
                </li>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch3">
                    <label class="form-check-label" for="switch3">Edit User</label>
                  </div>
                </li>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch4">
                    <label class="form-check-label" for="switch4">Delete User</label>
                  </div>
                </li>
              </ul>
            </li>
            <li><a href="#" class="text-uppercase">Roles & Permissions</a>
              <ul>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch5">
                    <label class="form-check-label" for="switch5">Add Roles</label>
                  </div>
                </li>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch6">
                    <label class="form-check-label" for="switch6">Edit Roles</label>
                  </div>
                </li>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch7">
                    <label class="form-check-label" for="switch7">Delete Roles</label>
                  </div>
                </li>
                <li>
                  <div class="form-check form-switch">
                    <input type="checkbox" role="switch" class="form-check-input" id="switch8">
                    <label class="form-check-label" for="switch8">Update Permissions</label>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
          <div class="bd-example mt-2" style="margin-left: 2.5%;">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a href="{{ url('rule') }}">
              <button type="button" class="btn btn-secondary btn-sm">Batal</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $.fn.extend({
      treed: function (o) {
        
        var openedClass = 'fa fa-chevron-down';
        var closedClass = 'fa fa-chevron-right';
        
        if (typeof o != 'undefined'){
          if (typeof o.openedClass != 'undefined'){
          openedClass = o.openedClass;
          }
          if (typeof o.closedClass != 'undefined'){
          closedClass = o.closedClass;
          }
        };
        
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
        tree.find('.branch .indicator').each(function(){
          $(this).on('click', function () {
              $(this).closest('li').click();
          });
        });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
      }
    });

    //Initialization of treeviews
    $('#tree3').treed({openedClass:'fa fa-chevron-down', closedClass:'fa fa-chevron-right'});
  </script>
@endpush