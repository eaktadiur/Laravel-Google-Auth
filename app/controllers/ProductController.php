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
		$id = rand(1000, 7800);
		return View::make('products.list', array('q'=> $q, 'id'=>$id))
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