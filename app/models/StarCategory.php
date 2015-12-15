<?php

class StarCategory extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'stars' => 'required',
        'star_name' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['stars','star_name', 'val'];

    public function hotel()
    {
        return $this->has('Hotel');
    }


}