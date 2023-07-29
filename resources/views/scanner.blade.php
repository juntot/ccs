@extends('layout.master')
@section('style')
<style>
  .toast-container{
    position: absolute;
    min-height: 280px;
    z-index: 1;
    bottom: 10px;
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
    <video style="width: 100%;"></video>
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

  <script>

  //   $('.toast').toast({animation: false, delay: 993000});
  // $('.toast').toast('show');
  </script>
@stop