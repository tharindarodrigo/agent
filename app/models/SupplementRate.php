<?php

class SupplementRate extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'from' => 'required|date',
        'to' => 'required|date|after:from',
        'supplement_name' => 'required',
        'market_id' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['from', 'supplement_name','to','val', 'room_type_id', 'room_specification_id', 'market_id', 'meal_basis_id', 'user_id', 'hotel_id', 'rate'];

    public function roomType(){
        return $this->belongsTo('RoomType');
    }
    public function roomSpecification(){
        return $this->belongsTo('RoomSpecification');
    }
    public function mealBasis(){
        return $this->belongsTo('MealBasis');
    }
    public function market(){
        return $this->belongsTo('Market');
    }

}