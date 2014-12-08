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
Route::group( array('before'=> 'auth', 'prefix' => 'user' ), function(){
	
	Route::group(array('before'=> 'csrf'), function(){
		Route::post('/new', array('as' => 'user-cretae-post','uses' => 'UserController@postCreate'));
	});

	Route::get('/list', array('as' => 'user-list','uses' => 'UserController@getIndex'));
	Route::get('/new', array('as' => 'user-create','uses' => 'UserController@getCreate'));
	Route::get('/view/{id}', array('as' => 'user-get-edit','uses' => 'UserController@get_edit'));
	Route::put('/update/{id}', array('as' => 'put-user-update','uses' => 'UserController@get_update'));
	Route::get('/destroy/{id}', array('as' => 'delete-user-destroy','uses' => 'UserController@destroy'));
	Route::get('/sign-out', array('as' => 'user-sign-out','uses' => 'UserController@getSignOut'));
	
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



