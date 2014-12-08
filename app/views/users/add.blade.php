@extends('layout.admin-main')

@section('body-content')

<table width="250px" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCC" >
    <tr>
        <td>
            {{ Form::open(array('route' => array('user-cretae-post'), 'role'=>"form")) }} 
            <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#f1f1f1" style="padding:20px;" border="4" >
                <tr>
                    <td>Add User <img src="../images/m-logo.png" height="20px" style="float:right;"></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td><!-- <span style="font-size:small;font-weight:bold;">Username:</span><br/> -->
                       
                        {{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'placeholder'=>'User Name')) }}
                        <!-- <input name="username" type="text" id="username" size="30" style="padding-left:5px" > --></td>
                     @if($errors->has('username'))
                                            <button type="button" class="btn btn-warning">{{ $errors->first('username') }}</button>
                
                                            @endif
                    </tr>
                    <tr>
                        <td><!-- <span style="font-size:small;font-weight:bold;">Password:</span><br/> -->
                            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password') ) }}
                            <!-- <input name="password" type="password" id="password" size="30" style="padding-left:5px" > --></td>
                        @if($errors->has('password'))
                                            <button type="button" class="btn btn-warning">{{ $errors->first('password') }}</button>
                
                                            @endif
                        </tr>
                        <tr>
                            <td><!-- <span style="font-size:small;font-weight:bold;">Google Apps Email:</span><br/> -->
                                {{ Form::text('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'Google Apps Email:')) }}
                                <!-- <input name="email" type="text" id="email" size="30" style="padding-left:5px" > --></td>
                            @if($errors->has('email'))
                                            <button type="button" class="btn btn-warning">{{ $errors->first('email') }}</button>
                
                                            @endif
                            </tr>
                            <tr>
                                <td>
                                        <button type="submit" class="btn btn-success">Add User</button><!-- 
                                    <input style="float:right;" type="submit" name="submit" value="Add User"> --></td>
                            </tr>
                        </table>
                        {{ Form::close() }}
                    </td>
                </tr>
            </table>
            @stop 