<?php

class Voucher extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['check_in', 'check_out', 'rooms','room_type_id','hotel_id','meal_basis_id','booking_id','amount','val'];


    public static function arrangeHotelBookingsVoucherwise($bookings, $booking_id=1)
    {

        $rate_keys = array_keys($bookings);
        $x=0;
        $room_bookings = [];
        foreach ($rate_keys as $rate_key) {
            $rate_key_array = explode('_', $rate_key);

            $voucher_key = date('Y-m-d',strtotime($rate_key_array[0])) . '_' . date('Y-m-d',strtotime($rate_key_array[1])) . '_' . $rate_key_array[2];

            $room_bookings[$voucher_key][] = $bookings[$rate_key];
            $room_bookings[$voucher_key]['hotel_id'] = $bookings[$rate_key]['hotel_id'];
            $room_bookings[$voucher_key]['check_in'] = $bookings[$rate_key]['check_in'];
            $room_bookings[$voucher_key]['check_out'] = $bookings[$rate_key]['check_out'];
            $room_bookings[$voucher_key]['reference_number'] = $x++;
            $room_bookings[$voucher_key]['booking_id'] = $booking_id;
            $room_bookings[$voucher_key]['val'] = 1;
        }

        return $room_bookings;
    }

    public static function getNights($checkindate, $checkoutdate)
    {
        $from = new DateTime($checkindate);
        $to = new DateTime($checkoutdate);

        return $interval = $to->diff($from);

    }
    public static function getVoucherAmount($voucher) //This should be optimized
    {
        $voucherAmount = 0.0;
        $check_in = $voucher->check_in;
        $check_out = $voucher->check_out;
        foreach($voucher->roomBooking as $roomBooking){
            $voucherAmount += ($roomBooking->unit_price * $roomBooking->room_count * Voucher::getNights($check_in,$check_out)->days) +
                $roomBooking->room_count * $roomBooking->unit_supplement_price;
        }

        return $voucherAmount;
    }

    public static function getHotelVoucherAmount($voucher)
    {
        $voucherAmount = 0.0;
        $check_in = $voucher->check_in;
        $check_out = $voucher->check_out;
        foreach($voucher->roomBooking as $roomBooking){
            $voucherAmount += ($roomBooking->unit_cost_price * $roomBooking->room_count * Voucher::getNights($check_in,$check_out)->days)+
                $roomBooking->unit_supplement_price;
        }



        return $voucherAmount;

    }

    public static function getDaysToBooking($voucher)
    {
        $checkIn = new DateTime($voucher->check_in);
        $today = new DateTime();

        return $days = $today->diff($checkIn);
    }


    public function hotel()
    {
        return $this->belongsTo('Hotel');
    }

    public function mealBasis()
    {
        return $this->belongsTo('MealBasis');
    }

    public function roomType()
    {
        return $this->belongsTo('RoomType');
    }

    public function booking()
    {
        return $this->belongsTo('Booking');
    }

    public function roomBooking()
    {
        return $this->hasMany('RoomBooking');
    }

    public function user()
    {

    }

}