<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Auction | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
  {{-- Select 2 --}}
  <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backend/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/css/AdminLTE.min.css') }}">
  
  {{-- Theme Color CSS --}}
  <link rel="stylesheet" href="{{ asset('backend/css/skin-purple.min.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">

  {{-- CUSTOM CSS BY SHRESTSAV --}}
  <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
  <style type="text/css" media="print">
    .printer{
      display:none;
      }
  </style>
  

  @stack('styles')

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-purple sidebar-mini {{Session::get('theme_sidebar')}}">
  <div class="wrapper printer">

    <header class="main-header">
      @include('backend.layouts.includes.header')
    </header>


    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      @include('backend.layouts.includes.sidebar');
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          {{$title}}
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">{{$title}}</li>
        </ol>
      </section>
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2019-2022</strong> All rights
      reserved.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

    @stack('modals')
    
<!-- jQuery 3 -->
<script src="{{ asset('backend/js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/js/select2.full.min.js') }}"></script>
<script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);

// SET AJAX CSRF TOKEN
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  

  $(function () {
      $('.select2').select2();
  });


  $('.sidebar-toggle').on('click',function(){
    if($('body').hasClass("sidebar-collapse")){
      sidebar_state='';
    }
    else{
      sidebar_state='sidebar-collapse';
    }
    
    $.ajax({
      url: "{{ url('/set_sidebar') }}",
      method: 'post',
      data: {
         id: '{{ Auth::user()->id }}',
         theme_sidebar: sidebar_state
      },
      success: function(response){
         console.log(response);
      }
    });



  });

</script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script src="{{ asset('backend/js/adminlte.min.js') }}"></script>
<script src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
@stack('scripts')

</body>
</html>
