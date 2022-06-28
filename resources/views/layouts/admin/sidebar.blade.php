  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
      // echo request()->segment(4);
      // die;

    ?>
    <a href="{{asset('/')}}" class="brand-link">
      <img src="{{ asset('admin/dist/img/MarlowsDiamonds-Logo.png')}}" alt="Marlow's Diamond" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Marlow's Diamond</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{isset(auth()->user()->nicename)?auth()->user()->nicename:''}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('admin.dashboard')}}" class="nav-link @if(request()->segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard </p>
            </a>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'banners') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'banners') active @endif">
              <i class="nav-icon fas fa fa-image"></i>
              <p>
                Banners
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/banners" class="nav-link @if(request()->segment(2) == 'banners' && request()->segment(3) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banners</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/banners/create" class="nav-link @if(request()->segment(2) == 'banners' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Banner</p>
                </a>
              </li>


            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'posts') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'posts') active @endif">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Blogs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/posts" class="nav-link @if(request()->segment(2) == 'posts' && request()->segment(3) != 'create' && request()->segment(3) != 'categories') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blogs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/posts/create" class="nav-link @if(request()->segment(2) == 'posts' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Blog</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/posts/categories" class="nav-link @if(request()->segment(2) == 'posts' && request()->segment(3) == 'categories') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'pages') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'pages') active @endif">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/pages" class="nav-link @if(request()->segment(2) == 'pages' && request()->segment(3) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pages</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/pages/create" class="nav-link @if(request()->segment(2) == 'pages' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Page</p>
                </a>
              </li>


            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'menus' || request()->segment(2) == 'header-settings' || request()->segment(2) == 'footer-settings') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'menus' || request()->segment(2) == 'header-settings' || request()->segment(2) == 'footer-settings') active @endif">
              <i class="nav-icon fas fa-tree"></i>
              <p>
               Appearance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.menus')}}" class="nav-link @if(request()->segment(2) == 'menus') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menus</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.header-settings')}}" class="nav-link @if(request()->segment(2) == 'header-settings') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Header Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.footer-settings')}}" class="nav-link @if(request()->segment(2) == 'footer-settings') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Footer Settings</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'products') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'products') active @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.products-list')}}" class="nav-link @if(request()->segment(2) == 'products' && request()->segment(3) == 'products') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.products-createform')}}" class="nav-link @if(request()->segment(2) == 'products' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{asset('admin/products/categories')}}" class="nav-link @if(request()->segment(2) == 'products' && request()->segment(3) == 'categories' && request()->segment(4) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{asset('admin/products/categories/create')}}" class="nav-link @if(request()->segment(2) == 'products' && request()->segment(3) == 'categories' && request()->segment(4) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'users') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'users') active @endif">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Customers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{asset('admin/users')}}" class="nav-link @if(request()->segment(2) == 'users') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item @if(request()->segment(2) == 'orders') menu-is-opening menu-open @endif">
            <a href="{{route('admin.order.details.page')}}" class="nav-link @if(request()->segment(2) == 'orders') active @endif">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Orders
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.order.details.page')}}" class="nav-link @if(request()->segment(3) == 'orders-details-page') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orders Lists</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Orders
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li> -->


          <li class="nav-item @if(request()->segment(2) == 'reviews') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'reviews') active @endif">
              <i class="nav-icon fa fa-comments"></i>
              <p>
                Reviews
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reviews" class="nav-link @if(request()->segment(2) == 'reviews' && request()->segment(3) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reviews</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/reviews/create" class="nav-link @if(request()->segment(2) == 'reviews' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Review</p>
                </a>
              </li>


            </ul>
          </li>

		  <li class="nav-item @if(request()->segment(2) == 'faqs') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'faqs') active @endif">
              <i class="nav-icon fa fa-question-circle"></i>
              <p>
                Faqs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/faqs" class="nav-link @if(request()->segment(2) == 'faqs' && request()->segment(3) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Faqs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/faqs/create" class="nav-link @if(request()->segment(2) == 'faqs' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Faq</p>
                </a>
              </li>


            </ul>
          </li>

		  <li class="nav-item">
            <a href="/admin/enquiries" class="nav-link @if(request()->segment(2) == 'enquiries') active @endif">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Newsletter Enquiries
                <!--<span class="badge badge-info right">2</span>!-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/appointments" class="nav-link @if(request()->segment(2) == 'appointments') active @endif">
              <i class="nav-icon far fa-calendar"></i>
              <p>
                Appointments
                <!--<span class="badge badge-info right">2</span>!-->
              </p>
            </a>
          </li>
		  <li class="nav-item @if(request()->segment(2) == 'popups') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'popups') active @endif">
              <i class="nav-icon far fa-window-maximize"></i>
              <p>
                Popups
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/popups" class="nav-link @if(request()->segment(2) == 'popups' && request()->segment(3) != 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Popups</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/popups/create" class="nav-link @if(request()->segment(2) == 'popups' && request()->segment(3) == 'create') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Popup</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(request()->segment(2) == 'discount') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(request()->segment(2) == 'discount') active @endif">
              <i class="nav-icon far fa-window-maximize"></i>
              <p>
                Discount
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/discount" class="nav-link @if(request()->segment(2) == 'discount') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Discount</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/discount/creatediscount" class="nav-link @if(request()->segment(2) == 'discount' && request()->segment(3) == 'creatediscount') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Discount</p>
                </a>
              </li>


            </ul>
          </li>
          <li class="nav-item">
            <a href="/admin/settings" class="nav-link @if(request()->segment(2) == 'settings') active @endif">
              <i class="nav-icon fas fa fa-cog"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.change-password') }}" class="nav-link @if(request()->segment(2) == 'change-password') active @endif">
              <i class="nav-icon fa fa-lock"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
		   <li class="nav-item">
            <a href="{{ route('admin.logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
