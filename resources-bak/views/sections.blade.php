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
    <!-- <div class="row"> -->
      <div class="col-lg-12">
        <button class="btn btn-primary" data-toggle="modal" data-target="#newSectionModal">Add New</button>
        <!-- <button class="btn btn-primary">Upload Excel</button> -->
      </div>
    <br>
    <!-- </div> -->
    <div class="col-md-12">
      <table id="section-table" class="table table-striped table-bordered" style="width:100%"></table>
    </div>
  </section>
  <!-- End #main -->

  <!-- The Modal -->
<div class="modal" id="newSectionModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Add New Record</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="disp-form">
          <form enctype="multipart/form-data" method="post" action="new-section" id="sectionForm">
            <div class="row">
              <div class="col-md-12">
                  <div class="form-groupx">
                    <label for="section"></label>
                    <input id="section" type="text" name="SectionName" placeholder="Section Name" class="form-control">
                  </div>
              </div>
            </div>
            {{ csrf_field() }}
          </form>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="disp-form">
          <button id="btnSectionSubmit" type="button" class="btn btn-primary">Submit</button>
          <button id="btnSectionUpdate" type="button" class="btn btn-primary" style="display: none;">Update</button>
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
  
