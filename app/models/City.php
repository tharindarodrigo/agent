<?php

class City extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'city' => 'required',
        'country_id' =>'required',
        'longitude' => 'numeric',
        'latitude' => 'numeric'
	];

	// Don't forget to fill this array
	protected $fillable = ['city', 'country_id', 'longitude','latitude','val'];

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function hotel(){
        return $this->hasMany('Hotel');
    }

    public function hotelCategory(){
        return $this->hasMany('HotelCategory');
    }

    public static function getCitiesWithCoordinates($cities){
        $cityList = [];
        foreach($cities as $city){
            $cityList[$city->longitude.','.$city->latitude] = $city->city;
        }
        return $cityList;
    }

    public function transportPackage(){
        return $this->hasMany('transportPackage');
    }

}