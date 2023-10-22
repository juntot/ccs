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
<script>
// import QrScanner from "/public/bundle.qr.js";
const videoElem = document.querySelector('video');
const controller = new AbortController();
let scanner = '';
if(videoElem)
scanQRCode(videoElem);

// start scanner
function scanQRCode(videoElem) {
  scanner = new QrScanner(videoElem, result => setResult(result), {
      onDecodeError: error => {
        // console.log(error);  
      },
      highlightScanRegion: true,
      highlightCodeOutline: true,
  });

  // qrScanner.stop();

  scanner.start().then(() => {
    // updateFlashAvailability();
    // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
    // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
    // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
    // start the scanner earlier.
    QrScanner.listCameras(true)
    .then(cameras => cameras.forEach(camera => {}));
  });
}


async function setResult(result){
  console.log(result);
  // validate storage
  const lastUserLog = await localStorage.getItem("qrlog");
  const lastUserTime = await localStorage.getItem("qrlogdate");

  let seconds = 0;
  if( lastUserLog){
    const momentStartTime = moment(moment(new Date(lastUserTime)).format('YYYY-MM-DD hh:mm:ss A'), 'YYYY-MM-DD hh:mm:ss A');
    const momentEndTime = moment(moment(new Date()).format('YYYY-MM-DD hh:mm:ss A'), 'YYYY-MM-DD hh:mm:ss A');
    seconds = momentEndTime.diff(momentStartTime, 'seconds');
  }


  let toastErr =   `
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
      </div>`;
      
  if(result.data == lastUserLog && seconds < (60 * 3)){
    $('.toastList').html(toastErr);
    $('.toast').toast({animation: false, delay: 3000});
    $('.toast').toast('show');

    return;
  }
  
  // pause
  scanner._active = false;

  try {

    const res = await axios.get('scan-qr/'+result.data, { signal: controller.signal}) ;
       // set locals
    await localStorage.setItem("qrlog", res.data.userId);
    await localStorage.setItem("qrlogdate", res.data.date_created);
    
    const defaultAvatar = 'public/assets/img/default-avatar.png';
    const avatar = await res.data.avatar? 'storage/app/'+res.data.avatar : defaultAvatar;
    const img = new Image();
    img.src = await avatar;
    
    await loadProfile(res.data);
    scanner._active = true;
    scanner._scanFrame();
  } catch (er) {
    $('.toast-msg').text(er.response.data.message);
  }
}

async function loadProfile(data){
  const defaultAvatar = data ? 'storage/app/'+data.avatar : 'public/assets/img/default-avatar.png';
  await $('.avatar-profile').attr('src', defaultAvatar);
  await $('.user-name').text(data ? data.fullname : '');
  await $('.user-section').text(data? data.section : '');
  await $('.logtime').text(data? moment(new Date(data.date_created)).format('HH:mm A') : '');
  return true;
}


// stop scanner
$('#stopscan').click(function(e){
  $('#hero').css('opacity', 1);
  scanner.stop();
});

// start scanner
$('#startscan').click(function(e){
  $('#hero').css('opacity', 0);
  scanner.start();
});

// full screen
$('#fullscreen').click(function(){
  if($(this).find('i').hasClass('bx-fullscreen')){
    $(this).find('i').removeClass('bx-fullscreen');
    $(this).find('i').addClass('bx-exit-fullscreen');
    $(this).find('span').text(' Exit Full Screen');
  }else{
    $(this).find('i').removeClass('bx-exit-fullscreen');
    $(this).find('i').addClass('bx-fullscreen');
    $(this).find('span').text(' Full Screen');
  }
  
  document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen();
});

  </script>
@stop