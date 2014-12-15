<?php

class ProductController extends \BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	// private $user;

	// function __construct($user){
	// 	$this->user = $user; 
	// }

	public function getProductSearch()
	{
		return View::make('products.index')
		->with('title', 'Product List')
		->with('pname', 'Search Product');
	}
	
	public function getProductSearchResult_()
	{
		$q = Input::get('q');
		
		if(isset($_GET['p'])){
			$p = strip_tags($_GET['p']);
			settype($p, "integer");
			if($p > 0) {
				$offset	= ($p-1) * 1000;
			} else {
				$offset = 0;
			}
			$limit	= 1000;
			$max	= 1000;
		} else {
			$offset	= 0;
			$limit	= 1000;
			$max	= 1000;
		}

		$sphinx = new SphinxClient;
		$sphinx->setServer("localhost", 8000);
		#$sphinx->setMatchMode(SPH_MATCH_ALL);
		#$sphinx->SetRankingMode(SPH04);
		$sphinx->SetLimits($offset, $limit, max($max, ($offset+$limit)));
		$sphinx->setMaxQueryTime(3);

		if(isset($_GET['sort'])){
			$sort = strip_tags($_GET['sort']);
			switch ($sort) {
				case 'date_desc':
				$sphinx->SetSortMode(SPH_SORT_ATTR_DESC,'date_added');
				break;
				case 'date_asc':
				$sphinx->SetSortMode(SPH_SORT_ATTR_ASC,'date_added');
				break;
				case 'name_asc':
				$sphinx->SetSortMode(SPH_SORT_ATTR_ASC,'name_sort');	
				break;
			}

		}

		$sphinx_results		= $sphinx->query($q);
		$total_results		= $sphinx_results["total_found"];
		$sphinx_time		= $sphinx_results["time"];


		// echo "<pre>";

		// print_r($sphinx_results);

		// die();




		// $data  = ProductMaster::products($q);
		return View::make('products.list', array('data'=> $sphinx_results, 'q'=>$q, 'ser'=>1 ))
		->with('title', 'Product List')
		->with('pname', 'Search Result');
	}
	
	
	public function getProductSearchResult()
	{
		$q = Input::get('q');		
		$data  = ProductMaster::products($q);
		return View::make('products.list', array('data'=> $data, 'q'=>$q, 'ser'=>1 ))
		->with('title', 'Product List')
		->with('pname', 'Search Result');
	}
	
	public function getProductStageManage()
	{
		$data = Input::all();
		return View::make('products.stage-mage', array('post'=> $data))
		->with('title', 'Product Add')
		->with('pname', 'Add a Product');
	}

	public function postProductStageManage()
	{
	// 		// Delete current information in table
	// 		$truncate_products_results = DB::table('magento_products_staging')->truncate();
	// 		$truncate_cpsa_results = DB::table('magento_cpsa_staging')->truncate();
	// 		$truncate_cpsi_results = DB::table('magento_cpsi_staging')->truncate();

	// 		$product_name	= e(Input::get('product_name')); 	// check
	// 		$brand_id	= e(Input::get('brand_id')); 	// check
	// 		$gender	= e(Input::get('gender')); 	// check
	// 		$product_type	= e(Input::get('product_type')); // check
	// 		$product_kind	= e(Input::get('product_kind')); // check
	// 		$material	= e(Input::get('material')); // check
	// 		$preorder	= e(Input::get('preorder')); // check
	// 		$msrp_price_low	= e(Input::get('msrp_price_low')); // check
	// 		$msrp_price_high	= e(Input::get('msrp_price_high')); // check
	// 		$sell_price_low	= e(Input::get('sell_price_low')); // check
	// 		$sell_price_high	= e(Input::get('sell_price_high')); // check

	// 		$news_to_date	= "";
	// 		// Pre-Orders
	// 		if($preorder == "yes") {
	// 			$use_config_backorders	= "No";
	// 			$preorder_note	= e(Input::get('preorder_available')); 		// check
	// 			$preorder_cart_label	= "PRE-ORDER";
	// 		} else {
	// 			$use_config_backorders	= "Yes";
	// 			$preorder_note			= "";
	// 			$preorder_cart_label	= "";
	// 		}

	// 		$skuset = Input::get('skuset');
	// 		ksort($skuset);


	// 		// Standard Pre-filled
	// 		$status			= "Enabled";
	// 		$product_status	= "Current";
	// 		$attribute_set	= "01 - Riding Gear Template";
	// 		$tax_class_id	= "WePayTheTax";
	// 		$website		= "base";

	// 		// Inventory
	// 		$use_config_manage_stock	= "No";
	// 		$manage_stock				= "Yes"; // track_inventory
	// 		$is_in_stock				= "In Stock";

	// 		// Reset Position for CPSA attributes
	// 		$position = 0;

	// 		// SKU SPECIFIC INFO FROM NOW ON

	// 		// Loop through sku array
	// 		if(count($skuset) > 0)
	// 		{
	// 			foreach ($skuset as $skus) {

	// 					# Do not process Attributes
	// 					/*Temporary manual assign values*/
	// 					$skus['color'] = 'green';
	// 					$skus['size'] = '123';
	// 					$skus['length'] = '9999';//side
	// 					$skus['lens'] = '9999';//skus
	// 					$skus['plates'] = '9999';//skus
	// 					$skus['side'] = '9999';//skus
	// 					$skus['type'] = '9999';//skus
	// 					/*--end manual assign-------*/
	// 					if(!array_key_exists('attributes', $skus)){

	// 							$sku = $skus['sku'];
	// 							$product_kind = $skus['product_kind'];
	// 							if(!$color = $skus['color']) {
	// 								$color = "";
	// 							}
	// 							if(!$size = $skus['size']) {
	// 								$size = "";
	// 							}
	// 							if(!$length = $skus['length']) {
	// 								$length = "";
	// 							}
	// 							if(!$lens = $skus['lens']) {
	// 								$lens = "";
	// 							}
	// 							if(!$plates = $skus['plates']) {
	// 								$plates = "";
	// 							}
	// 							if(!$side = $skus['side']) {
	// 								$side = "";
	// 							}
	// 							if(!$type = $skus['type']) {
	// 								$type = "";
	// 							}

	// 							switch ($product_kind) {
	// 								case 'parent':
	// 								$product_type				= "configurable";
	// 								$visibility					= "Catalog, Search";
	// 								$name						= $product_name;
	// 								$sku						= ucwords(strtoupper($name));
	// 								$set_parent					= $sku;
	// 								$msrp						= $parent_msrp_min;
	// 								$price						= $parent_sell_min;
	// 								$configurable_parent_sku	= "";
	// 								$amconf_simple_price		= "";
	// 								// Build Meta Description
	// 								if($price >= 75) {
	// 									$meta_description = "Purchase your ".$product_name." and get Free Shipping from Motochanic, home of ".$brand.".";
	// 								} else {
	// 									$meta_description = "Purchase your ".$product_name." from Motochanic, home of ".$brand.".";
	// 								}
	// 								break;
	// 								case 'child':
	// 								$product_type				= "simple";
	// 								$visibility					= "Not Visible Individually";
	// 								$name						= $product_name." - ".$color." ".$size." ".$length." ".$lens." ".$plates." ".$side." ".$type;
	// 								$name						= trim(preg_replace('!\s+!', ' ', $name));
	// 								$configurable_parent_sku	= $set_parent;
	// 								$amconf_simple_price		= "";
	// 								$meta_description			= ""; // Clear meta-description for child products
	// 								$price_array				= ""; // Build price array to track price ranges
	// 								break;
	// 								case 'stand_alone':
	// 								$product_type				= "simple";
	// 								$visibility					= "Catalog, Search";
	// 								$name						= $product_name;
	// 								$configurable_parent_sku	= "";
	// 								$amconf_simple_price		= "";
	// 								break;
	// 							}

	// 							if($product_kind != "parent") {
	// 								$lookup_results = DB::select(" select * from product_master where sku = '$sku' ");
	// 								$lookup_results = json_decode(json_encode($lookup_results),TRUE); 
									
	// 								/*manual assign values*/
	// 								$alt_pn = '8900';
									
	// 								if(count($lookup_results) > 0)
	// 									{
	// 										foreach($lookup_results as $row){
											
											
	// 										//$alt_pn	= $row['alt_pn'];
											

	// 										$upc	= $row['upc'];

	// 										$qty						= $row['qty'];
	// 										$shipping_time				= "";	
	// 										// Pricing
	// 										$msrp						= floor($row['msrp']* 100)/100;
	// 										$price						= floor($row['msrp']* 100)/100;
	// 										$special_price =($row['sell_price'] == $msrp) ? "": floor($row['sell_price']* 100)/100;
												
	// 										$price_view					= "";
	// 										}
	// 									}
	// 							}

	// 						} # while lookup results

						

	// 						// Product Details
	// 						$short_description	= $name;
	// 						$description		= $name;
	// 						$weight				= "";

	// 						$product_query = "INSERT magento_products_staging (
	// 							`product.type`,	`visibility`, `status`,	`product.configurable_parent_sku`, `sku`,
	// 							`altsku`,`upc`,	`brand`,`name`,	`gender`,`product`,	`material`,	`product_status`,
	// 							`shipping_time`,`stock.use_config_manage_stock`,`stock.manage_stock`,`stock.qty`,
	// 							`stock.is_in_stock`,`msrp`,	`price`,`price_view`,`special_price`,`amconf_simple_price`,
	// 							`short_description`,`description`,`meta_description`,`color`,`size`,`length`,`lens`,
	// 							`plates`,`side`,`type`,	`weight`,`product.attribute_set`,`tax_class_id`,`product.websites`,
	// 							`news_from_date`,`news_to_date`,`stock.use_config_backorders`,`preorder_note`,`preorder_cart_label`
	// 							)

	// 						SELECT
	// 						'$product_type','$visibility','$status','$configurable_parent_sku', '$sku','$alt_pn',
	// 						'$upc',	'$brand','$name','$gender','$product','$material','$product_status','$shipping_time',
	// 						'$use_config_manage_stock','$manage_stock','$qty','$is_in_stock','$msrp','$price','$price_view',
	// 						'$special_price','$amconf_simple_price','$short_description','$description','$meta_description',
	// 						'$color','$size','$length','$lens','$plates','$side','$type','$weight','$attribute_set',
	// 						'$tax_class_id','$website','$news_from_date','$news_to_date','$use_config_backorders',
	// 						'$preorder_note','$preorder_cart_label';";
	// 						DB::query($product_query);

	// 					($product_kind == "child") ? User::createCPSI($sku, $configurable_parent_sku) : '';	

	// 			} // End loop through sku array
	// 		}


	
	// is_array($attributes) ? User::createCPSA($attributes) : '';	
	
	return Redirect::route('home')->with('message', 'Product Saved Successfully!')->with('message_type', 'success');
}
	


public function getProductDetails($id)
{
	return View::make('products.details', array('id'=>$id))
	->with('title', 'Product List')
	->with('pname', 'Product Details');
}

}