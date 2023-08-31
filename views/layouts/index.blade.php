<!DOCTYPE html>
<html lang="en">

<!-- ======= Header ======= -->
<head>
  @include('layouts.header')
  
  @stack('styles')
</head>
<!-- ======= End Header ======= -->

<body class="pt-5">

  <!-- ======= Navbar ======= -->
  @include('layouts.navbar')
  <!-- ======= End Navbar ======= -->

  <main role="main" class="container">

    <!-- ======= konten ======= -->
    @yield('konten')
    <!-- ======= konten ======= -->

    <!-- ======= Javascript ======= -->
    @stack('scripts')
    <!-- ======= End Javascript ======= -->

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <!-- ======= End Footer ======= -->

  <!-- ======= Modal ======= -->
  @include('layouts.modal')
  <!-- ======= End JS ======= -->

  <!-- ======= JS ======= -->
  @include('layouts.js')
  <!-- ======= End JS ======= -->

</body>

</html>