<?php

class HotelController extends \BaseController
{

    /* Index Page */

    public function getReservations()
    {

        if (Input::has('st_date')) {
            $st_date = Input::get('st_date');
        } elseif (Session::has('st_date')) {
            $st_date = Session::get('st_date');
        } else {
            $st_date = date("Y/m/d");
        }

        //Session::flush();

        if (Input::has('ed_date')) {
            $ed_date = Input::get('ed_date');
        } elseif (Session::has('ed_date')) {
            $ed_date = Session::get('ed_date');
        } else {
            $ed_date = date("Y/m/d", strtotime($st_date . ' + 2 days'));
        }

    //    dd($st_date);

        Session::put('st_date', $st_date);
        Session::put('ed_date', $ed_date);

        if (Input::has('txt-search')) {
            $get_city_or_hotel = Input::get('txt-search');
            Session::put('reservation', 2);
            Session::put('txt-search', $get_city_or_hotel);
        } else {
            if (Session::has('txt-search')) {
                $get_city_or_hotel = Session::get('txt-search');;
            } else {
                $get_city_or_hotel = 'Kandy';
            }

            Session::put('reservation', 3);
        }

        if (Input::has('availability')) {
            if (Input::has('room_type')) {
                $room_type = Input::get('room_type');
            } else {
                $room_type = 2;
            }

            if (Input::has('meal_basis')) {
                $meal_basis = Input::get('meal_basis');
            } else {
                $meal_basis = 2;
            }

            if (Input::has('room_count')) {
                $room_count = Input::get('room_count');
            } else {
                $room_count = 1;
            }
        } else {
            $room_type = '%';
            $meal_basis = '%';
            $room_count = 1;
        }

        // dd($room_type.'/'.$meal_basis);

        Session::put('room_type', $room_type);
        Session::put('meal_basis', $meal_basis);
        Session::put('room_count', $room_count);

        if (Input::has('hotel_star')) {
            Session::put('reservation', 2);
            $star = Input::get('hotel_star');
            if ($star == 5) {
                $star = 4;
            } else if ($star == 7) {
                $star = 5;
            }
        } else {
            $star = '%';
        }

        if (!empty($get_city_or_hotel)) {

            $city_or_hotel = $get_city_or_hotel;

            $get_city_or_hotel_id = DB::table('cities')->where('city', 'LIKE', $city_or_hotel)->where('val', 1)->first();

            if (!is_null($get_city_or_hotel_id)) {
                $city_id = $get_city_or_hotel_id->id;

                $hotels = Rate::With('MealBasis', 'RoomSpecification', 'Hotel')
                    ->WhereHas('Hotel', function ($q) use ($city_id, $star) {
                        $q->where('val', 1);
                        $q->where('star_category_id', 'LIKE', $star);
                        $q->where('city_id', $city_id);
                    })
                    ->where('room_specification_id', 'LIKE', $room_type)
                    ->where('meal_basis_id', 'LIKE', $meal_basis)
                    ->groupBy('hotel_id')
                    ->orderBy('hotel_id', 'desc')
                    ->paginate(9);

                //dd($hotels);

            } else {

                $get_city_or_hotel_id = DB::table('hotels')->where('name', 'LIKE', $city_or_hotel)->first();
                $hotel_id = $get_city_or_hotel_id->id;

                $city_id = $get_city_or_hotel_id->city_id;
                $get_city = DB::table('cities')->where('id', '=', $city_id)->first();
                $city_name = $get_city->city;


                $hotels = Rate::WhereHas('Hotel', function ($q) use ($hotel_id) {
                    $q->where('val', 1);
                    $q->where('hotel_id', $hotel_id);
                })
                    ->groupBy('hotel_id')
                    ->paginate(5);
            }

        }


        return View::make('reservations.index')
            ->with(
                array(
                    'hotels' => $hotels,
                    'city_or_hotel' => $city_or_hotel,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                )
            );
    }


    /* Hotel Details */

    public function hotelDetail()
    {

        if (Input::has('hotel_id')) {
            $hotel_id = Input::get('hotel_id');
            Session::put('hotel_id', $hotel_id);
        } else {
            $hotel_id = Session::get('hotel_id');
        }


        if (Session::has('market')) {
            $market = Session::get('market');
        }


        $st_date = Session::get('st_date');
        $ed_date = Session::get('ed_date');

        $date_ed = new DateTime(Session::get('ed_date'));
        $date_st = new DateTime(Session::get('st_date'));
        $date_difference = $date_ed->diff($date_st);

        $date_gap = $date_difference->d;
        Session::put('date_gap', $date_gap);


        if (Input::has('room_type')) {
            $room_type = Input::get('room_type');
            Session::put('filter_room_type', $room_type);
            $meal_basis = Session::get('filter_meal_type');
        } else {
            $room_type = Session::get('room_type');
        }

        if (Input::has('meal_type')) {
            $meal_basis = Input::get('meal_type');
            Session::put('filter_meal_type', $meal_basis);
            $room_type = Session::get('filter_room_type');
        } else {
            $meal_basis = Session::get('meal_basis');
        }

//dd($meal_basis.'/'.$room_type);

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));


        $path = array();
        $directory = public_path() . '/images/hotel_images/';
        $images = glob($directory . $hotel_id . "_" . "*.*");

        foreach ($images as $image) {
            $path[] = $image;
        }
