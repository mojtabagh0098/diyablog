  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link{{ Request::is('dashboard') ? ' active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                    </a>
                </li>
                <li class="nav-item{{ Request::is('dashboard/posts') || Request::is('dashboard/posts/*') ? ' menu-open' : '' }}">
                    <a href="#" class="nav-link{{ Request::is('dashboard/posts') || Request::is('dashboard/posts/*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Posts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('posts.create')}}" class="nav-link{{ Request::is('dashboard/posts/create') ? ' active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Post</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('posts.index')}}" class="nav-link{{ Request::is('dashboard/posts') ? ' active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Posts</p>
                        </a>
                    </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link{{ Request::is('dashboard/categories') ? ' active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('tags.index')}}" class="nav-link{{ Request::is('dashboard/tags') ? ' active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tags</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('comments.index')}}" class="nav-link{{ Request::is('dashboard/comments') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Comments
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link{{ Request::is('dashboard/users') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/settings" class="nav-link{{ Request::is('dashboard/settings') ? ' active' : '' }}">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        Settings
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="nav-icon fas fa-table"></i>
                        <p>{{ __('Log Out') }}</p>
                    </a>
                </li>
            </ul>
        </form>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>