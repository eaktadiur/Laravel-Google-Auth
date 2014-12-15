@extends('layout.admin-main')

@section('body-content')


<div class="panel-body">

	<ul>
		echo"<h1>" . $prodname ."</h1>";
		echo"<li>SKU: <strong onclick=\"select(this);\">" . htmlspecialchars($sku, ENT_QUOTES, 'UTF-8') ."</strong></li>\n";
		if ($altpn != '') {
		echo"<li>Alt SKU: <strong onclick=\"select(this);\">" . $altpn ."</strong></li>\n";
	};
	if ($upc != '0') {
	if (strlen($upc) == '12') {
	echo "<li>UPC: <strong onclick=\"select(this);\">" . $upc ."</strong></li>\n";
} else {
if (strlen($upc) == '13') {
echo "<li>EAN: <strong onclick=\"select(this);\">" . $upc ."</strong></li>\n";
} else {
echo "<li>UPC/EAN: <strong onclick=\"select(this);\">" . $upc ."</strong></li>\n";
};					
};
};

# Inventory Section
if ($row['total_inventory'] != '') {
$mi_date = strtotime($row['mi_date']);
echo "<p>";
echo '<li class="green" style="font-weight:bold;text-decoration:underline;">Available in store: ' . $row['total_inventory'] . '</li> <li><strong>Updated:</strong> ' . date("M j, Y g:i A", $mi_date) . '</li>';
echo "</p>";
};
if ($row['track_inventory'] == 'Y'){
$time_stamp = strtotime($row['time_stamp']);
echo "<p>";
if ($qty == '0') {
echo '<li><strong style="color:red;">OUT OF STOCK</strong>';
if ($row['date_available'] != '0000-00-00') {
echo ' - Est. Availability:<strong class="green"> ' . $row['date_available'] . '</strong></li>';
} else {
echo '</li>';
};
} else {
echo'<li class="green"><strong>AVAILABLE</strong></li>';
if($shipping_time != ''){
if($supplier == 'partsunlimited' or $supplier = 'rsd' or $supplier = 'schuberth' or $supplier = 'fox') {
echo'<li><strong>Arrives from supplier <span class="green">within ' . $shipping_time . '</span></strong></li>';
}
}
};
echo"<li><strong>Inventory Tracking:</strong> <span class=\"green\" style='font-weight:bold;'>YES</span></li>\n";
echo"<li><strong>Available Quantity:</strong> " . $qty . "</li>\n";
echo"<li><strong>Inventory Updated:</strong> " . date("M j, Y g:i A", $time_stamp) . "</li>\n";
echo "</p>";
} else {
echo "<p>";
echo"<li><strong>Inventory Tracking:</strong> <span style='color:red;font-weight:bold;'>NO</span></li>\n";
echo "</p>";
};

echo "<p>";
if ($status != '') {
if($status == 'current') {
echo"<li><strong>Status:</strong> <strong class=\"green\">" . strtoupper($status) . "</strong></li>\n";
} else {
echo"<li><strong>Status:</strong> <strong class=\"red\">" . strtoupper($status) . "</strong></li>\n";
}
}
if ($mapp != '') { 
if($mapp == 'Y') {
echo"<li><strong>MAPP Status:</strong> <strong class=\"green\">Price Protected</strong></li>\n";
} else {
echo"<li><strong>MAPP Status:</strong> <strong class=\"red\">Out of MAPP</strong></li>\n";
}
}
echo"<li><strong>MSRP:</strong> $<span onclick=\"select(this);\">" . ($msrp*100)/100 . "</span></li>\n";
echo"<li><strong>Sell Price: <span class=\"green\">$</span><span class=\"green\" onclick=\"select(this);\">" . ($sellprice*100)/100 . "</span></strong></li>\n";
echo "</p>";

# Supplier Section
echo"<li><strong>Supplier:</strong> " . $row['supplier'] . "</li>\n";
echo"<li><strong>Brand:</strong> " . $brand . "</li>\n";
if ($date_added != '0000-00-00') { 
echo"<li><strong>Date Added:</strong> " . $date_added . "</li>\n";
}
echo'<li><strong>Search:</strong> <a href="https://www.google.com/search?q=' . $brand . '+' . $sku .	'&safe=off&tbs=p_ord:p,vw:l&tbm=shop" target="blank">Google Shopping  <img src="/i/new-window-icon.png" /></a></li>';
if ($row['b2b'] != ''){
if($row['supplier'] == 'partsunlimited') {
include("inc-b2b-form-partsnetweb.php");
} elseif($row['supplier'] == 'tuckerrocky') {
include("inc-b2b-form-trdealer.php");
} elseif($row['supplier'] == 'd2m') {
include("inc-b2b-form-d2m.php");
} elseif($row['supplier'] == 'wps') {
include("inc-b2b-form-wps.php");
} else {
echo'<li><strong>Check B2B:</strong> <a href="' . $row['b2b'] . '" target="blank">' . $row['b2b'] . ' <img src="/i/new-window-icon.png" /></a></li>';
echo'<li>Call ' . $row['supplier'] . ' for more information: <a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a></li>';
};
} else {
echo '<li>Call ' . $row['supplier'] . ' for more information: <a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a></li>';
};

# Motochanic.com Section
if ($row['product_url'] !=''){
echo'<p>';
echo'<li><strong>Motochanic.com:</strong> <a href="' . $row['product_url'] . '" target="blank">' . $row['product_url'] . '  <img src="/i/new-window-icon.png" /></a></li>';
echo'<li><strong>BigCommerce:</strong> <a href="https://www.motochanic.com/admin/index.php?ToDo=editProduct&productId=' . $row['product_id'] . '" target="blank">Edit Product  <img src="/i/new-window-icon.png" /></a></li>';
if ($row['inventory_tracking'] == 'none'){
echo"<li><strong>Online Inventory: <span style=\"color:red;\">DISABLED</span></strong></li>\n";
};
if ($row['preorder'] == 'Y'){
echo"<li><strong>Pre-Order: <span style=\"color:red;\">YES</span></strong></li>\n";
} else {
echo"<li><strong>Pre-Order: </strong><span>No</span></li>\n";
};
echo"<li><strong>MSRP:</strong> $<span onclick=\"select(this);\">" . $row['bc_msrp'] . "</span></li>\n";
echo"<li><strong>Price:</strong> $<span onclick=\"select(this);\">" . $row['bc_price'] . "</span></li>\n";
if ($row['bc_sp'] != '0.00'){
echo"<li><strong>Sale Price:</strong> $<span onclick=\"select(this);\">" . $row['bc_sp'] . "</span></li>\n";
};
echo'</p>';
} else {
echo'<p>';
echo "<li><strong>This product is not available on Motochanic.com</strong></li><br/>";
echo'</p>';
};
</ul>

</div>

@stop