//dd($hotel_id);
        $hotel_name = Hotel::Where('id', $hotel_id)->first()->name;

        $get_rooms = DB::table('rates')
            ->select(
                'rates.id as rate_id', 'rates.from', 'rates.to', 'rates.rate',
                'hotels.id as hotel_id', 'hotels.name as hotel_name', 'hotels.star_category_id', 'hotels..city_id',
                'meal_bases.id as meal_basis_id', 'meal_bases.meal_basis', 'meal_bases.meal_basis_name',
                'room_types.id as room_type_id', 'room_types.room_type',
                'room_specifications.id as room_specification_id', 'room_specifications.room_specification'
            )
            ->join('hotels', 'hotels.id', '=', 'rates.hotel_id')
            ->join('meal_bases', 'meal_bases.id', '=', 'rates.meal_basis_id')
            ->join('room_types', 'room_types.id', '=', 'rates.room_type_id')
            ->join('room_specifications', 'room_specifications.id', '=', 'rates.room_specification_id')
            ->where('rates.val', 1)
            ->where('rates.hotel_id', $hotel_id)
            ->where('rates.room_specification_id', 'LIKE', $room_type)
            ->where('rates.meal_basis_id', 'LIKE', $meal_basis)
            ->where('rates.from', '<=', $from_date)
            ->where('rates.to', '>', $from_date)
            // ->groupBy('rates.meal_basis_id')
            //->orderBy('rates.meal_basis_id', 'desc')
            ->get();

        //     dd(count($get_rooms));

        if (!empty($get_rooms)) {
            foreach ($get_rooms as $room) {

                $hotel_id = $room->hotel_id;
                $room_type_id = $room->room_type_id;
                $room_specification_id = $room->room_specification_id;
                $meal_basis_id = $room->meal_basis_id;
                $room_type = $room->room_type;
                $meal_basis = $room->meal_basis;
                $room_specification = $room->room_specification;

                //dd($room_type_id.'/'.$room_specification_id.'/'.$meal_basis_id);

                $get_low_hotel_rate = Rate::lowestRoomRateWithTax($hotel_id, $room_type_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);

                if ($get_low_hotel_rate > 0) {
                    $low_room_rate = $get_low_hotel_rate;
                } else {
                    $low_room_rate = 0;
                }

                $room_array = array(
                    'hotel_id' => $hotel_id,
                    'room_type_id' => $room_type_id,
                    'room_specification_id' => $room_specification_id,
                    'meal_basis_id' => $meal_basis_id,
                    'room_type' => $room_type,
                    'meal_basis' => $meal_basis,
                    'room_specification' => $room_specification,
                    'low_room_rate' => $low_room_rate,
                );

                $rooms[] = $room_array;
                //array_push($rooms, $room_array);
                array_merge($rooms, $room_array);
                // dd(count($get_rooms));
            }

        } else {
            return null;
        }

        return Response::json(
            array(
                'hotel_name' => $hotel_name,
                'rooms' => $rooms
            )
        );
        //
    }

    /* Request Rate */

    public function requestRate()
    {

        $st_date = Session::get('st_date');
        $ed_date = Session::get('ed_date');

        $hotel_id = Input::get('hotel_id');
        $room_specification = Input::get('room_specification');
        $room_type = Input::get('room_type');
        $meal_basis = Input::get('meal_basis');
        $room_count = Input::get('room_count');

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        if (Session::has('market')) {
            $market = Session::get('market');
        }
        //dd($room_count);

        $request_rate = array(
            'hotel_id' => $hotel_id,
            'user_id' => $user_id,
            'from' => $st_date,
            'to' => $ed_date,
            'room_specification_id' => $room_specification,
            'room_type_id' => $room_type,
            'meal_basis_id' => $meal_basis,
            'room_count' => $room_count,
            'market_id' => $market,
        );
        $request_rate_id = RateInquiry::create($request_rate);

        return Redirect::to('/reservations');

    }

    /* Request Allotment */

    public function requestAllotment()
    {

        $st_date = Session::get('st_date');
        $ed_date = Session::get('ed_date');

        if (Input::has('room_refer_id')) {
            $room_identity = Input::get('room_refer_id');
            $room_identity_array = explode("_", $room_identity);

            $hotel_id = $room_identity_array[0];
            $room_type = $room_identity_array[1];
            $room_count = Session::get('room_count');
        }

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        if (Session::has('market')) {
            $market = Session::get('market');
        }
        //dd($room_count);

        $request_allotment = array(
            'hotel_id' => $hotel_id,
            'user_id' => $user_id,
            'from' => $st_date,
            'to' => $ed_date,
            'room_type_id' => $room_type,
            'room_count' => $room_count,
            'market_id' => $market,
        );
        $request_allotment_id = AllotmentInquiry::create($request_allotment);

        return Response::json(true);

    }

    /* Search page */

    public function viewSearch()
    {

        $st_date = Input::get('check_in_date');
        $ed_date = Input::get('check_out_date');

        Session::put('st_date', $st_date);
        Session::put('ed_date', $ed_date);


        if (Input::has('txt-search')) {
            $get_city_or_hotel = Input::get('txt-search');
        } else {
            $get_city_or_hotel = 'Kandy';
        }


        if (!empty($get_city_or_hotel)) {

            $city_or_hotel = $get_city_or_hotel;

            $get_city_or_hotel_id = DB::table('cities')->where('city', 'LIKE', $city_or_hotel)->where('val', 1)->first();

            if (!is_null($get_city_or_hotel_id)) {

                $city_id = $get_city_or_hotel_id->id;
                $city = str_replace(' ', '-', $get_city_or_hotel);

            } else {

                $get_city_or_hotel_id = DB::table('hotels')->where('name', 'LIKE', $city_or_hotel)->first();
                $hotel_id = $get_city_or_hotel_id->id;
                $hotel = str_replace(' ', '-', $get_city_or_hotel);

                $city_id = $get_city_or_hotel_id->city_id;
                $get_city = DB::table('cities')->where('id', '=', $city_id)->first();
                $city_name = $get_city->city;
                $city = str_replace(' ', '-', $city_name);

            }

        } else {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }

    }


    /*  No result page */

    public function viewNoResult()
    {

        if (Session::has('st_date')) {
            $st_date = Session::get('st_date');
        } else {
            $st_date = date("Y/m/d");
        }

        //Session::flush();

        if (Session::has('ed_date')) {
            $ed_date = Session::get('ed_date');
        } else {
            $ed_date = date("Y/m/d", strtotime($st_date . ' + 2 days'));
        }


        // Filtering
        $hotel_type = DB::table('hotel_categories')->where('val', 1)->get();
        $hotel_cities = DB::table('cities')->where('val', 1)->get();
        $hotel_facilities = DB::table('hotel_facilities')->where('val', 1)->get();

        return
            array(
                'hotel_type' => $hotel_type,
                'hotel_cities' => $hotel_cities,
                'hotel_facilities' => $hotel_facilities,
                'st_date' => $st_date,
                'ed_date' => $ed_date,
            );
    }

    /* Add To Cart */

    public function addToCart()
    {

        $hot_id = Input::get('hotel_id');

        if (Input::has('room_refer_id')) {

            $room_identity = Input::get('room_refer_id');

            $room_identity_array = explode("_", $room_identity);


            $hotel_id = $room_identity_array[0];
            $room_id = $room_identity_array[1];
            $room_specification_id = $room_identity_array[2];
            $meal_basis_id = $room_identity_array[3];
            $room_count = Session::get('room_count');


            $hotel_name = Hotel::where('id', $hotel_id)->first()->name;
            $hotel_address = Hotel::where('id', $hotel_id)->first()->address;
            $room_name = RoomType::where('id', $room_id)->first()->room_type;

            $room_specification = RoomSpecification::where('id', $room_specification_id)->first()->room_specification;
            $meal_basis = MealBasis::where('id', $meal_basis_id)->first()->meal_basis_name;


            $adult = RoomSpecification::where('id', $room_specification_id)->first()->adults;
            $child = RoomSpecification::where('id', $room_specification_id)->first()->children;
            $nights = Session::get('date_gap');


            $st_date = date('Y-m-d', strtotime(Session::get('st_date')));
            $ed_date = date('Y-m-d', strtotime(Session::get('ed_date')));


            $date_count = Voucher::getNights($st_date, $ed_date)->days;

            //dd($room_id.'/'.$room_specification_id.'/'.$meal_basis_id);

            $room_rate = Rate::lowestRoomRate($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);
            $room_rate_with_tax = Rate::lowestRoomRateWithTax($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);

            $room_cost = ($room_rate_with_tax * $room_count) * $date_count;


            if (Session::has('market')) {
                $market = Session::get('market');
            } else {
                $market = 1;
            }


            $get_market_details = Market::where('id', $market)->first();

            $tax_type = $get_market_details->tax_type;
            $tax = $get_market_details->tax;
            $handling_fee_type = $get_market_details->handling_fee_type;
            $handling_fee = $get_market_details->handling_fee;

            $supplement_rate = Rate::supplementRate($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);

            if ($market == 1) {

                if ($tax_type == 0) {
                    $total_tax = ($room_rate_with_tax / 100) * $tax;
                } else {
                    $total_tax = $tax;
                }

                if ($handling_fee_type == 0) {
                    $total_handling_fee = ($room_rate / 100) * $handling_fee;
                } else {
                    $total_handling_fee = $handling_fee;
                }


                $hotel_handling_fee = $total_handling_fee;
                $hotel_tax = $total_tax;

            } else {

                $total_tax = 0;

                if ($handling_fee_type == 0) {
                    $total_handling_fee = ($room_rate / 100) * $handling_fee;
                } else {
                    $total_handling_fee = $handling_fee;
                }

                $hotel_tax = $total_tax;
                $hotel_handling_fee = $total_handling_fee;
            }


            $rate_box_details = array(
                'hotel_id' => $hotel_id,
                'hotel_name' => $hotel_name,
                'hotel_address' => $hotel_address,
                'room_name' => $room_name,
                'room_type_id' => $room_id,
                'room_specification' => $room_specification,
                'room_specification_id' => $room_specification_id,
                'meal_basis' => $meal_basis,
                'meal_basis_id' => $meal_basis_id,
                'room_cost' => $room_cost,
                'hotel_tax' => $hotel_tax,
                'hotel_handling_fee' => $hotel_handling_fee,
                'supplement_rate' => $supplement_rate,
                'room_count' => $room_count,
                'unit_price' => $room_rate_with_tax,
                'hotel_room_price' => $room_rate,
                'adult' => $adult,
                'child' => $child,
                'nights' => $nights,
                'room_identity' => $room_identity,
                'check_in' => $st_date,
                'check_out' => $ed_date,
                'unit_cost_price' => (double)$hotel_tax + (double)$room_cost
            );


            if (Session::has('rate_box_details_' . $hotel_id)) {
                $data = Session::get('rate_box_details_' . $hotel_id);
                $data[$room_identity] = $rate_box_details;
            } else {
                $data = [];
                $data[$room_identity] = $rate_box_details;
            }

            Session::put('rate_box_details_' . $hotel_id, $data);
        }

        //dd(Session::get('rate_box_details_'.$hotel_id));

        return Response::json($hotel_id);

    }


    /* For the auto complete option */

    public function autoComplete()
    {

        if (isset($_POST['queryString'])) {

            $queryString = $_POST['queryString'];

            // Is the string length greater than 0?
            if (strlen($queryString) > 0) {

                $hotels = Hotel::where('name', 'LIKE', '%' . $queryString . '%')->select('name')->where('val', 1)->limit(4)->get();
                $cities = City::where('city', 'LIKE', '%' . $queryString . '%')->select('city')->where('val', 1)->limit(4)->get();

                //dd(DB::getQueryLog());

                if (!is_null($cities)) {
                    if ($cities) {
                        // While there are results loop through them - fetching an Object.

                        foreach ($cities as $city) {

                            $directory = 'a';
                            $images = glob($directory . "location.png");
                            $img_path = array_shift($images);
                            $img_name = basename($img_path);


                            echo '
                        <div class="auto_complete">
                            <a value="' . $city->city . '" category="city">

                             <span class="search_thumb">
                            <img class="search_thumb" src="/images/site/location.png" />
                             </span>

                            <span class="category">' . $city->city . '
                            </span>

                            </a>
                            </div>';

                        }

                    }
                }

                if (!is_null($hotels)) {
                    if ($hotels) {
                        // While there are results loop through them - fetching an Object.
                        foreach ($hotels as $hotel) {

                            $directory = public_path() . '/images/site/';
                            $images = glob($directory . "hotel.png");
                            $img_path = array_shift($images);
                            $img_name = basename($img_path);

                            echo '
                        <div class="auto_complete">
                            <a value="' . $hotel->name . '" category="hotel">

                             <span class="search_thumb">
                             <img class="search_thumb" src="/images/site/hotel.png" />
                             </span>

                            <span class="category">' . $hotel->name . '
                            </span>

                            </a>
                            </div>';

                        }
                    }
                }

            } else {
                echo 'Please Type Again To Start The Search';
            } // There is a queryString.
        } else {
            echo 'There should be no direct access to this script!';
        }

    }
}
