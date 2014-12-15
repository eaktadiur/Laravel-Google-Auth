@extends('layout.admin-main')

@section('body-content')


<div class="panel-body">

  <h1> {{ $pname }} </h1>
  {{ Form::open(array('route' => array('get-product-search-result'), 'role'=>"form", 'method'=>'get')) }} 
  <table width="40%" border="0" cellpadding="3" cellspacing="1" bgcolor="#f1f1f1" style="padding:20px;" border="4" >
       <!--  <tr>
            <td>{{ HTML::linkRoute('get-product-details', 'Details', 7800, array('class'=> 'btn btn-success') ) }}</td>
        </tr> -->
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>{{ Form::text('q', Input::old('q'), array('class'=>'form-control', 'placeholder'=>'Search Key')) }}</td>
            
        </tr>
        
        <tr>
            <td>
                                        <button type="submit" class="btn btn-success">Search</button><!-- 
                                        <input style="float:right;" type="submit" name="submit" value="Add User"> --></td>
                                    </tr>
                                    
                                </table>
                                {{ Form::close() }}
                            </td>
                            
                        </div>

                        @stop