@extends('layout.master')
@section('style')
<style>
a.ann i.bx{
  font-size: 2em;
}
.welcome-user{
  color: #047218;
  font-weigth: 600;
}
</style>
@stop
@section('main')
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <span class="welcome-user">
        Welcome, 
        @if(Session::has('auth.fullname'))
          {{ Session::get('auth.fullname') }}
        @endif
        <br><br>
      </span>
      <h2>Cordova Catholic Cooperative School</h2>
      <p>We Produce <span class="typed" data-typed-items="Self−disciplined, Responsible, Independent, Cooperative, Christ−centered Individuals."></span></p>
      <div class="social-links">
        <!-- <textarea name=""></textarea> -->
        @if(Session::has('auth.role') && Session::get('auth.role') == 1 && (Session::get('auth.userId') == '89-09' || Session::get('auth.userId') == 'sudo'))
        <a class="ann" href="#" data-toggle="modal" data-target="#myModal"><i class='bx bxs-message-rounded-dots' ></i></a>
        <!-- <a class="ann" href="#"><i class='bx bx-message-rounded-check' ></i></a> -->
        @endif
        <!-- <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a> -->
        <!-- <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a> -->
      </div>
    </div>
  </section>
  <!-- End Hero -->

  <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Make Announcement</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <textarea name="announcement" rows="12" id="announcementtextarea" class="form-control"></textarea>
            <span class="text-danger"><span class="text-character-total">0</span>/150 characters limit</span>
            </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-announcement" >Send</button>
      </div>

    </div>
  </div>
</div>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
 

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@stop