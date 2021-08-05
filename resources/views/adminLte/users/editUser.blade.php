<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit User</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <script src="https://kit.fontawesome.com/c0a888d572.js" crossorigin="anonymous"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/categories" class="nav-link">Home</a>
      </li>
    </ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{route('profiles.show', ['profile' => $loggedUser->id])}}" role="button">
            @if(!isset($loggedUser->profile->image))
                <img src = "/images/default.png" alt ="" height = "30" width="30" class="border border-light rounded"><span>{{$loggedUser->name}}</span>
            @else
                <img src = "/images/{{$loggedUser->profile->image}}" alt ="" height = "30" width="30" class="border border-light rounded"><span>{{$loggedUser->name}}</span>
            @endif
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">


    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <p>
                <i class="fas fa-tachometer-alt fa-lg"></i> Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="{{ route('indexUsers') }}" class="nav-link">
              <p>
                <i class="fas fa-users fa-lg"></i> Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('indexReplies') }}" class="nav-link">
              <p>
              <i class="fas fa-comments fa-lg"></i> Replies
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('indexTopics') }}" class="nav-link">
              <p>
                <i class="fas fa-comment-alt fa-lg"></i> Topics
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('indexCategories') }}" class="nav-link">
              <p>
                <i class="fas fa-layer-group fa-lg"></i> Categories
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row h-100">
                <div class="col-12 ml-4">
                    <div class="row">
                        <div class="card w-75">
                            <form method="POST" action="{{route('updateUser',[$user->id])}}" id="form">
                                @csrf
                                <div class="col-12 p-4">
                                    <div class="form-group">
                                        <label for="username" class="form-label"><h5>User Name</h5></label>
                                        <input id="userName" type="text" class="form-control @error('userName') is-invalid @enderror" name="userName" value="{{old('userName') ?? $user->name}}" autofocus>
                                        @error('userName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="userEmail" class="form-label"><h5>User Email</h5></label>
                                        <input id="userEmail" type="email" class="form-control @error('userEmail') is-invalid @enderror" name="userEmail" value="{{old('userEmail') ?? $user->email}}" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio" id="radio1" value="user" checked>
                                        <label class="form-check-label" for="radio1">
                                            <h5>User</h5>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio" id="radio2" value="admin">
                                        <label class="form-check-label" for="radio2">
                                            <h5>Admin</h5>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

</body>
</html>