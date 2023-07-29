@extends('layout.master')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
  section{
    overflow: auto;
  }
  .nav-pills a{
    display: block;
    padding: 10px 15px;
    border-radius: 15px;
  }
  .nav-pills a.active{
    background: #047218;
    border-color: #047218;
    color: #fff;
  }
  .container{
    background: #fff;
    height: 100vh;
    padding-left: 40px;
    padding-right: 40px;
    
  }
  .invalid-feedback{
    display: block;
  }
  .text-green{
   color: #047218;
   
  }
  .col-md-6 img{
    border-radius: 8px;
    width: 100%;
    height: auto;
  }
</style>
@stop

@section('main')
  <!-- End Hero -->
  <section class="container">
    
    <!-- tab pills nav -->
    <ul class="nav nav-pills">
      <li class="active"><a data-toggle="pill" href="#menu" class="active">Security</a></li>
      @if(Session::has('auth.role') && Session::get('auth.role') == 1  )
      <li><a data-toggle="pill" href="#menu1">Page Settings</a></li>
      @endif
      <!-- <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
      <li><a data-toggle="pill" href="#menu3">Menu 3</a></li> -->
    </ul>

    <!-- tab pill content -->
    <div class="tab-content mt-4">
      <div id="menu" class="tab-pane fade in active show">
          <div class="row">
            <div class="col-md-12">
                <h5 class="text-green">Password</h5>
                <form action="change-pass" method="post">
                        <div class="form-groupx">
                          <label for="usr"></label>
                          <input type="password" name="oldpass" value="{{ old('oldpass') }}" placeholder="Old Password" class="form-control">
                        </div>
                        @error('oldpass')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-groupx">
                          <label for="usr"></label>
                          <input type="password" name="password" value="{{ old('password') }}" placeholder="New Password" class="form-control">
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-groupx">
                          <label for="usr"></label>
                          <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="form-control">
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary mt-4 col-12" >Save</button>
                </form>
            </div>
          </div>
      </div>
      
      <div id="menu1" class="tab-pane fade">
      <!-- <div class="row"> -->
            <div class="row">
                @if(Session::has('auth.role') && Session::get('auth.role') == 1  )
                  <div class="col-md-6">
                    <form enctype="multipart/form-data" action="cover-page" id="pageSettingFormLogin">
                        <h5 class="text-green">Login Page Background</h5>
                        <label for="fileLogin" id="loginBg">
                          <img class="cover-img-login" src="storage/app/public/login-bg.jpg" alt="login background image">
                        </label>
                        {{ csrf_field() }}
                        <input name="attachment_login" accept="image/jpeg, image/jpg" id="fileLogin" type="file" style="display: none;">
                    </form>
                  </div>
                  <div class="col-md-6">
                    
                      <form enctype="multipart/form-data" action="cover-page" id="pageSettingFormMain">
                          <h5 class="text-green">Main Page Background</h5>
                          <label for="fileMain" id="mainBg">
                            <img class="cover-img-main" src="storage/app/public/hero-bg.jpg" alt="main page background image">
                          </label>
                          {{ csrf_field() }}
                          <input name="attachment_main" accept="image/jpeg, image/jpg" id="fileMain" type="file" style="display: none;">
                          </div>
                      </form>
                    
                  </div>  
                @endif
            </div>
          <!-- </div> -->
    </div>
    
    <!-- main content -->
    <!-- <div class="col-md-12">
      <table id="settings-table" class="table table-striped table-bordered" style="width:100%"></table>
    </div> -->
  </section>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
@stop
@section('script')
  <!-- datatable -->
<script src="{{ URL::to('/public/assets/js/dt/jquery.dataTables.min.js') }}"></script>  
<script src="{{ URL::to('/public/assets/js/dt/dataTables.buttons.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/buttons.bootstrap4.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/jszip.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/pdfmake.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/vfs_fonts.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/buttons.html5.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/buttons.print.min.') }}js"></script>
<script src="{{ URL::to('/public/assets/js/dt/buttons.colVis.min.') }}js"></script>

<!-- date range picker -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="{{ URL::to('/public/assets/js/dr/daterangepicker.min.js') }}"></script>

<script>
  
</script>
@stop
  
