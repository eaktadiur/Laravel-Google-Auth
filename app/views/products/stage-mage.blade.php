@extends('layout.admin-main')

@section('body-content')


<div class="panel-body">

	<?php

	if(isset($post['StageSubmit'])){
		echo "<h1>Add a Product</h1>";
		echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">Go Back</a>';
		?>
		<form action="{{ URL::route('stage-manage-save') }}" method="post">
			<?php
			$brand_result = DB::select("SELECT `brand` FROM `product_master` where brand != '' and brand not regexp '^[0-9 (]+' GROUP BY `brand` ORDER BY `brand`");

				
			//$brand_result = mysqli_query($brand_query) or die('<p>Error, query failed</p>');

				echo '<table border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td><input type="checkbox" name="boot_sizes_us" /> Show US Boot Sizes</td>
					<td><input type="checkbox" name="youth_boot_sizes_us" /> Show US Youth Boot Sizes</td>
					<td><input type="checkbox" name="one_through_twenty" /> Show 1 - 20 Sizes</td></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="standard_sizes" /> Show 2XS-4XL Sizes</td>
					<td><input type="checkbox" name="eu_sizes" /> Show EU Sizes 44-64</td>
					<td><input type="checkbox" name="boot_sizes" /> Show EU Boot Sizes</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="youth_boot_sizes" /> Show EU Youth Boot Sizes</td>
					<td><input type="checkbox" name="us_pant_sizes" /> Show US Pant Sizes 28-44</td>
					<td>&nbsp;</td>
				</tr>
			</table><br />';

			echo '<table border="0" cellspacing="0" cellpadding="4" style="border: #ccc;border-style: solid;border-width: 2px;">';
			$i	= 1;
			$ii	= 1;
	#print_r($_POST);
	$sku_count = count($post); // Determine configurable or simple product

	foreach ($post as $sku){

	if ( $sku != 'Stage' ){    // Only parse X variables
		$sku_result = DB::select("SELECT * FROM product_master WHERE sku = ?", array($sku));
		$sku_result = json_decode(json_encode($sku_result),TRUE); 
		$c = '';
		$i = 1;
		foreach($sku_result as $row ){
			$brand			= $row['brand'];
			$brand_id[]		= $row['brand'];
			$brands[]		= $row['brand'];
			$supplier		= $row['supplier'];
			$prod_name		= $row['name'];
			$qty			= $row['qty'];

			$msrp			= $row['msrp'];
			$sell_price		= $row['sell_price'];
			$sale_price		= $row['sale_price'];

			$msrp_range[]	= $row['msrp'];
			$sell_range[]	= $row['sell_price'];
			$sale_range[]	= $row['sale_price'];

			$color = $row['color'];
			echo "<tr " . (($c = !$c)?' class="odd"':' class="even"') . ">";
			echo '<input type="hidden" name="skuset['. $i .'][sku]" value="' . ucwords(strtoupper($sku)) . '" />';
			echo '<input type="hidden" name="skuset['. $i .'][product_kind]" value="child" />';
			echo "<td>" . $sku . "</td><td>" . $prod_name . "</td><td>MSRP: $" . ($msrp*100)/100 . "</td><td>Sell Price: $" . ($sell_price*100)/100 . "</td><td>" . "<label>Color: <input type=\"text\" name=\"skuset[" . $i . "][color]\" value=\"".$color."\"/></label></td>

			<!-- Standard Sizes -->
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"XX-Small\" />2XS</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"X-Small\" />XS</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"Small\" />SM</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"Medium\" />MD</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"Large\" />LG</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"X-Large\" />XL</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"XX-Large\" />XXL</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"3X-Large\" />3XL</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"4X-Large\" />4XL</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"Medium/Small\" />M/S</td>
			<td class=\"standard_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"Medium/Large\" />M/L</td>

			<!-- Youth Boot Sizes EU -->
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"31\" />31</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"32\" />32</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"33\" />33</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"34\" />34</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"35\" />35</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"36\" />36</td>
			<td class=\"youth_boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"37\" />37</td>

			<!-- Youth Boot Sizes US -->
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"3.5\" />3.5</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"4\" />4.0</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"4.5\" />4.5</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"5\" />5.0</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"5.5\" />5.5</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"6\" />6.0</td>
			<td class=\"youth_boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"6.5\" />6.5</td>

			<!-- Adult Boot Sizes EU -->
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"38\" />38</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"39\" />39</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"40\" />40</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"41\" />41</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"42\" />42</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"43\" />43</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"44\" />44</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"45\" />45</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"46\" />46</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"47\" />47</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"48\" />48</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"49\" />49</td>
			<td class=\"boot_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"50\" />50</td>

			<!-- Adult Boot Sizes US -->
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"7\" />7.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"7.5\" />7.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"8\" />8.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"8.5\" />8.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"9\" />9.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"9.5\" />9.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"10\" />10.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"10.5\" />10.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"11\" />11.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"11.5\" />11.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"12\" />12.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"12.5\" />12.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"13\" />13.0</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"13.5\" />13.5</td>
			<td class=\"boot_sizes_us\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"14\" />14.0</td>

			<!-- EU Sizes 44-64 -->
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"44\" />44</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"46\" />46</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"48\" />48</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"50\" />50</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"52\" />52</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"54\" />54</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"56\" />56</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"58\" />58</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"60\" />60</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"62\" />62</td>
			<td class=\"eu_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"64\" />64</td>

			<!-- US Pant Sizes 28-44 -->
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"28\" />28</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"30\" />30</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"32\" />32</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"34\" />34</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"36\" />36</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"38\" />38</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"40\" />40</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"42\" />42</td>
			<td class=\"us_pant_sizes\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"44\" />44</td>

			<!-- Size 1 through 20 -->
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"1\" />1</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"2\" />2</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"3\" />3</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"4\" />4</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"5\" />5</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"6\" />6</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"7\" />7</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"8\" />8</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"9\" />9</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"10\" />10</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"11\" />11</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"12\" />12</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"13\" />13</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"14\" />14</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"15\" />15</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"16\" />16</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"17\" />17</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"18\" />18</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"19\" />19</td>
			<td class=\"one_through_twenty\" ><input type=\"radio\" name=\"skuset[" . $i . "][size]\" value=\"20\" />20



				<input type=\"hidden\" name=\"variations[" . $i . "][sku]\" value=\"" . $sku . "\" />
				<input type=\"hidden\" name=\"variations[" . $i . "][qty]\" value=\"" . $qty . "\" />
				<input type=\"hidden\" name=\"sell_prices[" . $i . "]\" value=\"" . $sell_price . "\" />
				<input type=\"hidden\" name=\"msrps[" . $i . "]\" value=\"" . $msrp . "\" />
				<input type=\"hidden\" name=\"sale_prices[" . $i . "]\" value=\"" . $sale_price . "\" />
				<input type=\"hidden\" name=\"brand\" value=\"" . $brand . "\" />
				<input type=\"hidden\" name=\"supplier\" value=\"" . $supplier . "\" />
			</td>";
			echo '</tr>';
			$i++;
		};
	};
};
echo '</table><br />';

echo 'Select Gender: <input type="radio" name="gender" value="Men\'s" checked />Men\'s <input type="radio" name="gender" value="Women\'s" />Women\'s <input type="radio" name="gender" value="Kids" />Kids <input type="radio" name="gender" value="Girl\'s" />Girl\'s <input type="radio" name="gender" value="" />N/A (Parts and Electronics)';
$brand_array = array_unique($brands);
$brand_id_array = array_unique($brand_id);
$msrp_price_low = min($msrp_range);
$msrp_price_high = max($msrp_range);
$sell_price_low = min($sell_range);
$sell_price_high = max($sell_range);
$sale_price_low = min($sale_range);
$sale_price_high = max($sale_range);
$brand = $brand_array[0];
$current_brand_id = $brand_id_array[0];

echo "<p>Select Brand: ";
echo "<select name='brand_id'>";	
$brand_result = json_decode(json_encode($brand_result), TRUE);	
foreach($brand_result as$row){
	$brand_name = $row['brand'];
	$brand_id = $row['brand'];
	if($current_brand_id == $brand_id) {
		echo "<option selected='selected' value='" . $brand_id . "'>" . $brand_name . "</option>";
	} else {
		echo "<option value='" . $brand_id . "'>" . $brand_name . "</option>";
	};
}
echo "</select></p>";
echo '<p>Product Name: <input type="text" size="60" name="product_name" value="' . $brand . ' ' . ucwords(strtolower($prod_name)) . '"></p>';
echo '<input type="hidden" name="skuset[0][sku]" value="' . ucwords(strtoupper($prod_name)) . '" />';
echo '<input type="hidden" name="skuset['.$i.'][attributes]" value="color,size" />';
echo '<input type="hidden" name="msrp_price_low" value="'.$msrp_price_low.'" />';
echo '<input type="hidden" name="msrp_price_high" value="'.$msrp_price_high.'" />';
echo '<input type="hidden" name="sell_price_low" value="'.$sell_price_low.'" />';
echo '<input type="hidden" name="sell_price_high" value="'.$sell_price_high.'" />';
echo '<input type="hidden" name="sale_price_low" value="'.$sale_price_low.'" />';
echo '<input type="hidden" name="sale_price_high" value="'.$sale_price_high.'" />';
echo '<p>Product Type: <input type="text" size="60" name="product_type" value="Helmet"></p>';
echo "<p>Material: <select name='material'>
<option selected='selected' value=''>Not Applicable</option>
<option value='Textile'>Textile</option>
<option value='Leather'>Leather</option>
<option value='Mesh'>Mesh</option>
</select></p>
";
echo '<input type="radio" name="skuset[0][product_kind]" value="parent" '.( ($sku_count > 2) ? "checked" : "" ).'/>Configurable
<input type="radio" name="skuset[0][product_kind]" value="stand_alone" '.( ($sku_count == 2) ? "checked" : "" ).'/>Stand Alone (Simple)
<p>
	<table>
		<tr>
			<td><input type="checkbox" name="preorder" value="yes">Is Pre-Order </td>
			<td class="preorder" > Pre-Order Message: <input type="text" size="60" name="preorder_available" value="Expected to ship ..."></td>
		</tr>
	</table>
</p>';



echo '<p><input type="submit" name="StageSubmit" value="Continue" /></p>';
} else {
	echo "<p>Sorry, try again!</p>";
	echo '<a href="search.php">Try again</a>';
};

?>
@stop

