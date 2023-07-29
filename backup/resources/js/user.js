import axios from 'axios';
let trIndex = '';
let selected = '';
let DTable = '';
if($('#user-table').length){
  DTable = $('#user-table').DataTable({
    data: items,
    order: [[ 0, "desc" ]],
    columns: [
      { data: 'userId', title:'User ID',  className: "table-prodId", render: function(data){
          return '<a class="prodId" href="#">'+data+'</a>';
      }},
      
      { data: 'qrcode', title: 'QR',  render: function(data){
        const img = new Image();
        img.src = data;
        return data? '<label class="badge badge-info btn-view-qr"><a href="#" class="text-white">View QR</a></label>': '';
      }}
      ,
      {title: 'Action', render: function(data, type, row){
        // if(row.userId != 'admin' && row.userId != 'encoder' && row.userId != 'scanner' && row.userId != 'sudo')
        if(row.role == 0)
        return `<label class="badge badge-danger btn-delete-row"><a href="#" class="text-white">remove</a></label>`;
        
        if(row.role > 0)
        return '<label class="badge badge-warning btn-changepass-row"><a href="#" class="text-dark" >change password</a></label>';
        
        return '';
      }},
      { data: 'fullname', title:'Full Name' },
      { data: 'SectionName', title: 'Section'},
      { data: 'guardian', title: 'Parent/Guardian' },
      { data: 'guardian_contact', title: 'Parent/Guardian Contact Number' },
    ],
    scrollX: true,
    language: { search: "" , searchPlaceholder: "Search..." },
    pageLength: 50,
    bInfo: true,
    bLengthChange: false,
    dom: 'Bfrtip',
    buttons: [
        'excel', 'print',
    ]
  });

  // invoke change pass modal
  $('#user-table tbody').on( 'click', '.btn-changepass-row', function () {
      const d = DTable.row( $(this).closest('tr') ).data();
      selected = d;

      $("#newPassModal").modal("show");
  });

  // change password
  $(".btn-changepass-submit").click(function(e){
      e.preventDefault();
      const formData = getFormData($('#change-pass-userdefine'));
      formData['userId'] = selected.userId;
      

      axios.post('change-pass-userdefine', formData)
      .then(res=>{
        $("#newPassModal").modal("hide");
        $('.invalid-feedback strong').text('');
      })
      .catch(er=>{
        $('.invalid-feedback strong').text(er.response.data.errors.password[0] || '');
      });
  });


  // user info
  $('#user-table tbody').on( 'click', '.prodId', function () {
      $('#btnUserSubmit').hide();
      $('#btnUserUpdate').show();
      
      
      trIndex = $(this).closest('td');
      const d = DTable.row( $(this).closest('tr') ).data();
      selected = d;
      
      if(d.avatar)
      $('.avatar-profile').attr('src','storage/app/'+d.avatar);

      populate('form', d);
      
      $("#newUserModal .modal-title").text('Update Record');
      $("#newUserModal").modal("show");
      $('#usr').attr('disabled', 'disabled');
  });

  // qr view
  $('#user-table tbody').on( 'click', '.btn-view-qr', async function () {
      $('#btnUserSubmit').hide();
      $('#btnUserUpdate').hide();
      const d = DTable.row( $(this).closest('tr') ).data();
      
      $('.disp-form').toggle();
      $('.disp-qr').show();
      
      await $('.disp-qr .qrfile').html(d.qrcode);
      downloadSvg('.qrfile svg');
      // downloadJpgfromSvg('.qrfile svg');
      $("#newUserModal .modal-title").text('QR CODE');
      $("#newUserModal").modal("show");
  });

  // del row
  $('#user-table tbody').on( 'click', '.btn-delete-row', function () {
      const conf = confirm("Are you sure you want to delete this record?");
      if(!conf)
      return;
      

      const d = DTable.row( $(this).closest('tr') ).data();
      axios.post('rem-user', {
        userId: d.userId,
        avatar: d.avatar,
      })
      .then(res=>{
        DTable.row( $(this).parents('tr') ).remove().draw();
      })
      .catch(er=>er)
  });

}


