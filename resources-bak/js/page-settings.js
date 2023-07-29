
// main bg
$('#fileMain').bind('change', function() {
  const url = $('#pageSettingFormMain').attr('action');
  const [file] = this.files
  const totalSize = file.size;
  
  if( document.getElementById("fileMain").files.length == 0 ){
     alert("no files selected");
     return;
  }
  if((totalSize / 1000) > 134) {
     alert("Please upload file less than 134KB.");      
     return;
  }

  const formData = new FormData(document.querySelector('form#pageSettingFormMain'));
  axios.post(url, formData)
  .then(res=>{
    document.querySelector('.cover-img-main').src = URL.createObjectURL(file);
  })
  .catch(er=>{
    alert('an error occured please try again..');
  });
});


// login bg
$('#fileLogin').bind('change', function() {
  const url = $('#pageSettingFormLogin').attr('action');
  const [file] = this.files
  const totalSize = file.size;
  

  if( document.getElementById("fileLogin").files.length == 0 ){
     alert("no files selected");
     return;
  }
  if((totalSize / 1000) > 134) {
     alert("Please upload file less than 134KB.");
     return;
  }
  
  const formData = new FormData(document.querySelector('form#pageSettingFormLogin'));
  axios.post(url, formData)
  .then(res=>{
    document.querySelector('.cover-img-login').src = URL.createObjectURL(file);
  })
  .catch(er=>{
    alert('an error occured please try again..');
  });
});