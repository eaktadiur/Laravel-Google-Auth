<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>DB - Motochanic</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.ico" />
	{{ HTML::script('js/jquery-1.9.1.min.js') }}
	{{ HTML::script('js/jquery-ui.min.js') }}
	{{ HTML::style('css/motosql.css') }}
	{{ HTML::style('css/jquery-ui.min.css') }}
	<!-- Bootstrap Core CSS -->

</head>
<body>
	<table width="280" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCC" >
		<tr>
			
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#f1f1f1" style="padding:20px;" >
					<tr>
						<td><img src="images/m-logo.png" height="20px" style="float:left;"></td>
					</tr>
					<tr>
						<td id="loginMessage">
							@if(Session::has('message'))
				            <div class="alert alert-{{ Session::get('message_type') }}">
				              <span type="button" class="close" data-dismiss="alert">&times;</span>
				             <strong> {{ Session::get('message') }}</strong>
				            </div>
				        @endif
						</td>
					</tr>
					<tbody id="googlelogin" style="display:;">
						<tr>
							<td>
								<!-- <button name="google_oauth2">Login with Google</button> -->
								<a href="gauth" ><input name="google_oauth2" type="image" src="images/google-button.png"/></a>
								
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" id="showlegacy" style="float:right;font-size:10px;">legacy</a>
							</td>
						</tr>
					</tbody>
					<tbody id="legacylogin" style="display:none;">
						{{ Form::open(array('route' => array('user-sign-in-post'))) }} 
						<tr>
							<td><span style="font-size:small;font-weight:bold;">Username:</span><br/>
								{{ Form::text('username') }}

								@if($errors->has('username'))
								{{ $errors->first('username') }}
								@endif
							</td>
						</tr>
						<tr>
							<td><span style="font-size:small;font-weight:bold;">Password:</span><br/>
								{{ Form::password('password') }}

								@if($errors->has('password'))
								{{ $errors->first('password') }}
								@endif
							</td>
						</tr>
						<tr>
							<td>{{ Form::submit('Login') }}</td>
						</tr>
						<tr>
							<td>
								<a href="#" id="showgoogle"style="float:right;font-size:10px;">Google Login</a>
							</td>
						</tr>
						{{ Form::close() }}
					</tbody>
				</table>
			</td>	
			
			<div id="result"></div>
		</tr>
	</table>
</body>
<script>
$(document).ready(function() {
	
	$("#username").focus();
	
	// $("input[name=google_oauth2]").on("click", function (event) {
		
	// 			// Redirect
	// 			window.location = 'https://db.motochanic.com/';
				
	// 			// Cancel Event
	// 			event.preventDefault();
				
	// 		});
	
	$("#showlegacy").click(function () {
		$("#legacylogin").show("slow");
		$("#googlelogin").hide("fast");
	});
	$("#showgoogle").click(function () {
		$("#legacylogin").hide("fast");
		$("#googlelogin").show("slow");
	});

	
});
</script>

</html>
