<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('css/app.css')}}">
  <style>
            .btn-cart{
                transition: 200ms all ease-in-out;
            }

            .btn-cart:hover{
                transform: scale(1.2);
            }

            .cart-active{
                background-color: rgb(13, 206, 6);
                transform: scale(1.2);
            } 
            .btn-out{
                border:1px solid #CCD1D1;
                color: #000000;
                outline:none;
                text-decoration: none;
            }
            .btn-out:hover{
                color: #CCD1D1;
            }
  </style>
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('layouts.inc.nav')
  @include('layouts.inc.sidebar')
  

  
  <div class="content-wrapper">
    <section class="content-header" style="text-transform: uppercase;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6"></div>
          <div class="col-sm-3">
            <h1>@yield('content-header')</h1>
          </div>
          <div class="col-sm-3 text-right">
            @yield('content-actions')
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      @yield('content')
    </section>
     
  </div>
  

  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<script src="{{ asset('js/app.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@yield('js')
</body>
</html>
