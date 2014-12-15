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
	
	public function getProductDetails($id)
	{
		return View::make('products.details', array('id'=>$id))
		->with('title', 'Product List')
		->with('pname', 'Product Details');
	}
	
}