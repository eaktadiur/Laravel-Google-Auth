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
            @foreach ($data['matches'] as $key => $sphinx_match)
            
            <?php
            $sku = $sphinx_match['attrs']['lookup_id'];

           $result = ProductMaster::getProduct($sku);
            
            foreach( $result as $row )
            {

                $Brand=$row['brand'];
                $ProdName=$row['name'];
                $SellPrice=$row['sell_price'];
                $Quantity=$row['qty'];
                $ID=$row['sku'];
                $date_added=$row['date_added'];
                if($date_added != '0000-00-00' and $date_added !=  '2014-02-10') {
                    $date_added=$row['date_added'];
                } else {
                    $date_added='Unknown';
                }
                if($row['url_key'] != ''){
                    $online=' <a href="http://www.motochanic.com/' . $row['url_key'] . '" target=\"_blank\">Motochanic.com <img src="/i/new-window-icon.png" /></a>';
                } else {
                    $online='';
                }; 
                ?>
                <tr>
                    <td><INPUT TYPE="CHECKBOX" NAME="sku_{{ $skunum++ }}"   VALUE="{{ $sphinx_match['attrs']['lookup_id'] }}" id="{{ $sphinx_match['attrs']['lookup_id'] }}  "><span onclick="select(this);"></td>
                    <td >{{$ser++ }}</td>
                    <td>{{ $sphinx_match['attrs']['lookup_id'] }}</td>
                    <td>{{ $sphinx_match['attrs']['name_sort'] }}</td>
                    <td>{{ $SellPrice }}</td>
                    <td>{{ $Quantity }}</td>
                    <td>{{ $date_added }}</td>
                    <td>{{ $online }}</td> 
                </tr>
                <?php } ?> 
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


<!-- <pre>
    <?php
   // print_r($data);
    ?>
</pre> -->
@stop
