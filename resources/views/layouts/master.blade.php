<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/datatable-net.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      .nav-side-menu ul .sub-menu li.active-tab, .nav-side-menu li .sub-menu li.active-tab {
    color: #d19b3d !important;
}
      .active-tab {
        color: #d19b3d !important;
      }
        .nav-side-menu {
            overflow: auto;
            font-family: verdana;
            font-size: 12px;
            font-weight: 200;
            background-color: #2e353d;
            /* position: fixed; */
            top: 0px;
            width: 100%;
            height: 100vh;
            color: #e1ffff;
        }
        .nav-side-menu .brand {
            background-color: #23282e;
            line-height: 50px;
            display: block;
            text-align: center;
            font-size: 14px;
        }
        .nav-side-menu .toggle-btn {
            display: none;
        }
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
    /*    
        .collapsed{
        .arrow:before{
                    font-family: FontAwesome;
                    content: "\f053";
                    display: inline-block;
                    padding-left:10px;
                    padding-right: 10px;
                    vertical-align: middle;
                    float:right;
                }
        }
    */
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d19b3d;
}

.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  font-family: Fontawesome;
  content: "-";
  display: inline-block;
  padding-left: 20px;
  padding-right: 10px;
  vertical-align: middle;
}
.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
}
body {
  margin: 0px;
  padding: 0px;
}

.nav-side-menu ul .sub-menu ul .sub-line li.active,
.nav-side-menu li .sub-menu li .sub-line li.active {
  color: #d19b3d;
}

.nav-side-menu ul .sub-menu li .sub-line li.active a,
.nav-side-menu li .sub-menu li .sub-line li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li .sub-line li,
.nav-side-menu li .sub-menu li .sub-line li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li .sub-line li:hover,
.nav-side-menu li .sub-menu li .sub-line li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li .sub-line li:before,
.nav-side-menu li .sub-menu li .sub-line li:before {
  font-family: FontAwesome;
  content: "\f105";
  display: inline-block;
  padding-left: 100px;
  padding-right: 10px;
  vertical-align: middle;
}

.nav-side-menu .sub-menu li {
  padding-left: 20px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu .sub-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.sub-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li .sub-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
 .nav-side-menu .sub-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
.nav-side-menu  .sub-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }

  .sub-line ul .sub-press li.active,
.sub-line li .sub-press li.active {
  color: #d19b3d;
}

.sub-line ul .sub-press li.active a,
.sub-line li .sub-press li.active a {
  color: #d19b3d;
}
.sub-line ul .sub-press li,
.sub-line li .sub-press li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.sub-line ul .sub-press li:hover,
.sub-line li .sub-press li:hover {
  background-color: #020203;
}
.sub-line ul .sub-press li:before,
.sub-line li .sub-press li:before {
  font-family: Arial;
  content: "\f105";
  display: inline-block;
  padding-left: 50px;
  padding-right: 10px;
  vertical-align: middle;
}

