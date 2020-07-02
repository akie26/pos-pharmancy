<nav class="main-header navbar navbar-expand navbar-light justify-content-between">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <a class="navbar-brand ml-5 text-right" style="text-transform: uppercase;font-weight:600" href="#"></a>
    </li>
    </ul>
  

  <ul class="navbar-nav">
    <li class="nav-item mr-5">
      <a href="{{ route('cart.index')}}" class="btn btn-out btn-cart">
        <i class="nav-icon fas fa-shopping-cart"></i>
        POS CART
      </a>
    </li>
    <li class="nav-item ml-5">
      @role('admin')
      <a href="{{route('admin.back')}}" class="btn btn-out" style="font-weight: 600">
        <i class="fas fa-long-arrow-alt-left"></i>&nbsp;&nbsp;ADMIN PANNEL
      </a>
      @else
      <a href="#" class="btn btn-out" style="font-weight:600" onclick="document.getElementById('logout-form').submit()">
        <i class="nav-icon fas fa-sign-out-alt"></i>&nbsp;&nbsp;LOGOUT
        <form action="{{route('logout')}}" method="POST" id="logout-form">
            @csrf
        </form>
    </a>
      @endhasanyrole
      
      
      
  </li>
  </ul>
</nav>