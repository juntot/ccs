
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="{{ URL::to('/public/assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/aos/aos.js') }}"></script>
  <!-- <script src="{{ URL::to('/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
  <script src="{{ URL::to('/public/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/typed.js/typed.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/php-email-form/validate.js') }}"></script>

  @yield('script')
  
  <!-- Template Main JS File -->
  <script src="{{ URL::to('/public/assets/js/main.js') }}"></script>
  <script src="{{URL::to('/public/js/app.js')}}"></script>
  <script type="module">
    import QrScanner from "/public/bundle.qr.js";
  
</script>
  