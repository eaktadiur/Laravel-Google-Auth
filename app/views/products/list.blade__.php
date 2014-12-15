@extends('layout.admin-main')

@section('body-content')


<div class="panel-body">

  <h1> {{ $pname }} </h1>
  {{ Form::open(array('route' => array('get-product-search-result'), 'role'=>"form", 'method'=>'get')) }} 
  <table width="40%" border="0" cellpadding="3" cellspacing="1" bgcolor="#f1f1f1" style="padding:20px;" border="4" >
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

                                    <tr>
                                        <td>{{ HTML::linkRoute('get-product-details', $q, $q, array('class'=>'btn') ) }}</td>               
                                    </tr>

                                    <tr>
                                        <td><strong>Search:</strong> <a href="https://www.google.com/search?q={{ $q }}&safe=off&tbs=p_ord:p,vw:l&tbm=shop" target="blank">Google Purchase</a></td>               
                                    </tr>

                                </table>
                                <div class="table-responsive">
                                 <form action="stage-mage.php" method="post">
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" onclick="checkAll(this)"> 
                                                    <span style="font-size:12px;">Select All - </span>
                                                    <input type="submit" name="StageSubmit" value="Stage" /></th>
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
                                             <!-- @foreach ($data['matches'] as $product) -->
                                             @foreach ($data as $row)
                                             <!-- <?php $row = ProductMaster::getProduct($product->id);  ?> -->
                                             <tr>
                                                <td><INPUT TYPE="CHECKBOX" NAME="sku_{{ $skunum++ }}"   VALUE="{{ $ID }}" id="{{ $ID }}  "><span onclick="select(this);"></td>
                                                <td width='80'>{{$ser++ }}</td>
                                                <td>{{ $row->sku }}</td>
                                                <td>{{ $row->name.' '.$row->name }}</td>
                                                <td>{{ $row->sell_price }}</td>
                                                <td>{{ $row->qty }}</td>
                                                <td>{{ $row->date_added }}</td>
                                                <td><a href="http://www.motochanic.com/' . {{ $row->date_added }} . '" target=\"_blank\">Motochanic.com <img src="images/new-window-icon.png" /></a></td>
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
