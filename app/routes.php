<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', array('as' => 'home','uses' => 'HomeController@home'));	
Route::get('/login', array('as' => 'user-sign-in','uses' => 'UserController@getSignIn'));	
Route::get('gauth/{auth?}', array('as'=>'gmailAuth', 'uses'=>'UserController@getGmailLogin') );
/*
	* Authenticated group 
*/
	Route::group( array('before'=> 'auth' ), function(){

		Route::group(array('before'=> 'csrf'), function(){
			Route::post('/new', array('as' => 'user-cretae-post','uses' => 'UserController@postCreate'));
			Route::put('/update/{id}', array('as' => 'put-user-update','uses' => 'UserController@get_update'));
		});

		Route::get('/list', array('as' => 'user-list','uses' => 'UserController@getIndex'));
		Route::get('/new', array('as' => 'user-create','uses' => 'UserController@getCreate'));
		Route::get('/view/{id}', array('as' => 'user-get-edit','uses' => 'UserController@get_edit'));

		Route::get('/destroy/{id}', array('as' => 'delete-user-destroy','uses' => 'UserController@destroy'));
		Route::get('/sign-out', array('as' => 'user-sign-out','uses' => 'UserController@getSignOut'));
		Route::get('new/db/search', array('as'=>'get-product-search', 'uses'=>'ProductController@getProductSearch'));
		Route::get('new/db/search/results', array('as'=>'get-product-search-result', 'uses'=>'ProductController@getProductSearchResult'));
		Route::get('new/db/product/{id}', array('as'=>'get-product-details', 'uses'=>'ProductController@getProductDetails'));
		Route::post('/stage-manage', array('as'=>'stage-manage', 'uses'=>'ProductController@getProductStageManage'));
		Route::post('/stage-manage-save', array('as'=>'stage-manage-save', 'uses'=>'ProductController@postProductStageManage'));


	});

/*
	* Unauthenticated group 
*/

	Route::group( array('before'=> 'guest', 'prefix'=>'user' ), function(){
	/*
		* CSRF protection group
	*/
		Route::group(array('before'=> 'csrf'), function(){
			Route::post('/login', array('as' => 'user-sign-in-post','uses' => 'UserController@postSignIn'));
		});
	});



