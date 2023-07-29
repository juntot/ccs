@extends('layout.master')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    section{
      overflow: auto;
    }
    .container{
      background: #fff;
      height: 100vh;
    }
    table.dataTable{
      border-top-width: 0;
      border-left-width: 0;
    }
    .dataTable{
      margin-bottom: 0;
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

    /* custom button DT table */
    .btn.dropdown-toggle.custom-filter{
      border-radius: 0px .25rem .25rem 0px;
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
    <!-- date range -->
    <div class="row px-3">
      <div class="col-md-4">
        <div class="form-group">
          <label for="daterange"></label>
          <input type="text" class="form-control" name="daterange" value="" id="daterange">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="daterange"></label>
          <input type="text" class="form-control" name="searchname" placeholder="Search * or ID Number" id="keyword">
        </div>
      </div>
      <div class="col-md-4">
          <button type="submit" class="btn btn-primary mt-4" id="btnSearch">Generate</button>
      </div>
    </div>
    
    <!-- end date range -->
    <div class="col-md-12 mt-5">
      <table id="report-table" class="table table-striped table-bordered" style="width:100%"></table>
    </div>
  </section>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
 

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
@stop
@section('script')
  <!-- datatable -->
<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script> -->


<!-- date range picker -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->

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
  
