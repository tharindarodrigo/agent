<?php

class Vehicle extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        'vehicle_type' => 'required',
        'passengers' => 'required|integer',
        'rate' => 'required|numeric'
    ];

    // Don't forget to fill this array
    protected $fillable = ['vehicle_type', 'passengers', 'rate', 'val'];

    public function transportPackage()
    {
        return $this->hasMany('TransportPackage');
    }

}