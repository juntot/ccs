import axios from "axios";
let startDate = moment(new Date()).format('YYYY-MM-DD');
let endDate = moment(new Date()).format('YYYY-MM-DD');
let items = [];
if($('#report-table').length){
  $.fn.dataTableExt.oSort['time-date-sort-pre'] = function(value) {      
    return Date.parse(value);
  };
  $.fn.dataTableExt.oSort['time-date-sort-asc'] = function(a,b) {      
      return a-b;
  };
  $.fn.dataTableExt.oSort['time-date-sort-desc'] = function(a,b) {
      return b-a;
  };
  let DTable = $('#report-table').DataTable({
    data: items,
    order: [[ 5, "desc" ], [ 0, "asc" ]],
    columns: [
      { data: '_userId', title:'User ID',  className: "table-prodId", render: function(data){
          return data;
      }},
      // { data: 'avatar', title: 'Photo',  render: function(data){
      //   const img = new Image();
      //   const profile = data ? 'storage/app/'+data : 'public/assets/img/default-avatar.png';
      //   img.src = profile;
        
      //   return `<img class="avatar-profile" src="${profile}">`;
      // }},

      { data: 'fullname', title:'Full Name' },
      { data: 'section', title: 'Section'},
      { data: 'guardian', title: 'Parent/Guardian' },
      { data: 'guardian_contact', title: 'Parent/Guardian Contact Number' },
      { data: 'date_created', title: 'Date', render: function(data){
        return moment(data).format('YYYY-MM-DD hh:mm A');
      } },
      { data: 'status', title: 'Status' },
      { data: 'sms', title: 'sms', render: function(data, type, row){
        return Number(row.badnum)? 'system generated': Number(data) == 1? 'sent': 
        Number(data) > 1? 
        `<button class="btn btn-warning btn-retry-sms" id="${row._userId}" data-date="${row.date_created}">retry</button>`: 
        'waiting';
      } },
    ],
    columnDefs : [
      { type: 'time-date-sort', 
        targets: [5],
      }
    ],
    rowCallback: function( row, data ) {
       let rowText = $('td:eq(8)', row);
       
       switch(rowText.text()){
         case 'sent':
            rowText.addClass("text-success")
            break;
         case 'failed':
            rowText.addClass("text-danger")
            break;
         default:
            rowText.addClass("text-warning")
            break;
       }
    },
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



    $('#btnSearch').click(function(){
        axios.post('report-info', {
          datefrom: moment(startDate).format('YYYY-MM-DD 00:00:00'),
          dateto: moment(endDate).format('YYYY-MM-DD 23:59:59'),
          keyword: ($('#keyword').val()).trim()
        })
        .then(res=>{
          DTable.clear();
          DTable.rows.add(res.data).draw();
        })
        .catch(er=>console.log(er));
    });


    $('input[name="daterange"]').daterangepicker({
      opens: 'right'
    }, function(start, end, label) {
      startDate = start.format('YYYY-MM-DD');
      endDate = end.format('YYYY-MM-DD');
    });


    $('table#report-table').on('click', '.btn-retry-sms', async function(){
      let self = $(this).attr('id');
      let selfDate = $(this).attr("data-date");
      const res = await axios.post('retry-sms', { _userId: self, date_created: selfDate });
      if(res){
        DTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
              var d = this.data();
              
              if(d._userId == self && d.date_created == selfDate)
              d.sms = 0; // update data source for the row
              if(d._userId == self && d.date_created == selfDate)
              this.invalidate(); // invalidate the data DataTables has cached for this row
        } );
        // Draw once all updates are done
        DTable.draw();
      }
    
    })
}