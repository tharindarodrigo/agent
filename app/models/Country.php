<?php

class Country extends \Eloquent {
	protected $fillable = [];


    public function city(){
        return $this->hasMany('City');
    }
}