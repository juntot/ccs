import axios from 'axios';
let trIndex = '';
let selected = '';
let DTable = '';

if($('#section-table').length){
  DTable = $('#section-table').DataTable({
    data: items,
    order: [[ 0, "desc" ]],
    columns: [
      
      { data: 'SectionName', title: 'Section', render: function(data){
        return '<a class="prodId" href="#">'+data+'</a>';
      }},
      {title: 'Action', render: function(data, type, row){
        if(row.userId != 'admin' && row.userId != 'encoder' && row.userId != 'scanner' && row.userId != 'sudo')
        return `<label class="badge badge-danger btn-delete-row"><a href="#" class="text-white">remove</a></label>`;

        return '';
      }},
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


  // user info
  $('#section-table tbody').on( 'click', '.prodId', function () {
      $('#btnSectionSubmit').hide();
      $('#btnSectionUpdate').show();
      
      
      trIndex = $(this).closest('td');
      const d = DTable.row( $(this).closest('tr') ).data();
      selected = d;
      

      populate('form', d);
      
      $("#newSectionModal .modal-title").text('Update Record');
      $("#newSectionModal").modal("show");
      $('#usr').attr('disabled', 'disabled');
  });


  // del row
  $('#section-table tbody').on( 'click', '.btn-delete-row', function () {
      const conf = confirm("Are you sure you want to delete this record?");
      if(!conf)
      return;
      const d = DTable.row( $(this).closest('tr') ).data();
      axios.post('rem-section', {
        sectionId: d.sectionId,
      })
      .then(res=>{
        DTable.row( $(this).parents('tr') ).remove().draw();
      })
      .catch(er=>er)
  });



// populate
function populate(form, data){
    const formdata = $(form).serializeArray();
    for (const iterator of formdata) {
      $(`[name=${iterator.name}]`).val(data[iterator.name])
    }
}

$(document).on('submit','form#sectionForm',function(e){
  e.preventDefault();
  submitSectionForm();
});

// submit form
$('#btnSectionSubmit').click(function(e){
  e.preventDefault();
  submitSectionForm();

});

function submitSectionForm(){
  const url = $('#sectionForm').attr('action');
  
  if($('#section').val() == '')
  return;
  
  const formData = new FormData(document.querySelector('form'));
  const params = getFormData($("form"));
  axios.post(url, formData)
  .then(res=>{
    params['sectionId'] = res.data;
    DTable.row.add(params).draw();
    $("#newSectionModal").modal('hide');
  })
  .catch(er=>{
    alert(er.response.data.message);
  });
}
// update form
$('#btnSectionUpdate').click(function(e){
  e.preventDefault();
  const url = 'update-section';
  
  if($('#section').val() == '')
  return;


  const formData = new FormData(document.querySelector('form'));
  formData.append('sectionId', selected.sectionId);
  axios.post(url, formData)
  .then(res => {
    
    DTable.row( trIndex ).data({...selected, ...res.data}).draw(); 
    $("#newSectionModal").modal('hide');
  })
  .catch(er=>{
    console.log(er);
    // alert(er.response.data.message);
  });
});



$("#newSectionModal").on('hide.bs.modal', function(){
    $('.disp-form').show();
    
    $('#btnSectionSubmit').show();
    $('#btnSectionUpdate').hide();

    $("#newSectionModal .modal-title").text('Add New Record');

    document.getElementById("sectionForm").reset();
    // $('#sectionForm')[0].reset();
    $('.invalid-feedback.guardian_contact').empty();
});



}