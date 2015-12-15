<?php

class Client extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
		 'passport_number' => 'required',
		 'dob' => 'required|date',
		 'gender' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = [ 'name', 'passport_number', 'booking_id', 'dob', 'gender' ];


}