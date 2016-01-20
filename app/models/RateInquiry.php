<?php

class RateInquiry extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [

    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function roomType()
    {
        return $this->belongsTo('RoomType');
    }

    public function hotel()
    {
        return $this->belongsTo('Hotel');
    }

    public function mealBasis()
    {
        return $this->belongsTo('MealBasis');
    }

    public function roomSpecifiation()
    {
        return $this->belongsTo('RoomSpecifiation');
    }


}