    <div class="wrapper">
        <div id="productSearch">
            <a href="/search.php"><img src="{{asset("/images/m-logo.png")}}" id="headerLogo"/></a>
            <h1>Admin Panel</h1>
        </div>
        
        <div id="topNav">
            <div id="navLinks">
               <!--  <div class="navLink">
                    <a href="/search.php">Search</a>
                </div> -->
                <div class="navLink" style="float:left;">
                    <a href="{{ URL::route('user-list') }}">User List</a>
                </div>
                <div class="navLink" style="float:left;">
                    <a href="{{ URL::route('user-create') }}">New User</a>
                </div>
                 <div class="navLink" style="float:right;">
                    <a href="{{ URL::route('user-sign-out') }}">Logout</a>
                </div>
                <div class="navLink" style="float:right;"><a href="#">
                    @if( Auth::check() )
                    {{ Auth::user()->email }}
                    @endif
                    </a> </div> 

               
            </div>
        </div>