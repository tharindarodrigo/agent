<?php

class HotelReview extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function hotel(){
        return $this->belongsTo('Hotel');
    }
}