// download svg
function downloadSvg(svg){
  // uncomment return to download svg
  return;

  //get svg element.
      var svg = document.querySelector(svg);

      //get svg source.
      var serializer = new XMLSerializer();
      var source = serializer.serializeToString(svg);

      //add name spaces.
      if(!source.match(/^<svg[^>]+xmlns="http\:\/\/www\.w3\.org\/2000\/svg"/)){
          source = source.replace(/^<svg/, '<svg xmlns="http://www.w3.org/2000/svg"');
      }
      if(!source.match(/^<svg[^>]+"http\:\/\/www\.w3\.org\/1999\/xlink"/)){
          source = source.replace(/^<svg/, '<svg xmlns:xlink="http://www.w3.org/1999/xlink"');
      }

      //add xml declaration
      source = '<?xml version="1.0" standalone="no"?>\r\n' + source;

      //convert svg source to URI data scheme.
      var url = "data:image/svg+xml;charset=utf-8,"+encodeURIComponent(source);

      //set url value to a element's href attribute.
      document.getElementById("link").href = url;
      //you can download svg file by right click menu.
}


// download as jpg
function downloadJpgfromSvg(svg){
  var svgElement = document.querySelector(svg);
  
  // get width and height of svg
  let {width, height} = svgElement.getBBox(); 
  
  // clone a node
  let clonedSvgElement = svgElement.cloneNode(true);

  // create a blob
  let outerHTML = clonedSvgElement.outerHTML;
  
  let blob = new Blob([outerHTML],{type:'image/svg+xml;charset=utf-8'});
  
  // create url from blob Objecty
  let URL = window.URL || window.webkitURL || window;
  let blobURL = URL.createObjectURL(blob);

  let image = new Image();
  // image.onload = () => {
    image.addEventListener('load', () => {
    alert('ate');
    let canvas = document.createElement('canvas');
    
    canvas.widht = width;
    
    canvas.height = height;
    let context = canvas.getContext('2d');
    // draw image in canvas starting left-0 , top - 0  
    context.drawImage(image, 0, 0, width, height );
    //  downloadImage(canvas); need to implement
    image.src = blobURL;
    // let jpeg = canvas.toDataURL('image/jpg');
    // console.log(jpeg);
    
    console.log(canvas);
    
    // document.getElementById("link-jpg").href = jpeg;
  });
  
  // downloadJpg(jpeg, "image.png");
}





const createStyleElementFromCSS = () => {
  // JSFiddle's custom CSS is defined in the second stylesheet file
  const sheet = document.styleSheets[1];

  const styleRules = [];
  for (let i = 0; i < sheet.cssRules.length; i++)
    styleRules.push(sheet.cssRules.item(i).cssText);

  const style = document.createElement('style');
  style.type = 'text/css';
  style.appendChild(document.createTextNode(styleRules.join(' ')))

  return style;
};
const style = createStyleElementFromCSS();
$('#link-jpg').click(function(){
  downloadJpg();
});
const downloadJpg = () => {
  // fetch SVG-rendered image as a blob object
  const svg = document.querySelector('svg');
  svg.insertBefore(style, svg.firstChild); // CSS must be explicitly embedded
  const data = (new XMLSerializer()).serializeToString(svg);
  const svgBlob = new Blob([data], {
    type: 'image/svg+xml;charset=utf-8'
  });
	style.remove(); // remove temporarily injected CSS

  // convert the blob object to a dedicated URL
  const url = URL.createObjectURL(svgBlob);

  // load the SVG blob to a flesh image object
  const img = new Image();
  img.addEventListener('load', () => {
    // draw the image on an ad-hoc canvas
    const bbox = svg.getBBox();

    const canvas = document.createElement('canvas');
    canvas.width = bbox.width;
    canvas.height = bbox.height;

    const context = canvas.getContext('2d');
    context.drawImage(img, 0, 0, bbox.width, bbox.height);

    URL.revokeObjectURL(url);

    // trigger a synthetic download operation with a temporary link
    const a = document.createElement('a');
    a.download = 'qrcode.jpg';
    document.body.appendChild(a);
    a.href = canvas.toDataURL();
    a.click();
    a.remove();
  });
  img.src = url;
};








  


