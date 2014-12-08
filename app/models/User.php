<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $fillable = array('email', 'username', 'password');
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules_create = array(
			'email'           => 'required|max:60|email|unique:users',
			'username'        => 'required|between:3,40|unique:users',
			'password'        => 'required|between:3,20'
		);

	public static function validate($data){
		return Validator::make($data, static::$rules_create);
	}

	public static $rules_sign_in = array(
			'username'           => 'required|min:3',
			'password'        => 'required'
		);

	public static function validateSignIn($data){
		return Validator::make($data, static::$rules_sign_in);
	}


}
