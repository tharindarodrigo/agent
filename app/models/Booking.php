<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Booking extends \Eloquent
{

    // Add your validation rules here
    public static $agentRules = [
        'booking_name' => 'required',
        'arrival_date' => 'required',
        'departure_date' => 'required|after:arrival_date',
        'adults' => 'required|numeric',
        'children' => 'required|numeric',
//        'user_id'=> 'required',
        'email' => 'email'
    ];

    public static $userRules = [
        'booking_name' => 'required',
        'arrival_date' => 'required',
    ];

    public static $guestRules = [
        'booking_name' => 'required',
        'arrival_date' => 'required',
        'departure_date' => 'required|after:arrival_date',
        'email' => 'required|email',
        'phone' => 'required',
        'passport_number' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [
        'booking_name',
        'agent_reference_number',
        'arrival_date',
        'departure_date',
        'adults',
        'children',
        'reference_number',
        'val',
        'remarks',
        'email',
        'phone',
        'passport_number',
        'user_id',

    ];

    /**
     * Functions
     */

    public static function emailBookingDetails($bookingId, $view = 'emails.emailMaster', $subject = 'Booking Amendment - Ref No: ')
    {
        $hotel_bookings = [];

        if ($bookings = Session::get('rate_box_details')) {
            $rate_keys = array_keys($bookings);

            foreach ($rate_keys as $rate_key) {
                $hotel_id = explode('_', $rate_key)[0];

                $hotel_bookings[$hotel_id][] = $bookings[$rate_key];
                $hotel_bookings[$hotel_id]['hotel_name'] = $bookings[$rate_key]['hotel_name'];
                $hotel_bookings[$hotel_id]['hotel_address'] = $bookings[$rate_key]['hotel_address'];
                $hotel_bookings[$hotel_id]['room_identity'] = $bookings[$rate_key]['room_identity'];
            }
        }

        $bookingInfo = Booking::with('client')->with('flightDetail')->where('id', $bookingId)->first();

        $user = Auth::user();
        $booking = $bookingInfo->toArray();
//        dd($booking);

        $mail = Mail::send($view, array(
            'booking' => $booking
        ), function ($message) use ($user, $booking, $subject, $hotel_bookings) {
            $message->to('tharindarodrigo@gmail.com', $user->first_name)->subject($subject . $booking['reference_number']);
        });

        if ($mail) {
            return true;
        }

        return false;
    }


    public static function getBookingData($booking_id)
    {
        return Booking::where('id', $booking_id)
            ->with('client')
            ->with('flightDetail')
            ->with('voucher')
            ->with('invoice')
            ->with('customTrip')
            ->with('predefinedTrip')->first();
    }


    public static function getTotalVoucherAmount($booking)
    {
        $total = 0.0;
        foreach ($booking->voucher as $voucher) {
            if ($voucher->val == 1) {
                $total += Voucher::getVoucherAmount($voucher);
            }
        }
        return $total;
    }

    public static function getTotalCancelledVoucherAmount($booking)
    {
        $total = 0.0;
        foreach ($booking->voucher as $voucher) {
            if ($voucher->val == 0) {
                $total += $voucher->cancellation_amount;
            }
        }
        return $total;
    }

    public static function getTotalBookingAmount($booking)
    {
        $total = 0;

        $total += Booking::getTotalVoucherAmount($booking);
        $total += Booking::getTotalCancelledVoucherAmount($booking);
        $total += TransportPackage::getTotalTransportationAmount($booking);
        $total += ExcursionBooking::getTotalExcursionBookingAmount($booking);

        return $total;

    }

    public static function amendBooking($bookingid)
    {
        $booking = Booking::findOrFail($bookingid);
        $booking->count = ++$booking->count;
        return $booking->save() ? true : false;
    }


    /**
     * Relationships
     */

    public function client()
    {
        return $this->hasMany('Client');
    }

    public function flightDetail()
    {
        return $this->hasMany('FlightDetail');
    }

    public function voucher()
    {
        return $this->hasMany('Voucher');
    }

    public function invoice()
    {
        return $this->hasOne('Invoice');
    }

    public function market()
    {
        return $this->belongsTo('Market');
    }

    public function roomBooking()
    {
        return $this->hasManyThrough('RoomBooking', 'Voucher');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function customTrip()
    {
        return $this->hasMany('CustomTrip');
    }

    public function predefinedTrip()
    {
        return $this->hasMany('PredefinedTrip');
    }

    public function excursionBooking()
    {
        return $this->hasMany('ExcursionBooking');
    }


}