import axios from 'axios';
$(function(){
 
 let totalChars = 0;
  $('#announcementtextarea').on('keydown', function(){
      totalChars = $(this).val().trim().length;
      disableBtnAnnouncement(totalChars);
      $('.text-character-total').text(totalChars);
  });

  $('.btn-announcement').on('click', function(e){
    e.preventDefault();
    
    if(totalChars > 150 || totalChars == 0 )
    return;

    axios.post('announcement', {
      message: $('#announcementtextarea').val()
    })
    .catch(er=>console.log(er))
    $('#myModal').modal('hide');
  });

});

function disableBtnAnnouncement(totalChars){
  totalChars > 150 ? $('.btn-announcement').attr('disabled', true): $('.btn-announcement').attr('disabled', false);
}