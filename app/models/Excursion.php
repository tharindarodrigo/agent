<?php

class Excursion extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public static function getTotalExcursionAmount($booking)
    {
        return 0;
    }
    
    public function excursionType()
    {
        return $this->belongsTo('ExcursionType');
    }

    public function excursionRate()
    {
        return $this->hasMany('ExcursionRate');
    }

}