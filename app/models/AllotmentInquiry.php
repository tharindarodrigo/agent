<?php

class AllotmentInquiry extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

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

    public function roomType()
    {
        return $this->belongsTo('roomType');
    }

}