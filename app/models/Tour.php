<?php

class Tour extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function tourType(){
        return $this->hasMany('tourType');
    }

}