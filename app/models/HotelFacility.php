<?php

class HotelFacility extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
        'hotel_facility' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['hotel_facility','val'];

    public function hotel(){
        return $this->belongsToMany('Hotel');
    }

}