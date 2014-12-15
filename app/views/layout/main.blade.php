<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Product Master - Motochanic</title> 
        {{ HTML::script('js/jquery-1.9.1.min.js') }}
        {{ HTML::script('js/jquery-ui.min.js') }}
        {{ HTML::style('css/motosql.css') }}
        {{ HTML::style('css/jquery-ui.min.css') }}
        <script type="text/javascript">
          $(document).ready(function(){
            alert('Hello');

          }); 


            function select(elem) {
                var sel = window.POSTSelection();
                var range = sel.POSTRangeAt(0);
                range.selectNode(elem);
                sel.addRange(range);
            }
        </script>
    </head>
    <body>
    <div class="wrapper">
        <div id="productSearch">
            <a href="#"><img src="images/m-logo.png" id="headerLogo"/></a>
            <form method="get" action="search.php" id="searchForm">
                <?php
                    if (isset($_GET['q'])) {
                        $name = strip_tags($_GET['q']);
                        echo '<input id="searchField" type="text" name="q" size="70" value="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '">';
                    } else {
                        echo '<input id="searchField" type="text" name="q" size="70">';
                    };
                ?>
                <input type="submit" name="submit" value="Search">
            </form>
        </div>