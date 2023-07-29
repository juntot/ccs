@extends('layout.master')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
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
  section.container{
    /* overflow: auto; */

  }
</style>
@stop

@section('main')
  <!-- End Hero -->
  <section class="container">
    
    <!-- tab pills nav -->
    <ul class="nav nav-pills">
      <li class="active"><a data-toggle="pill" href="#menu" class="active">Page Settings</a></li>
      <li><a data-toggle="pill" href="#menu1">Security</a></li>
      <!-- <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
      <li><a data-toggle="pill" href="#menu3">Menu 3</a></li> -->
    </ul>

    <!-- tab pill content -->
    <div class="tab-content mt-4">
      <div id="menu" class="tab-pane fade in active show">
        <h3>Pages</h3>
        <form enctype="multipart/form-data" action="new-user" id="userForm">
          <div class="row">
            <div class="col-md-6">
                <label for="fileLogin" id="loginBg">
                  <img class="cover-img" src="public/assets/img/default-avatar.png" alt="login background image">
                </label>
                <input name="attachment" accept="image/*" id="fileLogin" type="file" style="display: none;">
            </div>
            <div class="col-md-6">
                <label for="fileMain" id="mainBg">
                  <img class="cover-img" src="public/assets/img/default-avatar.png" alt="main page background image">
                </label>
                <input name="attachment" accept="image/*" id="fileMain" type="file" style="display: none;">
                </div>
            </div>
          </div>
        </form>
      </div>
      <div id="menu1" class="tab-pane fade">
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
    </div>
    
    <!-- main content -->
    <!-- <div class="col-md-12">
      <table id="settings-table" class="table table-striped table-bordered" style="width:100%"></table>
    </div> -->
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
          <a href="#" class="btn btn-primary" id="link" download="qrcode">download</a>
        </div>
        <div class="disp-form">
          <form enctype="multipart/form-data" action="new-user" id="userForm">
            <div class="row">
              <div class="col-md-4">
                  <div class="avatar-container form-groupx text-center">
                    <label for="file" id="avatarlbl">
                      <img class="avatar-profile" src="public/assets/img/default-avatar.png" alt="user profile">
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
              <input type="text" name="section" placeholder="Section" class="form-control">
            </div>
            <div class="form-groupx">
              <label for="usr"></label>
              <input type="text" name="guardian" placeholder="Parent/Guardian" class="form-control">
            </div>
            <div class="form-groupx">
              <label for="usr"></label>
              <input type="text" name="guardian_contact" placeholder="Contact Number" class="form-control">
            </div>
            <div class="form-groupx">
              <label for="sel1"></label>
              <select name="role" placeholder="Role" class="form-control" id="sel1">
                <option value="0" >Standard</option>
                <option value="1" >Admin</option>
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


  <!-- ======= Footer ======= -->
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
@stop
@section('script')
  <!-- datatable -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>


<!-- date range picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  
</script>
@stop
  
