<?php

class MealBasis extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'meal_basis' => 'required',
		'meal_basis_name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['meal_basis', 'meal_basis_name', 'description', 'val'];

    public function rate(){
        return $this->has('Rate');
    }

}