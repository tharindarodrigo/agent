<?php

class Hotel extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'city_id' => 'required',
        'address' => 'required',
        'category_id' => 'required',
        'star_category_id' => 'required',
        'longitude' => 'numeric',
        'latitude' => 'numeric'
    ];

    public static $updateOverviewRules = [
        'name' => 'required',
        'category_id' => 'required',
    ];

    public static $updateLocationRules = [
        'city_id' => 'required',
        'address' => 'required',
        'longitude' => 'numeric',
        'latitude' => 'numeric'
    ];

    public static $updateTermsRules = [
        'check_in_time' => 'required',
        'check_out_time' => 'required',
    ];

    public static function star_loop_blue($stars)
    {
        for ($x = 0; $x < $stars; $x++) {
            $img_path = 'images/star_list.png';

            echo HTML::image($img_path, '');

        }
    }

    public static function star_loop_yellow($stars)
    {
        for ($x = 0; $x < $stars; $x++) {
            $img_path = 'images/star_yellow.png';

            echo HTML::image($img_path, '');

        }
    }


    // Don't forget to fill this array
    protected $fillable = ['name', 'country_id', 'city_id', 'address', 'star_category_id', 'user_id', 'longitude', 'latitude',
        'search_keywords', 'search_description', 'overview', 'terms_and_conditions', 'infant_age', 'infant_charge',
        'child_age', 'child_charge', 'check_in_time', 'check_out_time', 'val'];


    /**
     * Relationships
     */

    public function starCategory()
    {
        return $this->belongsTo('StarCategory');
    }

    public function user()
    {
        return $this->belongsToMany('User');
    }

    public function city()
    {
        return $this->belongsTo('City');
    }

    public function hotelCategory()
    {
        return $this->belongsToMany('HotelCategory');
    }

    public function hotelReview()
    {
        return $this->hasMany('HotelReview');
    }

    public function hotelFacility()
    {
        return $this->belongsToMany('HotelFacility');
    }

    public function roomFacility()
    {
        return $this->belongsToMany('RoomFacility');
    }

    public function roomType()
    {
        return $this->hasMany('RoomType');
    }

    public function rate()
    {
        return $this->hasMany('Rate');
    }

    public function cancellationPolicy()
    {
        return $this->hasMany('CancellationPolicy');
    }

    public function roomSpecification()
    {
        return $this->hasMany('roomSpecification');
    }

    public function mealBasis()
    {
        return $this->hasMany('mealBasis');
    }
}