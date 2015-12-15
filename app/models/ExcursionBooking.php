<?php

class ExcursionBooking extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['booking_id', 'city_id', 'excursion_transport_type_id', 'excursion_id', 'unit_price', 'pax', 'date', 'reference_number','val'];

    public function booking()
    {
        return $this->belongsTo('Booking');
    }

    public function city()
    {
        return $this->belongsTo('City');
    }

    public function excursion()
    {
        return $this->belongsTo('Excursion');
    }

    public function excursionTransportType()
    {
        return $this->belongsTo('ExcursionTransportType');
    }

    public static function getTotalExcursionBookingAmount($booking)
    {
        $total = 0;
        foreach ($booking->excursionBooking as $excursionBooking) {
            if ($excursionBooking->val == 1) {
                $total += $excursionBooking->pax * $excursionBooking->unit_price;

            }
        }

        return $total;
    }

}