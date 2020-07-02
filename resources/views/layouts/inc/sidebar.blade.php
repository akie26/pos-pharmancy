<aside class="main-sidebar .custom-range-200 sidebar-dark-primary elevation-4">
    <a href="http://127.0.0.1:8000/home" class="brand-link">
      <img src="{{ asset('images/logo.png')}}"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/avatar.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" style="text-transform: uppercase;">
          @if (Auth::user()->hasRole('admin'))
          <a  class="d-block">{!! Auth::user()->name !!}</a>
          @else
          <a  class="d-block">{!! Auth::user()->name!!} BRANCH</a>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="{{ route('home')}}" class="nav-link home" >
              <i class="nav-icon fas fa-home" ></i>
              <p>
                HOME
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('products.index')}}" class="nav-link products" >
              <i class="nav-icon fas fa-th-large" ></i>
              <p>
                PRODUCTS
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview acc-menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                ACCOUNTING
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('expense.index')}}" class="nav-link expenses">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>EXPENSES</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('income.index')}}" class="nav-link incomes">
                  <i class="fas fa-coins nav-icon"></i>
                  <p>INCOME</p>
                </a>
              </li>
            </ul>
            <li class="nav-item has-treeview">
              <a href="{{ route('discounts.index')}}" class="nav-link discount" >
                <i class="nav-icon fas fa-tags" ></i>
                <p>
                  DISCOUNTS
                </p>
              </a>
            </li>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>