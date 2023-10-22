<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Billable</title>
  <style>
    body{
      font-family: arial;
      width: 800px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  
  @if( $emailBody  == 'io')         
    @include('mail.io')        
  @else
    @include('mail.amira')        
  @endif
  
</body>
</html>