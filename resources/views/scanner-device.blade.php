@extends('layout.master2')
@section('style')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap');
  .toast-container{
    position: absolute;
    min-height: 280px;
    z-index: 10;
    top: 50%;
    right: 10px;
    width: 400px;
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
  #video-container{
    position: relative;
    z-index: 9;
  }

  #video-container .row{
    background: #00b09b;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #96c93d, #00b09b);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #96c93d, #00b09b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  }
  .col-md-5, .col-md-5 .row{
    background: #fff !important;
  }

  #video-container .col-md-7{
    padding: 0px;
  }

  .container.aos-init{
    max-width: 430px;
  }
  @media only screen and (min-width: 768px) {
    #video-container .col-md-7{
        padding: 0px 15px 0px 0px;
      }
  
  }
  @media only screen and (max-width: 768px) {
    .toast-container{
      bottom: 50%;
      top: 0;
    }
  
  }
  .clock{
    font-size: 3em;
    font-family: 'Kaushan Script', cursive;
    font-weight: bold;
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
    <div class="row m-0">
      <div class="col-md-7 p-5">
          
          <div class="container aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="text-center text-white clock"></div><br><br>

            <h1>Cordova Catholic Cooperative School</h1>
            <p>We Produce 
              <span class="typed text-white" data-typed-items="Self−disciplined, Responsible, Independent, Cooperative, Christ−centered Individuals."></span>
            </p>
            <form action="scan-device" method="get" id="formscannerdevice">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Scan QR" id="scannerdevicefield" autofocus>
              </div>
            </form>
          </div>

      </div>
      <div class="col-md-5">
          <div class="row justify-content-center align-items-center">
              <div class="col-lg-12 mt-0 text-center">
                  <img class="avatar-profile" src="public/assets/img/default-avatar.png" alt="user profile">
                  <div class="form-group mt-4">
                    <h2 class="font-weight-bold user-name text-green">Juan Dela Cruz</h2>
                    <small class="text-green user-section">Section Opal</small><br>
                    <small class="text-muted logtime">00:00 AM</small>
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
<!-- <script>
  $(document).ready(function(){
    $("form#formscannerdevice").submit(function(e){
      e.preventDefault();
      const url = $('form#formscannerdevice').attr('action');
      const value = $('#scannerdevicefield').val();
    //   axios.get(url+'/'+value)
    //   .then(res=>{
    //     console.log(res.data);
    //     // document.querySelector('.cover-img-login').src = URL.createObjectURL(file);
    //   })
    //   .catch(er=>{
    //     alert('an error occured please try again..');
    //   });
    setResult(value);
    });

    
  }); -->
<!-- </script> -->
<script>
  $(document).ready(function(){
    $("#someTextBox").focus();
    let clock = moment(new Date()).format('MMM DD, YYYY hh:mm:ss A');
    const clocklabel = $('.clock');
    clocklabel.html(clock);
    setInterval(() => {
      clock = moment(new Date()).format('MMM DD, YYYY hh:mm:ss A');
      clocklabel.html(clock);
    }, 1000);

  })
</script>
@stop