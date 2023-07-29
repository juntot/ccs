<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>QR Application</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ URL::to('/public/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ URL::to('/public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ URL::to('/public/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ URL::to('/public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ URL::to('/public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ URL::to('/public/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ URL::to('/public/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ URL::to('/public/assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ URL::to('/public/css/app.css') }}" rel="stylesheet">
  <style>
    #hero-login {
      width: 100%;
      height: 100vh;
      background: url(public/assets/img/login-bg.jpg) top right no-repeat;
      background-size: cover;
      position: relative;
    }
    #hero-login:before {
        content: "";
        background: rgb(32 31 31 / 70%);
        position: absolute;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
    }
    .container{
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .row{
      justify-content: center;
    }
    form{
      color: #fff;
    }
    form input{
      padding: 24px !important;
      color: #fff !important;
      background: transparent !important;
      border-radius: 50px !important;
      text-align: center !important;
    }
    .form-group{
      margin-bottom: 25px;
    }

    input:active, input:focus{
      /* background: #2d8c3f; */
      border-color: #2d8c3f !important;
      box-shadow: 0 0 0 0.01rem #28a745 !important;
    }


    .btn{
      width: 100%;
      padding: 5%;
      border-radius: 50px;
    }

    .btn-primary{
      background: #047218;
      border-color: #047218;
    }

    .btn-primary:hover{
      background: #2d8c3f;
      border-color: #2d8c3f;
    }

    .btn-primary:active, .btn-primary:focus{
      background: #2d8c3f;
      border-color: #2d8c3f;
      box-shadow: 0 0 0 0.2rem #28a745;
    }
  </style>
</head>

<body>
  <div id="hero-login">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
                  <form action="authlogin" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Enter email" id="email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Enter password" id="pwd">
                    </div>
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-primary">Login</button>
                  </form>
            </div>
          </div>
        </div>
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="{{ URL::to('/public/assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/aos/aos.js') }}"></script>
  <!-- <script src="{{ URL::to('/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
  <script src="{{ URL::to('/public/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/typed.js/typed.min.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ URL::to('/public/assets/vendor/php-email-form/validate.js') }}"></script>
  <!-- endinject -->



</body></html>