{/* <a href='data:image/svg+xml;utf8,<svg viewBox="0 0 20 20" width="20" height="20" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="10"></circle></svg>' download="circlesandcircles.svg">download SVG</a> */}


// check file size
$('#file').bind('change', function() {
  // var files = this.files;
  const [file] = this.files
  const totalSize = file.size;
  

  if( document.getElementById("file").files.length == 0 ){
     alert("no files selected");
  }
  if((totalSize / 3000) > 3) {
     alert("Please upload file less than 10kb.");      
    //  $('#submitReg').prop('disabled', true);
  }else{
    //  $('#submitReg').prop('disabled', false);
     document.querySelector('.avatar-profile').src = URL.createObjectURL(file)
  }
});

// populate
function populate(form, data){
    const formdata = $(form).serializeArray();
    for (const iterator of formdata) {
      $(`[name=${iterator.name}]`).val(data[iterator.name])
    }
}

// submit form
$('#btnUserSubmit').click(function(e){
  e.preventDefault();
  const url = $('#userForm').attr('action');
  
  if($('#usr').val() == '')
  return;
  
  if($('#guardian_contact').val() && !(/^(09)\d{9}$/g).test($('#guardian_contact').val())){
    $('.invalid-feedback.guardian_contact').html('Invalid phone number');
    return;
  }
  
  const formData = new FormData(document.querySelector('form'));
  const params = getFormData($("form"));
  
  axios.post(url, formData)
  .then(res=>{
    params['qrcode'] = res.data;
    params['SectionName'] = $("#studentSection").find('option:selected').text();
    
    $('.disp-form').toggle();
    $('.disp-qr').show();
    $('.disp-qr .qrfile').html(res.data);
    downloadSvg('.qrfile svg');
    
    DTable.row.add(params).draw();
  })
  .catch(er=>{
    alert(er.response.data.message);
  });
});

// update form
$('#btnUserUpdate').click(function(e){
  e.preventDefault();
  const url = 'update-user';
  
  if($('#usr').val() == '')
  return;

  
  if($('#guardian_contact').val() && !(/^(09)\d{9}$/g).test($('#guardian_contact').val())){
    $('.invalid-feedback.guardian_contact').html('Invalid phone number');
    return;
  }

  const formData = new FormData(document.querySelector('form'));
  formData.append('userId', selected.userId);

  // const params = getFormData($("form"));
  
  axios.post(url, formData)
  .then(res => {
    res.data['SectionName'] = $("#studentSection").find('option:selected').text();
    DTable.row( trIndex ).data({...selected, ...res.data}).draw(); 
    $("#newUserModal").modal('hide');
    
  })
  .catch(er=>{
    console.log(er);
    // alert(er.response.data.message);
  });
});



$("#newUserModal").on('hide.bs.modal', function(){
    $('.disp-form').show();
    $('.disp-qr').hide();

    $('#btnUserSubmit').show();
    $('#btnUserUpdate').hide();

    $("#newUserModal .modal-title").text('Add New Record');
    $('.avatar-profile').attr('src','public/assets/img/default-avatar.png');
    $('#usr').removeAttr('disabled');

    document.getElementById("userForm").reset();
    // $('#userForm')[0].reset();
    $('.invalid-feedback.guardian_contact').empty();
});

$("#newPassModal").on('hide.bs.modal', function(){
  document.getElementById("change-pass-userdefine").reset();
});



