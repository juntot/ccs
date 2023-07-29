function request(url, method, params = '', cb, contentType= "application/json"){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
      url: url,
      type: method,
      contentType: contentType,
      data: params,
      success: function (data, textStatus, xhr) {
        return cb(xhr.status, data);
      },
      error: function (request, status, error) {
        return cb(request.status, request.responseText);
      },
      
  });
}