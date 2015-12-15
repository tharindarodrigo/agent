<?php

class CustomTrip extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['from','to','reference_number','vehicle_id','booking_id','locations','amount', 'val'];

	public function vehicle()
	{
		return $this->belongsTo('Vehicle');
	}
}