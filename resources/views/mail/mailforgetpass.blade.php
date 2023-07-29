<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <center>
  <table width="100%" border="0">
    <tr>
      <td style="background: #4B49AC; padding: 1rem 3rem;">
        <h2 style="font-color: #ffff; color: #ffff;">Request Password</h2>
      </td>
    </tr>
    <tr >
      <td style="vertical-align: middle; padding-top: 100px; padding-bottom: 40px; line-height: 2;">
        {!! $emailBody !!}
      </td>
    </tr>
    <tr>
      <td style="padding-bottom: 100px;">
        <p>
          <a href="{{ $uriLink }}" 
          style="color: #fff;
            background-color: #4B49AC;
            border-color: #4B49AC;
            padding: 1rem 3rem;
            padding-top: 1rem;
            padding-right: 3rem;
            padding-bottom: 1rem;
            padding-left: 3rem;
            line-height: 1.5;
            border-radius: 10px;
            text-decoration: none;
          " >Click Here to Login</a>
        </p>
      </td>
    </tr>
    <tr>
      <td style="background: #6c7383; color: #ffff; padding: 15px; text-align:center">
        <p style="font-color: #ffff; color: #ffff;">homecareershire.com.au &copy; 2022</p> 
      </td>
    </tr>
  </table>
  </center>
</body>
</html>