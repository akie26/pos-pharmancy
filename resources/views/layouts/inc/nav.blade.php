<!-- Sidebar -->
<div class="bg-light border-right shadow-sm" id="sidebar-wrapper">
  <div class="list-group list-group-flush text-center">
    <div class="sidebar-heading" style="font-size: 18px;letter-spacing:2px;font-weight:600;"><i class="fab fa-pinterest-p"></i></div>
    <a href="{{route('cart.index')}}" id="store" class="list-group-item list-group-item-action">
      <i class="fab fa-opencart"></i></a>
      <a href="{{route('products.index')}}" id="products" class="list-group-item list-group-item-action">
        <i class="fas fa-tshirt"></i></a>
        <a href="{{route('income.index')}}" id="income" class="list-group-item list-group-item-action">
          <i class="fas fa-money-check"></i></a>
          <a href="{{route('discounts.index')}}" id="discount" class="list-group-item list-group-item-action">
            <i class="fas fa-percentage"></i></a>
  </div>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">

  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-2">
    
    <div class="sidebar-heading" style="margin-bottom:-5px; font-size: 19px;letter-spacing:2px;font-weight:600;">PRISMA</div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" id="nav-link" onclick="document.getElementById('logout-form').submit()" href="#">LOGOUT<span class="sr-only">(current)</span></a>
          <form action="{{route('logout')}}" method="POST" id="logout-form">
            @csrf
        </form>
        </li>
      </ul>
    </div>
  </nav>

  
