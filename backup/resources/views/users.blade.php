@extends('layout.master')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .invalid-feedback{
      display: block;
    }
    section{
      overflow: auto;
    }
    .container{
      background: #fff;
      height: 100vh;
    }
    .dataTable{
      margin-bottom: 0;
    }

    table.dataTable{
      border-top-width: 0;
      border-left-width: 0;
    }

    .dataTable th{
      background: #047218 !important;
      color: #fff;
      font-weight: normal;
    }
    
    .dataTable thead tr th:first-child{
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;  
    }

    .dataTable thead tr th:last-child{
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
      
    }
    
    .dataTables_paginate{
      text-align: center;
    }

    .dropdown-item.active, .dropdown-item:active{
      background: #28a745;
    }
 
    [type=search] {
        border-radius: 8px;
        outline-offset: 0;
        -webkit-appearance: none;
    }
    .dataTables_filter{
      float: right;
    }
    .dataTables_filter input{
      padding: 8px;
    }
    .dataTables_paginate a{
      /* display: flex; */
      position: relative;
      display: inline-block;
      padding: 0.5rem 0.75rem;
      margin-left: -1px;
      line-height: 1.25;
      color: #047218;
      background-color: #fff;
      border: 1px solid #dee2e6;
    }
    .dataTables_paginate a.current{
      background: #047218;
      color: #fff;
    }

    .paginate_button.previous{
      margin-left: 0;
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
    }

    .paginate_button.next{
      margin-right: 0;
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    .paginate_button:hover{
      background: #047218;
      color: #fff;
      cursor: pointer;
    }

    .btn-primary{
      background: #047218;
      border-color: #047218;
    }
    
    .btn-primary:hover{
      background: #2d8c3f;
      border-color: #2d8c3f;
    }

    .btn-primary:active, .btn-primary:focus{
      background: #2d8c3f;
      border-color: #2d8c3f;
      box-shadow: 0 0 0 0.2rem #28a745;
    }
    

    /* .avatar-profile{
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid #fff;
      margin: 0 auto;
      object-fit: cover;
      cursor: pointer;
    } */

    .avatar-container{
      justify-content: center;
    }

  </style>
@stop

@section('main')
  <!-- ======= Hero Section ======= -->
  <!-- <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <h1>Brandon Johnson</h1>
      <p>I'm <span class="typed" data-typed-items="Designer, Developer, Freelancer, Photographer"></span></p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </section> -->
  <!-- End Hero -->
  <section class="container">
      <div class="col-lg-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#" class="user-breadcrumb crumb-1">Users</a></li>
              <li class="breadcrumb-item active"><a href="#" class="user-breadcrumb crumb-2 text-secondary">Uncategorized Users</a></li>
            </ol>
          </nav>
      </div>
    <!-- <div class="row"> -->
      <div class="col-lg-12">
        @if(Session::has('auth.role') && Session::get('auth.role') == 1 && (Session::get('auth.userId') == '89-09' || Session::get('auth.userId') == 'sudo' || Session::get('auth.userId') == 'admin'))
          <button class="btn btn-danger" id="reset-users">Reset</button>
        @endif
        <button class="btn btn-primary" data-toggle="modal" data-target="#newUserModal">Add New</button>
        <!-- <button class="btn btn-primary">Upload Excel</button> -->
      </div>
    <br>
    <!-- </div> -->

    <!-- categorize -->
    <div class="col-md-12 breadcrumb-content-1" >
        <table id="user-table" class="table table-striped table-bordered" style="width:100%"></table>
    </div>

    <!-- uncategorize -->
    <div class="col-md-12 breadcrumb-content-2">
        <table id="uncategorize-user-table" class="table table-striped table-bordered" style="width:100%;"></table>
    </div>
  </section>
  <!-- End #main -->

  <!-- The Modal -->
<div class="modal" id="newUserModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add New Record</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="disp-qr text-center" style="display: none">
          <div class="qrfile mb-3"></div>
          <!-- <a href="#" class="btn btn-primary" id="link" download="qrcode">download</a> -->
          <a href="#" class="btn btn-primary" id="link-jpg" >download</a>
        </div>
        <div class="disp-form">
          <form enctype="multipart/form-data" action="new-user" id="userForm">
            <div class="row">
              <div class="col-md-4">
                  <div class="avatar-container form-groupx text-center">
                    <label for="file" id="avatarlbl">
                      <img class="avatar-profile" src="public/assets/img/default-avatar.png" alt="user profile"/>
                    </label>
                    <input name="attachment" accept="image/*" id="file" type="file" style="display: none;">
                  </div>    
              </div>
              <div class="col-md-8">
                  <div class="form-groupx">
                    <label for="usr"></label>
                    <input type="text" name="userId" placeholder="ID Number" class="form-control" id="usr">
                  </div>
                  <div class="form-groupx">
                    <label for="usr"></label>
                    <input type="text" name="fullname" placeholder="Full Name" class="form-control">
                  </div>
              </div>
            </div>
            <div class="form-groupx">
              <label for="usr"></label>
              <!-- <input type="text" name="section" placeholder="Section" class="form-control"> -->
              <select name="section" class="form-control" id="studentSection">
              @foreach($sections as $section)
                  <option value="{{$section->sectionId}}">{{$section->SectionName}}</option>
              @endforeach
              </select>
            </div>
            <div class="form-groupx">
              <label for="usr"></label>
              <input type="text" name="guardian" placeholder="Parent/Guardian" class="form-control">
            </div>
            <div class="form-groupx">
              <label for="usr"></label>
              <input type="text" name="guardian_contact" placeholder="Contact Number" class="form-control" min="11" max="11" id="guardian_contact">
              <span class="invalid-feedback guardian_contact" role="alert"></span>
            </div>
            <div class="form-groupx">
              <label for="sel1"></label>
              <select name="role" placeholder="Role" class="form-control" id="sel1">
                <option value="0" >Student</option>
                <option value="2" >Adviser</option>
                @if(Session::has('auth.role') && Session::get('auth.role') == 1 )
                  <option value="1" >Admin</option>
                @endif
                
              </select>
            </div>
            {{ csrf_field() }}
          </form>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="disp-form">
          <button id="btnUserSubmit" type="button" class="btn btn-primary">Submit</button>
          <button id="btnUserUpdate" type="button" class="btn btn-primary" style="display: none;">Update</button>
        </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<!-- The Modal PASS -->
<div class="modal" id="newPassModal">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="change-pass-userdefine" method="post" id="change-pass-userdefine">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          
            <div class="form-group">
              <label for="usr"></label>
              <input type="password" name="password" value="{{ old('password') }}" placeholder="New Password" class="form-control">
            </div>
            <span class="invalid-feedback" role="alert" style="display:block;">
                <strong></strong>
            </span>
            {{ csrf_field() }}
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="disp-form">
          <button type="button" class="btn btn-primary btn-changepass-submit">Submit</button>
        </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>


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
  const items = {!! json_encode($result) !!}
</script>
@stop
  