.sub-line li {
  padding-left: 20px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.sub-line li a {
  text-decoration: none;
  color: #e1ffff;
}
.sub-line li a i {
  padding-left: 50px;
  width: 20px;
  padding-right: 20px;
}
.sub-line li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
}
@media (max-width: 767px) {
  .sub-line {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .sub-line .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
}

    @keyframes blink {
        0% { background-color: #a7a7ed; }
        50% { background-color: #3737a2; } /* Change to your desired blinking color */
        100% { background-color: #a7a7ed; }
    }

    .blinking-background {
        animation: blink 1s infinite; /* You can adjust the duration (2s) as needed */
    }
    </style>
</head>

<body>
  <?php
    use Illuminate\Support\Facades\Route;

    $currentRoute = Route::currentRouteName();
  ?>
  <div id="app" class = "container-fluid">
    <div class = "row">
      <div class = "col-md-2" style = "padding-right:0px;padding-left:0px">
        <div class="nav-side-menu">
          <div class="brand">{{env("APP_NAME")}}</div>
          <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
          <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out">
              <li id = "dashboard.dashboard">
                <a href="{{ route('dashboard.dashboard') }}"><i class="fa fa-dashboard fa-lg"></i>Dashboard</a>
              </li>

              <li id = "dashboard.dashboard">
                <a href="{{ route('dashboard.fund.transfer.pending') }}"><i class="fa fa-sack-dollar fa-lg"></i>Fund To Be Transferred</a>
              </li>

              <li data-toggle="collapse" data-target="#products" aria-expanded = "true" class>
                <a href="#"><i class="fa fa-gift fa-lg"></i> Products <span class="arrow"></span></a>
              </li>

              <ul class="sub-menu collapse show" id="products">
                  <li id = "dashboard.products.pending"><a href="{{ route('dashboard.products.pending') }}">Pending Products</a></li>
                  <li id = "dashboard.products.live"><a href="{{ route('dashboard.products.live') }}">Live Auction</a></li>
                  <li id = "dashboard.products.upcoming"><a href="{{ route('dashboard.products.upcoming') }}">Upcoming Auction</a></li>
                  <li id = "dashboard.products.history"><a href="{{ route('dashboard.products.history') }}">Auction History</a></li>
              </ul>

              <li data-toggle="collapse" data-target="#categories" aria-expanded = "true">
                <a href="#"><i class="fa fa-globe fa-lg"></i>Categories <span class="arrow"></span></a>
              </li>

              <ul class="sub-menu collapse show" id="categories">
                <li id = "dashboard.categories.create"><a href="{{ route('dashboard.categories.create') }}">Create New</a></li>
                <li id = "dashboard.categories.index"><a href="{{ route('dashboard.categories.index') }}">Categories List</a></li>
              </ul>

              <li data-toggle="collapse" data-target="#users" aria-expanded = "true">
                <a href="#"><i class="fa fa-car fa-lg"></i>Users<span class="arrow"></span></a>
              </li>

              <ul class="sub-menu collapse show" id="users">
                <li id = "dashboard.users.index"><a href="{{ route('dashboard.users.index') }}">Users List</a></li>
              </ul>

              <li data-toggle="collapse" data-target="#admins" aria-expanded = "true">
                <a href="#"><i class="fa fa-car fa-lg"></i>System Admins<span class="arrow"></span></a>
              </li>
              @php
                $permissions = config("permissions");
                $authRole = auth()->user()->role?->slug;
                $authPermissions = $permissions[$authRole] ?? [];
              @endphp
              <ul class="sub-menu collapse show" id="admins">
                @if (in_array("app.http.controllers.admin.admincontroller.create", $authPermissions))
                  <li id = "dashboard.users.create"><a href="{{ route('dashboard.admins.create') }}">Create New</a></li>
                @endif
                <li id = "dashboard.users.index"><a href="{{ route('dashboard.admins.index') }}">Admins List</a></li>
              </ul>
            </ul>
          </div>
        </div>
      </div>
      <div class = "col-md-10">
        <div class="row">
          <div class = "col-md-12" style = "padding:0px">
            <div class = "dashboard-header" style = "height:50px; background-color: black;padding-right: 30px">
              <ul class="nav navbar-nav navbar-right" style = "float:right">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('dashboard.profile.edit') }}" >
                            My profile
                        </a>
                    </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-12">
              @include('layouts.messages')
              @yield('content')
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('js/dashboard/datatable.js') }}"></script>
<script>
  $('.dashboard-btn, .sidebar-close-btn').on('click', function() {
      $('#sidebar').toggleClass('sidebar-hidden');
      $('#sidebar').toggleClass('sidebar-visible');
    });

    $(document).ready(function() {
         new DataTable('#example');
         new DataTable('#example-auction-history-failed');
         new DataTable('#example-auction-history-paid');
         new DataTable('#example-auction-failed');
         new DataTable('#example-auction-history-unpaid');
        var route = @json($currentRoute);
        var activeTab = document.getElementById(route);
        activeTab.classList.add("active");
    });
    </script>
@yield('js')

</html>