<?php

class Allotment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'room_type_id' => 'required',
        'from' => 'required|date',
        'to' => 'required|date|after:from',
        'rooms' => 'required|integer'
	];

	// Don't forget to fill this array
	protected $fillable = ['room_type_id','from','to','rooms','hotel_id', 'val', 'user_id'];

    public function roomType(){
        return $this->belongsTo('RoomType');
    }

}