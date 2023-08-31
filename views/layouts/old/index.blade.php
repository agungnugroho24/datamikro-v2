<!DOCTYPE html>
<html lang="en">

<!-- ======= Header ======= -->
<head>
  @include('layouts.header')
</head>
<!-- ======= End Header ======= -->

<body>

  <!-- ======= Topbar ======= -->
  @include('layouts.topbar')
  <!-- ======= End Topbar ======= -->

  <!-- ======= Navbar ======= -->
  @include('layouts.navbar')
  <!-- ======= End Navbar ======= -->

  <!-- ======= Banner ======= -->
  @yield('banner')
  <!-- ======= End Banner ======= -->

  <main id="main">

    <!-- ======= konten ======= -->
    @yield('konten')
    <!-- ======= konten ======= -->

    <!-- ======= javascript ======= -->
    @stack('script')
    <!-- ======= javascript ======= -->

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <!-- ======= End Footer ======= -->

  <!-- ======= modal delete ======= -->
  @include('modal.modal_del')
  <!-- ======= End modal delete ======= -->

  <!-- ======= JS ======= -->
  @include('layouts.js')
  <!-- ======= End JS ======= -->

</body>

</html>