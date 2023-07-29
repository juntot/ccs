import axios from 'axios';
import QrScanner from 'qr-scanner';


const videoElem = document.querySelector('video');
let qrScanner = '';
if(videoElem)
scanQRCode(videoElem);

// start scanner
function scanQRCode(videoElem) {
  qrScanner = new QrScanner(videoElem, result => { 
    alert(result.data);
    // axios.get('test').then(res=>{
    //   console.log(res)
    // });
    console.log('decoded qr code tae:', result)
  },{
    onDecodeError: error => {
      $('.toast-body').text(error);
      $('.toast').toast('show');
        // camQrResult.textContent = error;
        // camQrResult.style.color = 'inherit';
    },
    highlightScanRegion: true,
    highlightCodeOutline: true,
  });
  QrScanner.listCameras(true); 
  qrScanner.start();
  qrScanner._updateOverlay();
  // qrScanner.stop();
}



// stop scanner
$('#stopscan').click(function(e){
  $('#hero').css('opacity', 1);
  qrScanner.stop();
});

// start scanner
$('#startscan').click(function(e){
  $('#hero').css('opacity', 0);
  qrScanner.start();
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
