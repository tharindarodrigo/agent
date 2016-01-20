<?php

class RoomSpecification extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];

    public function rate()
    {
        return $this->has('Rate');
    }

    public function roomType()
    {
        return $this->belongsToMany('RoomType');
    }

    public function hotel()
    {
        return $this->belongsToMany('hotel');
    }

}