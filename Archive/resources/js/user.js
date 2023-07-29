import axios from 'axios';

if($('#user-table').length){
  let DTable = $('#user-table').DataTable({
    scrollX: true,
    language: { search: "" , searchPlaceholder: "Search..." },
    pageLength: 2,
    bInfo: true,
    bLengthChange: false,
    dom: 'Bfrtip',
      buttons: [
          'excel', 'print',
      ]
  });

  $('#user-table tbody').on( 'click', 'tr', function () {
    $('#btnUserSubmit').hide();
    $('#btnUserUpdate').show();
    var d = DTable.row( this ).data();
    // selectedRow = d;
    // // trIndex = $(this).closest("tr").index();
    // trIndex = $(this);

    // $('.modal-title').html('Update Product');
    // $('#prodName').val(d.prodName);
    // $('#category').val(d.category);
    // $('#qty').val(d.qty);
    // $('#basePrice').val(d.basePrice);
    // $('#sellingPrice').val(d.sellingPrice);
    // $('#reorderPoint').val(d.reorderPoint);

    // $('#btnUpdate').attr("data-id", d.prodId);
    // $("#inventoryModal").modal('show');
    $("#newUserModal .modal-title").text('Update Record');
    $("#newUserModal").modal("show");
});

}

$('#btnUserSubmit').click(function(e){
  e.preventDefault();
  axios.get('qr')
  .then(res=>{
    $('.disp-form').toggle();
    $('.disp-qr').show();
    $('.disp-qr').html(res.data);
  })
  .catch(er=>e);
});


$("#newUserModal").on('hide.bs.modal', function(){
    $('.disp-form').show();
    $('.disp-qr').hide();

    $('#btnUserSubmit').show();
    $('#btnUserUpdate').hide();

    $("#newUserModal .modal-title").text('Add New Record');
});


