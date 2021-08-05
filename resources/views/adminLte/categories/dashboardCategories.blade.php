<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Categories</title>

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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/categories" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{route('profiles.show', ['profile' => $user->id])}}" role="button">
            @if(!isset($user->profile->image))
                <img src = "/images/default.png" alt ="" height = "30" width="30" class="border border-light rounded"><span>{{$user->name}}</span>
            @else
                <img src = "/images/{{$user->profile->image}}" alt ="" height = "30" width="30" class="border border-light rounded"><span>{{$user->name}}</span>
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
  <div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 d-flex">
            <h1 class="m-0">Categories</h1>
            <div class="ml-5">
               <a href="{{ route('create') }}" class="btn btn-success">Add Category</a>
            </div>
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
        <!-- Small boxes (Stat box) -->
        <div class="row w-100">
        <div class="col-12 ml-4">
            <div class="row">
                 <div class="d-flex justify-content-center">
                    {!! $categories->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            <div class="row">
                <div class="card w-75">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr> 
                                <th scope="row">{{$category->id}}</th>
                                <td>{{$category->title}}</td>
                                <td>{{$category->description}}</td>
                                <td>
                                    <a href="{{ route('editCategory', $category->id) }}" class="btn btn-primary">Update Category</a>
                                    <a href="{{ route('deleteCategory', $category->id) }}" class="btn btn-danger">Delete Category</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!-- /.row (main row) -->
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
<!-- ./wrapper -->

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