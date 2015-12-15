<?php

class PredefinedTrip extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['transport_package_id', 'booking_id','pick_up_date_time','val', 'amount'];


	public function booking()
	{
		return $this->belongsTo('Booking');
	}

	public function transportPackage()
	{
		return $this->belongsTo('TransportPackage');
	}

}