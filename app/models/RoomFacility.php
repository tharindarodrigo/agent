<?php

class RoomFacility extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'room_facility' => 'required',
		 'icon' => 'image'
	];

	// Don't forget to fill this array
	protected $fillable = ['room_facility', 'val'];

    public function hotel(){
        return $this->belongsToMany('Hotel');
    }

    public function roomType(){
        return $this->belongsToMany('RoomType');
    }

}