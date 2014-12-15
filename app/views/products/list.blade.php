@extends('layout.admin-main')

@section('body-content')


<div class="panel-body">

 <h1 class="text-center"> {{ $pname }} </h1>
 <div class="table-responsive">
   <form action="{{ URL::route('stage-manage') }}" method="post">
       <input type="submit" class="btn btn-primary" name="StageSubmit" value="Stage" />
       <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
            <th><input type="checkbox" onclick="checkAll(this)"></th>
                <th>Ser.</th>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty Available</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
            <?php $skunum = 1; ?>
            @foreach ($data as $row)
            <?php $ID = $row->sku; ?>
            <tr>
                <td><INPUT TYPE="CHECKBOX" NAME="sku_{{ $skunum++ }}"   VALUE="{{ $row->sku }}" id="{{ $ID }}  "><span onclick="select(this);"></td>
                <td >{{$ser++ }}</td>
                <td>{{ $row->sku }}</td>
                <td>{{ $row->name.' '.$row->brand }}</td>
                <td>{{ $row->sell_price }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ $row->date_added }}</td>
                <td><a href="http://www.motochanic.com/' . {{ $row->date_added }} . '" target=\"_blank\">Motochanic.com <img src="{{ asset('images/new-window-icon.png')}}" /></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.table-responsive -->
</div>
<script type="text/javascript">
    function select(elem) {
        var sel = window.getSelection();
        var range = sel.getRangeAt(0);
        range.selectNode(elem);
        sel.addRange(range);
    }
    function checkAll(bx) {
        var cbs = document.getElementsByTagName('input');
        for(var i=0; i < cbs.length; i++) {
            if(cbs[i].type == 'checkbox') {
                cbs[i].checked = bx.checked;
            }
        }
    }
</script>
@stop
