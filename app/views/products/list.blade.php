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
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
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
                                           @foreach ($data['matches'] as $product)
                                           <?php $row = ProductMaster::getProduct($product->id);  ?>
                                           <tr>
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

                        @stop