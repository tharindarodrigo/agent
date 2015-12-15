<?php

class FlightDetail extends \Eloquent {

	// Add your validation rules here
	public static $rules1 = [
		'date_arrival' => 'required',
		'arrival_time' => 'required',
        'arrival_flight' => 'required',
		'date_departure' => 'required',
		'departure_time' => 'required',
        'departure_flight' => 'required',
	];

    public static $rules = [
        'date' => 'required',
        'time' => 'required',
        'flight'=>'required',
        'flight_type'=>'required'
    ];

	// Don't forget to fill this array
	protected $fillable = ['flight', 'date', 'time', 'flight_type', 'booking_id'];

}