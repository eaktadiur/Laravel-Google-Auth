@extends('layout.admin-main')

@section('body-content')

	
	{{ Form::open(array('route' => array('put-user-update', $user->id), 'method'=>'put')) }} 
<table class="table">
	<tbody>
	<tr>
		<td>User Name</td>
		<td>{{ Form::text('username', $user->username) }}</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>{{ Form::text('email', $user->email) }}</td>
	</tr>

    
    <tr>
		<td></td>
		<td>{{ Form::submit('Update User') }}</td>
	</tr>
    </tbody>
    

{{ Form::close() }}

@stop