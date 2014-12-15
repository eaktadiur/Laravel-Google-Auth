<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>
    @if(isset($title)) 
    {{ $title }}
    @else
    Product Master - Motochanic
    @endif
  </title>

  {{ HTML::style('css/motosql.css') }}
  {{ HTML::style('css/jquery-ui.min.css') }}
  <!-- Bootstrap Core CSS -->
  {{ HTML::style('css/bootstrap.min.css') }}

</head>
<body>



 @include('layout.top_nav_admin')
 <div class="container">
   @if(Session::has('message'))
   <div class="alert alert-{{ Session::get('message_type') }}">
    <span type="button" class="close" data-dismiss="alert">&times;</span>
    <strong> {{ Session::get('message') }}</strong>
  </div>
  @endif
  
  @yield('body-content')
</div>
<!-- jQuery -->
{{ HTML::script('js/jquery-1.11.0.min.js') }}
{{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
{{ HTML::script('js/jquery-ui.min.js') }}
<!-- Bootstrap Core JavaScript -->
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/plugins/dataTables/jquery.dataTables.js') }}
{{ HTML::script('js/plugins/dataTables/dataTables.bootstrap.js') }}

<script type='text/JavaScript'>
  $(document).ready(function() {
        //$('#dataTables-example').dataTable();
        // alert(1);

        $("input:text:visible:first").focus();
        $("#addField").click( function() {
         $("#colorFields").append('<p><label>Color <input type="text" name="colors[]" /></label></p>');
       });
        $("input:checkbox:not(:checked)").each(function() {
         var column = "table ." + $(this).attr("name");
         $(column).hide();
       });
        $("input:checkbox").click(function(){
         var column = "table ." + $(this).attr("name");
         $(column).toggle();
       });
        
      });
</script>


</body>
</html>
