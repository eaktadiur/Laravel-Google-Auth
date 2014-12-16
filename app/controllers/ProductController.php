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
	
	public function getProductSearchResult()
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
		$sphinx->setServer("localhost", 9312);
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


		// $data  = ProductMaster::products($q);
		return View::make('products.list', array('data'=> $sphinx_results, 'q'=>$q, 'ser'=>1 ))
		->with('title', 'Product List')
		->with('pname', 'Search Result');
	}
	
	
	public function getProductSearchResult_()
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
			// Delete current information in table
		$truncate_products_results = DB::table('magento_products_staging')->truncate();
		$truncate_cpsa_results = DB::table('magento_cpsa_staging')->truncate();
		$truncate_cpsi_results = DB::table('magento_cpsi_staging')->truncate();

		$product_name	= e(Input::get('product_name'));
			$name =  Input::get('product_name');	// check
			$brand	= e(Input::get('brand_id')); 	// check
			$gender	= e(Input::get('gender')); 	// check
			$product	= e(Input::get('product_type'));
			$product_type = $product; // check
			$product_kind	= e(Input::get('product_kind')); // check
			$material	= e(Input::get('material')); // check
			$preorder	= e(Input::get('preorder')); // check
			$parent_msrp_min = e(Input::get('msrp_price_low')); 
			$parent_msrp_max = e(Input::get('msrp_price_high')); 		// check
			$parent_sell_min = e(Input::get('sell_price_low')); 	// check
			$parent_sell_max = e(Input::get('sell_price_high'));
			$news_from_date	= "";
			$news_to_date	= ""; 

			$news_to_date	= "";
			// Pre-Orders
			if($preorder == "yes") {
				$use_config_backorders	= "No";
				$preorder_note	= e(Input::get('preorder_available')); 		// check
				$preorder_cart_label	= "PRE-ORDER";
			} else {
				$use_config_backorders	= "Yes";
				$preorder_note			= "";
				$preorder_cart_label	= "";
			}

			$skuset = Input::get('skuset');
			ksort($skuset);


			// Standard Pre-filled
			$status			= "Enabled";
			$product_status	= "Current";
			$attribute_set	= "01 - Riding Gear Template";
			$tax_class_id	= "WePayTheTax";
			$website		= "base";

			// Inventory
			$use_config_manage_stock	= "No";
			$manage_stock				= "Yes"; // track_inventory
			$is_in_stock				= "In Stock";

			// Reset Position for CPSA attributes
			$position = 0;

			// SKU SPECIFIC INFO FROM NOW ON

			// Loop through sku array
		foreach ($skuset as $skus) {
					/*---teporary set attributes*/
					//$attributes = $skus['attributes'];

					if(!array_key_exists('attributes', $skus))
					{

							$sku = $skus['sku'];
							$product_kind = $skus['product_kind'];
							if( !array_key_exists('color', $skus) || (!$color = $skus['color'] ) )  {
								$color = "";
							}
							if(!array_key_exists('size', $skus) || (!$size = $skus['size'] ) ) {
								$size = "";
							}
							if(!array_key_exists('length', $skus) || (!$length = $skus['length'] ) ) {
								$length = "";
							}
							if(!array_key_exists('lens', $skus) || (!$lens = $skus['lens'] ) ) {
								$lens = "";
							}
							if(!array_key_exists('plates', $skus) || (!$plates = $skus['plates'] ) ) {
								$plates = "";
							}
							if(!array_key_exists('side', $skus) || (!$side = $skus['side'] ) ) {
								$side = "";
							}
							if(!array_key_exists('type', $skus) || (!$type = $skus['type'] ) ) {
								$type = "";
							}

							switch ($product_kind) 
							{
								case 'parent':
									$product_type				= "configurable";
									$visibility					= "Catalog, Search";
									$name						= $product_name;
									$sku						= ucwords(strtoupper($name));
									$set_parent					= $sku;
									$msrp						= $parent_msrp_min;
									$price						= $parent_sell_min;
									$configurable_parent_sku	= "";
									$amconf_simple_price		= "";
									// Build Meta Description
									if($price >= 75) {
										$meta_description = "Purchase your ".$product_name." and get Free Shipping from Motochanic, home of ".$brand.".";
									} else {
										$meta_description = "Purchase your ".$product_name." from Motochanic, home of ".$brand.".";
									}
								break;
								case 'child':
									$product_type				= "simple";
									$visibility					= "Not Visible Individually";
									$name						= $product_name." - ".$color." ".$size." ".$length." ".$lens." ".$plates." ".$side." ".$type;
									$name						= trim(preg_replace('!\s+!', ' ', $name));
									$configurable_parent_sku	= $set_parent;
									$amconf_simple_price		= "";
									$meta_description			= ""; // Clear meta-description for child products
									$price_array				= ""; // Build price array to track price ranges
								break;
								case 'stand_alone':
									$product_type				= "simple";
									$visibility					= "Catalog, Search";
									$name						= $product_name;
									$configurable_parent_sku	= "";
									$amconf_simple_price		= "";
								break;
							}

							if($product_kind != "parent")
							{
								$lookup_results = DB::select(" select * from product_master where sku = '$sku' ");
								$lookup_results = json_decode(json_encode($lookup_results),TRUE); 

								foreach($lookup_results as $row)
								{

									$alt_pn	= $row['alt_pn'];
									$upc	= $row['upc'];
									$qty						= $row['qty'];
									$shipping_time				= "";	
									// Pricing
									$msrp						= floor($row['msrp']* 100)/100;
									$price						= floor($row['msrp']* 100)/100;
									$special_price =($row['sell_price'] == $msrp) ? "": floor($row['sell_price']* 100)/100;

									$price_view					= "";
								}
							}
							else
							{
								$alt_pn	= '';
								$upc	= '';
								$qty	= '';
								$shipping_time	= "";	
									// Pricing
								$msrp   = "";
								$price	= '';
								$special_price ='';

								$price_view	= "";
							}


								// Product Details
								$short_description	= $name;
								$description		= $name;
								$weight				= "";
							DB::table('magento_products_staging')->insert(
							array( 	'type' => $product_type, 
								'visibility' => $visibility,
								'status' => $status,
								'sku' => $sku,
								'altsku' => $alt_pn,
								'upc' => $upc,
								'brand' => $brand,
								'name' => $name,
								'gender' => $gender,
								'product' => $product,
								'material' => $material,
								'product_status' => $product_status,
								'shipping_time' => $shipping_time,
								'msrp' => $msrp,
								'price' => $price,
								'price_view' => $price_view,
								'amconf_simple_price' => $amconf_simple_price,
								'short_description' => $short_description,
								'description' => $description,
								'meta_description' => $meta_description,
								'color' => $color,
								'size' => $size,
								'length' => $length,
								'lens' => $lens,
								'plates' => $plates,
								'side' => $side,
								'type' => $type,
								'weight' => $weight,
								'tax_class_id' => $tax_class_id,
								'news_from_date' => $news_from_date,
								'news_to_date' => $news_to_date,
								'preorder_note' => $preorder_note,
								'preorder_cart_label' => $preorder_cart_label));
					}
					elseif( array_key_exists('attributes', $skus) ) // End loop through sku array
					{
							$attributes = str_getcsv($skus['attributes']);							
					}

					 ($product_kind == "child") ? ProductMaster::createCPSI($sku, $configurable_parent_sku) : '';
			}


	//please see this method fix the problem
			is_array($attributes) ? ProductMaster::createCPSA($attributes) : '';	

			return Redirect::route('home')->with('message', 'Product Saved Successfully!')->with('message_type', 'success');
		}



		public function getProductDetails($id)
		{
			return View::make('products.details', array('id'=>$id))
			->with('title', 'Product List')
			->with('pname', 'Product Details');
		}

	} 