<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    @if(isset($title)) 
    {{ $title }}
    @else
    Product Master - Motochanic
    @endif


    {{ HTML::style('css/motosql.css') }}
    {{ HTML::style('css/jquery-ui.min.css') }}
    <!-- Bootstrap Core CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}

</head>
<body>

    @include('layout.top_nav_admin')

     
      <div class="container">

    <div id="page-wrapper" style="margin-top:90px;">
        @if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message_type') }}">
          <span type="button" class="close" data-dismiss="alert">&times;</span>
          <strong> {{ Session::get('message') }}</strong>
      </div>
      @endif
      
      @yield('body-content')
  </div>
  </div>
  <!-- jQuery -->
  {{ HTML::script('js/jquery-1.9.1.min.js') }}
  {{ HTML::script('js/jquery-ui.min.js') }}
  <!-- Bootstrap Core JavaScript -->
  {{ HTML::script('js/bootstrap.min.js') }}
</body>
</html>
