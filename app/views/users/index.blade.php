@extends('layout.admin-main')

@section('body-content')


<!-- <p>{{ ($message) ? $message : ''; }}</p> -->
<!-- /.panel-heading -->
<div class="row">
  {{ HTML::linkRoute('user-create', 'New User', '', array('class'=> 'btn btn-primary') ) }}
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>Ser.</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
           @foreach ($data as $user)

           <tr>
            <td width='80'>{{$ser++ }}</td>
            <td>{{ $user->username }}</td>
            <td class="center">{{ $user->email }}</td>
            <td class="center" width='150'>
                <a href="{{ URL::route('delete-user-destroy',  array($user->id)) }}"><i class='glyphicon glyphicon-trash'></i> Delete</a> |
                <a href="{{ URL::route('user-get-edit',  array($user->id)) }}"><i class='glyphicon glyphicon-edit'></i> Edit</a> 
            </td>
        </tr>
        @endforeach


    </tbody>
</table>
</div>
<!-- /.table-responsive -->

</div>


@stop
