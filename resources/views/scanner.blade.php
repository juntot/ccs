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

  #video-container .col-md-7{
    padding: 0px;
  }

  @media only screen and (min-width: 768px) {
    #video-container .col-md-7{
        padding: 0px 15px 0px 0px;
      }

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
      <div class="col-md-7">
          <video style="width: 100%; border-radius: 8px;"></video>
      </div>
      <div class="col-md-5">
          <div class="row justify-content-center">
              <div class="col-lg-12 mt-5 text-center">
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
<!-- <script type="module">
import a from"/public/bundle.qr.js";let videoElem=document.querySelector("video"),controller=new AbortController,scanner="";function scanQRCode(b){(scanner=new a(b,a=>setResult(a),{onDecodeError(a){},highlightScanRegion:!0,highlightCodeOutline:!0})).start().then(()=>{a.listCameras(!0).then(a=>a.forEach(a=>{}))})}async function setResult(b){console.log(b);let c=await localStorage.getItem("qrlog"),e=await localStorage.getItem("qrlogdate"),d=0;if(c){let f=moment(moment(new Date(e)).format("YYYY-MM-DD hh:mm:ss A"),"YYYY-MM-DD hh:mm:ss A"),g=moment(moment(new Date).format("YYYY-MM-DD hh:mm:ss A"),"YYYY-MM-DD hh:mm:ss A");d=g.diff(f,"seconds")}let h=`
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
        <div class="toast-body text-light bg-danger">
          <div class="toast-header custom-toast-header text-light">
            <strong class="mr-auto">Scan Result</strong>
            <small class="text-light"></small>
            <button type="button" class="ml-2 mb-1 close text-light" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-msg">
          You recently log please wait after 3 minutes..
          </div>
        </div>
      </div>`;if(b.data==c&&d<180){$(".toastList").html(h),$(".toast").toast({animation:!1,delay:3e3}),$(".toast").toast("show");return}scanner._active=!1;try{let a=await axios.get("scan-qr/"+b.data,{signal:controller.signal});await localStorage.setItem("qrlog",a.data.userId),await localStorage.setItem("qrlogdate",a.data.date_created);let i="public/assets/img/default-avatar.png",j=await a.data.avatar?"storage/app/"+a.data.avatar:i,k=new Image;k.src=await j,await loadProfile(a.data),scanner._active=!0,scanner._scanFrame()}catch(l){$(".toast-msg").text(l.response.data.message)}}async function loadProfile(a){let b=a?"storage/app/"+a.avatar:"public/assets/img/default-avatar.png";return await $(".avatar-profile").attr("src",b),await $(".user-name").text(a?a.fullname:""),await $(".user-section").text(a?a.section:""),await $(".logtime").text(a?moment(new Date(a.date_created)).format("HH:mm A"):""),!0}videoElem&&scanQRCode(videoElem),$("#stopscan").click(function(a){$("#hero").css("opacity",1),scanner.stop()}),$("#startscan").click(function(a){$("#hero").css("opacity",0),scanner.start()}),$("#fullscreen").click(function(){$(this).find("i").hasClass("bx-fullscreen")?($(this).find("i").removeClass("bx-fullscreen"),$(this).find("i").addClass("bx-exit-fullscreen"),$(this).find("span").text(" Exit Full Screen")):($(this).find("i").removeClass("bx-exit-fullscreen"),$(this).find("i").addClass("bx-fullscreen"),$(this).find("span").text(" Full Screen")),(!document.fullScreenElement||null===document.fullScreenElement)&&(document.mozFullScreen||document.webkitIsFullScreen)?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullScreen?document.documentElement.requestFullScreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullScreen&&document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT)})
  </script> -->
<script>
setInterval(function(){
  yestarCall();
}, (1000 * 60)*2);
</script>
@stop