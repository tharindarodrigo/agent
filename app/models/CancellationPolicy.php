<?php

class CancellationPolicy extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [
        'hotel_id', 'from', 'to', 'percentage_charged'
    ];



    public function getDaysToBooking($voucher)
    {

    }

    public function getHotelCancellationPeriods($hotel_id)
    {
        $cancellation = CancellationPolicy::where('hotel_id', $hotel_id)->get();

        return !empty($cancellation) ? $cancellation : false;
    }
}