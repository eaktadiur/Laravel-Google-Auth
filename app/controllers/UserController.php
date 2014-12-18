<?php

class UserController extends \BaseController {

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

	public function getIndex()
	{
		$data = User::all();
		//$message = ($message) ? $message : 'N/A';
		return View::make('users.index', array('data'=>$data, 'message'=>'Hello') )
		->with('title', 'User List')
		->with('ser', 1);
	}

	public function getCreate()
	{
		return View::make('users.add')
		->with('title', 'New User');
	}

	public function postCreate()
	{

		$validation = User::validate(Input::all() );
		if($validation->fails())
		{
			return Redirect::route('user-create')
			->withErrors($validation)			
			->withInput();
		}
		else
		{
			$email            = Input::get('email');
			$username         = Input::get('username');
			$password         = Input::get('password');
			$code         	  = str_random(60);
			$active       	  = 0;					

			$user             = new User;
			$user->email      = $email;
			$user->username   = $username;
			$user->password   = crypt(md5($password), '$6$rounds=500000$' . substr(md5(md5($username)), 0, 16) . '$');
			//$user->password   = Hash::make($password);
			$user->code       = $code;
			$user->active     = $active;
			$user->save();
		}

			return Redirect::route('user-list')->with('message', 'New User created Successfully!')->with('message_type', 'success');		
	}
	 public function destroy($id)
	 {
	 	User::find($id)->delete();
	 	return Redirect::route('user-list')
	 	->with('message', 'User Deleted Successfully')
	 	->with('message_type', 'delete');

	 }
	
	public function get_edit($id)
	{
		$user = User::find($id);
		return View::make('users.edit', array('user'=> $user));

	}

	public function get_update($id)
	{
		

		    $user = User::find($id);
            $user->username   = Input::get('username');
            $user->email      = Input::get('email');
            $user->save();
            return Redirect::route('user-list');
	} 
	

	public function getSignIn(){
		return View::make('log-in');
	}

	/*
		* this is the code for Gmail login
	*/
	public function getGmailLogin( $auth=NULL ){

		if($auth =='auth'){
			
			try	{
				Hybrid_Endpoint::process();
			}catch(exception $e){
				return redirect::route('gmailAuth');
			}
		}
		

		$oauth = new Hybrid_Auth(app_path().'/config/gm_auth.php');
		$provider = $oauth->authenticate('Google');
		$profile = $provider->getUserProfile();
			
		$user_contacts = $provider->getUserContacts();
		$user = User::where('email', '=', $profile->email);
		if($user->count())
		{
			$user = $user->firstOrFail();	
			$user = User::find($user['id']);
			//crypt(md5($password), '$6$rounds=500000$' . substr(md5(md5($username)), 0, 16) . '$');
			Auth::login($user);
            if( Auth::check() ){
            	return Redirect::route('user-list')
            			->with('message', 'Sign in Successfully by googole !')
            			->with('message_type', 'success');
            }
            else{
            	return Redirect::route('user-sign-in')
            			->with('message', 'Unauthorised sign in')
            			->with('message_type', 'danger');
            }


		}else{
			return Redirect::route('home')
        			->with('message', 'Account Not Authorized ')
        			->with('message_type', 'danger');	
		}		

	}


	public function postSignIn(){

		$validation = User::validateSignIn( Input::all() );
		
		if($validation->fails()){
			return Redirect::route('user-sign-in')->withErrors($validation)->withInput();
		}else{
			
			$remember = (Input::has('remember')) ? true : false;
			$username = Input::get('username');
			$password = Input::get('password');
			$password   = crypt(md5($password), '$6$rounds=500000$' . substr(md5(md5($username)), 0, 16) . '$');
			$user = User::where('username', '=', $username)
							->where('password', '=', $password);
			
			if($user->count()){
				$user = $user->firstOrFail();	
				$user = User::find($user['id']);
				Auth::login($user);
	            if( Auth::check() ){
	            	return Redirect::route('user-list')
	            			->with('message', 'Sign in Successfully')
	            			->with('message_type', 'success');
	            }
	            else{
	            	return Redirect::route('user-sign-in')
	            			->with('message', 'Unauthorised sign in')
	            			->with('message_type', 'danger');
	            }


			}

		}

		return Redirect::route('user-sign-in')->with('message', 'Unauthorised sign in or are you activated ?');


	}

	public function getSignOut(){
		 $gmauth = new Hybrid_Auth(app_path().'/config/gm_auth.php');
		 $gmauth->logoutAllProviders();

		 Auth::logout();
		return Redirect::route('home')
						->with('message', 'Log Out!')
            			->with('message_type', 'success');
	}


	
}