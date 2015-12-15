<?php

class Market extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
        'market' => 'required',
        'tax' => 'required|numeric',
        'handling_fee' => 'required|numeric',

	];

	// Don't forget to fill this array
	protected $fillable = ['market', 'val', 'tax', 'tax_type', 'handling_fee_type', 'handling_fee'];

    public function rate()
    {
        return $this->hasMany('Rate');
    }

    public function agent()
    {
        return $this->hasMany('Agent');
    }

}