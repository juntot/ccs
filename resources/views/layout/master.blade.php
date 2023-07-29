<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>
    @include('layout.nav')

    @yield('main')
    <!-- Footer -->
    @include('layout.footer')
    <!-- End of Footer -->
        
</body>

</html>