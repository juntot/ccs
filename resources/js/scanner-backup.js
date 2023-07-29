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
  
  // validate storage
  const lastUserLog = await localStorage.getItem("qrlog");
  const lastUserTime = await localStorage.getItem("qrlogdate");

  let seconds = 0;
  if( lastUserLog){
    const momentStartTime = moment(moment(new Date(lastUserTime)).format('YYYY-MM-DD hh:mm:ss A'), 'YYYY-MM-DD hh:mm:ss A');
    const momentEndTime = moment(moment(new Date()).format('YYYY-MM-DD hh:mm:ss A'), 'YYYY-MM-DD hh:mm:ss A');
    seconds = momentEndTime.diff(momentStartTime, 'seconds');
  }


  let toastErr = toastMessage(result.data, 'You just recently logged. please wait after 3 minutes..');
      
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

    toastErr = toastMessage(result.data, er.response.data.message);
    $('.toastList').html(toastErr);
    $('.toast').toast({animation: false, delay: 3000});
    $('.toast').toast('show');

    scanner._active = true;
    scanner._scanFrame();
  }
}

async function loadProfile(data){
  const defaultAvatar = data ? 'storage/app/'+data.avatar : 'public/assets/img/default-avatar.png';
  await $('.avatar-profile').attr('src', defaultAvatar);
  await $('.user-name').text(data ? data.fullname : '');
  await $('.user-section').text(data? data.section : '');
  await $('.logtime').html(data? '<span class="logStatus" style="text-transform: capitalize;">Log '+data.status+'</span> - <span style="text-transform: uppercase;">'+ moment(new Date(data.date_created)).format('HH:mm a')+'</span>' : '');
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


// toast message
function toastMessage(val1, val2){
  return `
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
        <div class="toast-body text-light bg-danger">
          <div class="toast-header custom-toast-header text-light">
            <strong class="mr-auto">ID No: ${val1}</strong>
            <small class="text-light"></small>
            <button type="button" class="ml-2 mb-1 close text-light" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-msg">
          ${val2}
          </div>
        </div>
      </div>`;
}