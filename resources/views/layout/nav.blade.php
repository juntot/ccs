<!-- ======= Mobile nav toggle button ======= -->
  <!-- <button type="button" class="mobile-nav-toggle d-xl-none"><i class="bi bi-list mobile-nav-toggle"></i></button> -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex flex-column justify-content-center">
  
    <nav id="navbar" class="navbar nav-menu">
      <ul>
        <li><a href="{{ URL::route('home') }}" class="nav-link scrollto {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"><i class="bx bx-home"></i> <span>Home</span></a></li>
        
        
        @if(Route::currentRouteName() == 'scan')
        <li><a id="startscan" href="#contact" class="nav-link scrollto"><i class='bx bx-play'></i> <span>Play</span></a></li>
        <li><a id="stopscan" href="#contact" class="nav-link scrollto"><i class='bx bx-stop' ></i> <span>Stop</span></a></li>
        <li><a id="fullscreen" href="#fscreen" class="nav-link scrollto"><i class='bx bx-fullscreen' ></i> <span>Fullscreen</span></a></li>
        @else
          @if(Session::has('auth.role') && Session::get('auth.role') == 1)
            <li><a href="users" class="nav-link scrollto {{ Route::currentRouteName() == 'users' ? 'active' : '' }}"><i class="bx bx-user"></i> <span>Users</span></a></li>
            <li><a href="report" class="nav-link scrollto {{ Route::currentRouteName() == 'report' ? 'active' : '' }}"><i class="bx bx-file"></i> <span>Reports</span></a></li>
            <li><a href="settings" class="nav-link scrollto {{ Route::currentRouteName() == 'settings' ? 'active' : '' }}"><i class="bx bx-cog rotating" ></i> <span>Settings</span></a></li>          
          @endif

        <li><a href="scan" class="nav-link scrollto {{ Route::currentRouteName() == 'home' ? 'scan' : '' }}"><i class="bx bx-qr-scan"></i> <span>Scan QR</span></a></li>
        <li><a href="authlogout" class="nav-link scrollto"><i class='bx bx-log-out-circle'></i> <span>Logout</span></a></li>
        @endif
      </ul>
    </nav>
    <!-- .nav-menu -->

  </header><!-- End Header -->