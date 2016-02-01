<?php

class Rate extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        'from' => 'required|date',
        'to' => 'required|date',
        'market_id' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['from', 'to', 'val', 'room_type_id', 'room_specification_id', 'market_id', 'meal_basis_id', 'user_id', 'hotel_id', 'rate'];

    public function roomType()
    {
        return $this->belongsTo('RoomType');
    }

    public function roomSpecification()
    {
        return $this->belongsTo('RoomSpecification');
    }

    public function mealBasis()
    {
        return $this->belongsTo('MealBasis');
    }

    public function market()
    {
        return $this->belongsTo('Market');
    }

    public function hotel()
    {
        return $this->belongsTo('Hotel');
    }

    public static function lowestHotelRate($hotel_id, $st_date, $ed_date)
    {

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        // dd($st_date.'*************'.$from_date);

        if (Session::has('market')) {
            $market = 1;
        } else {
            $market = 1;
        }

        $get_low_rate = Rate::where('hotel_id', '=', $hotel_id)
            ->where('from', '<=', $from_date)
            ->where('to', '>', $from_date)
            ->where('market_id', $market)
            ->min('rate');

        if (!empty($get_low_rate)) {

            $get_market_details = Market::where('id', $market)->first();

            $tax_type = $get_market_details->tax_type;
            $tax = $get_market_details->tax + 100;
            $handling_fee_type = $get_market_details->handling_fee_type;
            $handling_fee = $get_market_details->handling_fee;

            //dd($tax_type.'/'.$tax.'/'.$market.'/'.$get_low_rate);

            if ($market == 1) {
                if ($tax_type == 0) {
                    $low_rate = ($get_low_rate / $tax) * 100;
                } else {
                    $low_rate = ($get_low_rate) - $tax;
                }
            } else {
                if ($handling_fee_type == 0) {
                    $low_rate = ($get_low_rate / 100) * (100 + $handling_fee);
                } else {
                    $low_rate = $get_low_rate + $handling_fee;
                }
            }

            return $low_rate;
        } else {
            $low_rate = 0;
            return $low_rate;
        }
    }

    public static function lowestRoomRateWithTax($hotel_id, $room_type_id, $specification_id, $meal_basis_id, $st_date, $ed_date)
    {

        if (Session::has('adult_child')) {
            $adult = Session::get('adult');
            $child = Session::get('child');
        } else {
            $adult = Session::get('adult');
            $child = Session::get('child');
        }

        $x = 0;
        $room_rates = 0;
        $room_rate = 0;

        if (Session::has('market')) {
            $market = Session::get('market');
        } else {
            $market = 1;
        }

        $get_market_details = Market::where('id', $market)->first();

        $tax_type = $get_market_details->tax_type;
        $tax = $get_market_details->tax + 100;
        $handling_fee_type = $get_market_details->handling_fee_type;
        $handling_fee = $get_market_details->handling_fee;

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        $dates = (strtotime($ed_date) - strtotime($st_date)) / 86400;

        // dd($hotel_id .'/'. $room_type_id .'/'. $specification_id .'/'. $meal_basis_id .'/'. $st_date .'/'. $ed_date);

        for ($x = 1; $x <= $dates; $x++) {


            $get_room_rate = Rate::where('hotel_id', '=', $hotel_id)
                ->where('room_type_id', 'LIKE', $room_type_id)
                ->where('room_specification_id', 'LIKE', $specification_id)
                ->where('meal_basis_id', 'LIKE', $meal_basis_id)
                ->where('from', '<=', $from_date)
                ->where('to', '>', $from_date)
                ->where('market_id', $market)
                ->get();
//dd(count($get_room_rate));
            if (count($get_room_rate) > 0) {
                //dd($tax.'/'.$tax_type.'/'.$handling_fee.'/'.$handling_fee_type);
                foreach ($get_room_rate as $low_rates) {

                    $room_rate = $low_rates->rate;

                    if ($market == 1) {
                        if ($tax_type == 0) {
                            $low_rate = ($room_rate / $tax) * 100;
                        } else {
                            $low_rate = $room_rate - $tax;
                        }
                    } else {
                        if ($handling_fee_type == 0) {
                            $low_rate = ($room_rate / 100) * (100 + $handling_fee);
                        } else {
                            $low_rate = $room_rate + $handling_fee;
                        }
                    }

                }

                $from_date = date('Y-m-d', strtotime($from_date . ' + 1 days'));
                $room_rates = $room_rates + $low_rate;


                $lowest_room_rate = number_format(($room_rates / $dates), 2);
                return ($lowest_room_rate);
            } else {
                $lowest_room_rate = 0;
                return ($lowest_room_rate);
            }

        }
    }


    public static function lowestRoomRate($hotel_id, $room_type_id, $specification_id, $meal_basis_id, $st_date, $ed_date)
    {

        if (Session::has('adult_child')) {
            $adult = Session::get('adult');
            $child = Session::get('child');
        } else {
            $adult = Session::get('adult');
            $child = Session::get('child');
        }

        $x = 0;
        $room_rates = 0;
        $room_rate = 0;

        if (Session::has('market')) {
            $market = Session::get('market');
        } else {
            $market = 1;
        }

        $get_market_details = Market::where('id', $market)->first();

        $tax_type = $get_market_details->tax_type;
        $tax = $get_market_details->tax + 100;
        $handling_fee_type = $get_market_details->handling_fee_type;
        $handling_fee = $get_market_details->handling_fee;

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        $dates = (strtotime($ed_date) - strtotime($st_date)) / 86400;
        // dd($hotel_id .'/'. $room_type_id .'/'. $specification_id .'/'. $meal_basis_id .'/'. $st_date .'/'. $ed_date);

        for ($x = 1; $x <= $dates; $x++) {

            $get_room_rate = Rate::where('hotel_id', '=', $hotel_id)
                ->where('room_type_id', $room_type_id)
                ->where('room_specification_id', $specification_id)
                ->where('meal_basis_id', $meal_basis_id)
                ->where('from', '<=', $from_date)
                ->where('to', '>', $from_date)
                ->where('market_id', $market)
                ->get();

            foreach ($get_room_rate as $low_rates) {
                $room_rate = $low_rates->rate;
            }

            $from_date = date('Y-m-d', strtotime($from_date . ' + 1 days'));
            $room_rates = $room_rates + $room_rate;

        }

        $lowest_room_rate = number_format(($room_rates / $dates), 2);
        return ($lowest_room_rate);

    }

    public static function supplementRate($hotel_id, $room_type_id, $specification_id, $meal_basis_id, $st_date, $ed_date)
    {

        $x = 0;
        $y = 0;
        $supplement_rates = 0;

        if (Session::has('market')) {
            $market = Session::get('market');
        } else {
            $market = 1;
        }

        $get_market_details = Market::where('id', $market)->first();

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        $dates = (strtotime($ed_date) - strtotime($st_date)) / 86400;

//      dd($market.'/'.$hotel_id.'/'.$room_type_id.'/'.$specification_id.'/'.$meal_basis_id.'/'.$st_date.'/'.$ed_date);

        for ($x = 1; $x <= $dates; $x++) {

            $supplement_rate = 0;

            $get_supplement_rates = SupplementRate::where('hotel_id', $hotel_id)
                ->where('room_type_id', $room_type_id)
                ->where('room_specification_id', $specification_id)
                ->where('meal_basis_id', $meal_basis_id)
                ->where('from', '<=', $from_date)
                ->where('to', '>', $from_date)
                ->where('market_id', $market)
                ->get();

            foreach ($get_supplement_rates as $get_supplement_rate) {
                $supplement_rate = $get_supplement_rate->rate;

                if ($supplement_rate > 0) {
                    $y = $y + 1;
                }
            }

            $from_date = date('Y-m-d', strtotime($from_date . ' + 1 days'));

            if ($supplement_rate > 0) {
                $supplement_rates = $supplement_rates + $supplement_rate;
            }

        }

        $room_supplement_rate = number_format(($supplement_rates), 2);
        return ($room_supplement_rate);

    }

}