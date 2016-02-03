<?php

class RateInquiry extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [

    ];

    // Don't forget to fill this array
    protected $fillable = ['hotel_id', 'room_type_id','meal_basis_id','status', 'room_specification_id','from','to', 'user_id', 'market_id', 'room_count'];

    public function hotel()
    {
        return $this->belongsTo('Hotel');
    }

    public function roomSpecification()
    {
        return $this->belongsTo('roomSpecification');
    }

    public function market()
    {
        return $this->belongsTo('market');
    }

    public function mealBasis()
    {
        return $this->belongsTo('mealBasis');
    }

    public function roomType()
    {
        return $this->belongsTo('roomType');
    }
}