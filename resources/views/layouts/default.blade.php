<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('css/app.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('css')
</head>
<div class="d-flex" id="wrapper"> 
@include('layouts.inc.nav')
  
<div class="container-fluid" id="app">
  
    @yield('content')

</div>
</div>
  



<script src="{{ asset('js/app.js')}}"></script>

<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  {{-- <!-- Menu Toggle Script --> --}}
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
@yield('js')
</body>
</html>
