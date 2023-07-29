import axios from 'axios';
// import QrScanner from 'qr-scanner';

// const videoElem = document.querySelector('video');
// let scanner = '';
// if(videoElem)
// scanQRCode(videoElem);

// // start scanner
// function scanQRCode(videoElem) {
//   scanner = new QrScanner(videoElem, result => setResult(result), {
//       onDecodeError: error => {
//         console.log(error);  
//       },
//       highlightScanRegion: true,
//       highlightCodeOutline: true,
//   });

//   // qrScanner.stop();

//   scanner.start().then(() => {
//     // updateFlashAvailability();
//     // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
//     // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
//     // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
//     // start the scanner earlier.
//     QrScanner.listCameras(true)
//     .then(cameras => cameras.forEach(camera => {}));
//   });
// }


// function setResult(result){
  
//   // <!-- Then put toasts within -->
//   let toast =   `
//     <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
//       <div class="toast-body text-light bg-success">
//         <div class="toast-header custom-toast-header text-light">
//           <strong class="mr-auto">Scan Result</strong>
//           <small class="text-light">just now</small>
//           <button type="button" class="ml-2 mb-1 close text-light" data-dismiss="toast" aria-label="Close">
//             <span aria-hidden="true">&times;</span>
//           </button>
//         </div>
//         ${result.data}
//       </div>
//     </div>`;

//   $('.toastList').append(toast);
//   $('.toast').toast({animation: false, delay: 3000});
//   $('.toast').toast('show');
// }


// // stop scanner
// $('#stopscan').click(function(e){
//   $('#hero').css('opacity', 1);
//   scanner.stop();
// });

// // start scanner
// $('#startscan').click(function(e){
//   $('#hero').css('opacity', 0);
//   scanner.start();
// });

// // full screen
// $('#fullscreen').click(function(){
//   if($(this).find('i').hasClass('bx-fullscreen')){
//     $(this).find('i').removeClass('bx-fullscreen');
//     $(this).find('i').addClass('bx-exit-fullscreen');
//     $(this).find('span').text(' Exit Full Screen');
//   }else{
//     $(this).find('i').removeClass('bx-exit-fullscreen');
//     $(this).find('i').addClass('bx-fullscreen');
//     $(this).find('span').text(' Full Screen');
//   }
  
//   document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen();
// });
