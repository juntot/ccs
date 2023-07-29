if($('#report-table').length){
  let DTable = $('#report-table').DataTable({
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
}