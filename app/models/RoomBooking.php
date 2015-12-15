<?php

class RoomBooking extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [
        'room_type_id',
        'meal_basis_id',
        'room_specification_id',
        'voucher_id',
        'room_count',
        'unit_price',
        'unit_cost_price'
    ];

    public function voucher(){
        return $this->belongsTo('voucher');
    }

    public function mealBasis()
    {
        return $this->belongsTo('MealBasis');
    }

    public function roomType()
    {
        return $this->belongsTo('RoomType');
    }

    public function roomSpecification()
    {
        return $this->belongsTo('RoomSpecification');
    }


}