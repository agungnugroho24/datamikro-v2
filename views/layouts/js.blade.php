
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/jquery.3.2.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.4.4.1.min.js') }}"></script>

  <!-- DataTable -->
  {{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}

  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

  <!-- Loading -->
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
  

  <script type="text/javascript">
  // ---------------------------------------------------------
  // Bootstrap 4 : Responsive Dropdown Multi Submenu
  // ---------------------------------------------------------
  $(function(){
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show'); 			// ul
      $(this).parent().toggleClass('show'); 	// li parent

      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass('show'); 	// ul
        $('.dropdown-submenu.show').removeClass('show'); 		// li parent
      });
      return false;
    });
  });

  // Modal
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
  </script>
@stack('scripts')