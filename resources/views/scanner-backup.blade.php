@extends('layout.master')
@section('style')
<style>
  .toast-container{
    position: absolute;
    min-height: 280px;
    z-index: 1;
    top: 10px;
    right: 10px;
    width: 100%;
    /* height: 100%; */
    overflow: hidden;
  }
  .scan-region-highlight-svg{
    stroke: #06E349 !important;
  }
  .custom-toast-header{
    min-width: 190px;
    padding: 0;
    background: transparent;
    border-bottom: .5px solid #fff;
    margin-bottom: .8rem;
  }

  .row{
    display: flex;
    height: 100vh;
  }

  .col-md-7{
    align-self: center;
  }

  .text-green{
    color: #2d8c3f;
  }

  .user-section{
    font-size: 1rem;
    display: inline-block;
  }
  #video-container .row{
    background: #00b09b;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #96c93d, #00b09b);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #96c93d, #00b09b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  }
  .col-md-5, .col-md-5 .row{
    background: #fff !important;
  }
</style>
@stop
@section('main')
<div aria-live="polite" aria-atomic="true" class="toast-container">
  <!-- Position it -->
  <div class="toastList" style="position: absolute; bottom: 0; right: 0;">
    
  </div>
</div>
<!-- Toast -->


  <!-- video -->
  <div id="video-container">
    <div class="row">
      <div class="col-md-7">
          <video style="width: 100%;"></video>
      </div>
      <div class="col-md-5">
          <div class="row justify-content-center">
              <div class="col-lg-12 mt-5 text-center">
                  <img class="avatar-profile" src="public/assets/img/default-avatar.png" alt="user profile">
                  <div class="form-group mt-4">
                    <h2 class="font-weight-bold user-name text-green">Juan Dela Cruz</h2>
                    <small class="text-green user-section">Section Opal</small><br>
                    <small class="text-muted logtime">2:40 AM</small>
                  </div>
                  
              </div>
          </div>
      </div>
    </div>
  </div>  
  <!-- end video -->
  
  
  <section id="hero" class="d-flex flex-column justify-content-center" style="position: fixed; top: 0; left: 0; opacity: 0"></section>
  <!-- End Hero -->
  
  
  <!-- <div class="toast" data-autohide="false" style="top: 15px; left: 50%; transform: translateX(-50%); position: absolute;">
    <div class="toast-body text-light bg-success">
      <div class="toast-head mb-2">
          <strong class="mr-auto">Record Save</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
      </div>
      Some text inside the toast body
    </div>
  </div> -->


  <!-- End #main -->

  <!-- ======= Footer ======= -->
 

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@stop
@section('script')
<script src="public/bootstrap.min.js"></script>
@stop