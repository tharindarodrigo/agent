<?php

class HotelController extends \BaseController
{

    /*
    Hotel grid page redirect page
   */

    public function gridView($country = '', $city_or_accommodation = '')
    {
        Session::put('hot_view', 2);

        try {
            $hotel_results = $this->viewHotelList($country, $city_or_accommodation);
            return View::make('hotel.hotel_grid')
                ->with($hotel_results);
        } catch (Exception $e) {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }
    }


    /*
     Hotel list page redirect page
    */

    public function hotelList($country = '', $city_or_accommodation = '')
    {
        if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
            Session::put('hot_view', 2);
        } else {
            Session::put('hot_view', 1);
        }

        try {
            $hotel_results = $this->viewHotelList($country, $city_or_accommodation);
            return View::make('hotel.hotel_list')
                ->with($hotel_results);
        } catch (Exception $e) {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }
    }

    /*
     Hotel list making page
    */

    public function viewHotelList($country = '', $city_or_accommodation = '')
    {

        $country_url = $country;
        $city_or_accommodation_url = $city_or_accommodation;

        if ($country_url != '') {
            $country_url .= '/';
        }

        if ($city_or_accommodation_url != '') {
            $city_or_accommodation_url .= '/';
        }

        $grid_url = 'grid/view/' . $country_url . $city_or_accommodation_url;
        $list_url = $country_url . $city_or_accommodation_url;

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

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        $x = 0;
        $path = array();
        $star_id = array();
        $facility_id = array();


        if (Input::has('star_rating')) {
            $star = Input::get('star_rating');
            $get_star_ids = StarCategory::whereIn('stars', $star)->select('id')->get();
            foreach ($get_star_ids as $get_star_id) {
                $star_id[$get_star_id->id] = $get_star_id->id;
                Session::put('star', $star_id);
                // Session::forget('city');
                //  Session::forget('accommodation');
                // Session::forget('facility');
            }
        } else {
            $get_star_ids = StarCategory::select('id')->get();

            foreach ($get_star_ids as $get_star_id) {
                $star_id[] = $get_star_id->id;
                //   Session::forget('star');
                //  Session::forget('accommodation');
                //   Session::forget('facility');
            }
        }

        if (Input::has('facility')) {
            $facility = Input::get('facility');
            $get_facility_ids = HotelFacility::whereIn('hotel_facility', $facility)->select('id')->get();
            foreach ($get_facility_ids as $get_facility_id) {
                $facility[] = $get_facility_id->id;
                Session::put('facility', $facility);
                //  Session::forget('accommodation');
                //   Session::forget('city');
                //   Session::forget('star');
            }
        } else {
            $get_facility_ids = HotelFacility::select('id')->get();
            foreach ($get_facility_ids as $get_facility_id) {
                $facility[] = $get_facility_id->id;
                Session::put('facility', $facility);
                //  Session::forget('accommodation');
                //  Session::forget('city');
                //   Session::forget('star');
            }
        }

        if (Input::has('price_range')) {
            $price_range_array = Input::get('price_range');
            $price_range = explode(';', $price_range_array);

            $min_rate = $price_range[0];
            $max_rate = $price_range[1];
        } else {
            $min_rate = 0;
            $max_rate = 10000000;
        }


        // Filtering - Hotel
        $hotel_type = DB::table('hotel_categories')->where('val', 1)->get();
        $hotel_cities = DB::table('cities')->where('val', 1)->get();
        $hotel_facilities = DB::table('hotel_facilities')->where('val', 1)->get();

        // Filtering - Transport
        $vehicle = Vehicle::where('val', 1)->lists('vehicle_type', 'id');
        $city = City::where('val', 1)->lists('city', 'id');

        if (!empty($country)) {
            $country = str_replace('-', ' ', $country);
            $get_country_id = DB::table('countries')->where('country', 'LIKE', $country)->first();
            $country_id = $get_country_id->id;
        }

        if (!empty($city_or_accommodation)) {

            $city_or_accommodation = str_replace('-', ' ', $city_or_accommodation);

            if (Input::has('accommodation')) {
                $get_accommodation = Input::get('accommodation');
                $accommodation = DB::table('hotel_categories')->where('id', '=', $get_accommodation)->first();
                $city_or_accommodation = $accommodation->hotel_category;
                $get_city_or_accommodation_id = DB::table('hotel_categories')->where('hotel_category', 'LIKE', $city_or_accommodation)->first();
            } else {
                $get_city_or_accommodation_id = DB::table('hotel_categories')->where('hotel_category', 'LIKE', $city_or_accommodation)->first();
            }

            if (!is_null($get_city_or_accommodation_id)) {
                $accommodation_id = $get_city_or_accommodation_id->id;

            } elseif (Input::has('city')) {

                $get_city = Input::get('city');
                $city = DB::table('cities')->where('id', '=', $get_city)->first();
                $city_or_accommodation = $city->city;
                $get_city_or_accommodation_id = DB::table('cities')->where('city', 'LIKE', $city_or_accommodation)->first();
                $city_id = $get_city_or_accommodation_id->id;

            } else {
                $get_city_or_accommodation_id = DB::table('cities')->where('city', 'LIKE', $city_or_accommodation)->first();
                $city_id = $get_city_or_accommodation_id->id;
            }
        }

        //dd($city_id);

        if (!empty($city_id)) {
            Session::put('city', $city_id);
            Session::forget('accommodation');
            // Session::forget('star');
            // Session::forget('facility');
        }

        if (!empty($accommodation_id)) {
            Session::put('accommodation', $accommodation_id);
            //Session::forget('star');
            Session::forget('city');
            //Session::forget('facility');
        }

        if (Input::has('price_range')) {

            if (!empty($city_id)) {

                $hotels = Hotel::WhereHas('Rate', function ($r) use ($min_rate, $max_rate) {
                    $r->where('rate', '=>', $min_rate);
                    $r->where('rate', '=<', $max_rate);
                })
                    ->whereHas('HotelFacility', function ($q) use ($facility) {
                        $q->whereIn('hotel_facility_id', $facility);
                    })
                    ->where('val', 1)
                    ->where('city_id', $city_id)
                    ->whereIn('star_category_id', $star_id)
                    ->paginate(30);

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->min('rate');

                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->max('rate');

                //dd($min_rate . '/' . $max_rate);
            }

            if (!empty($accommodation_id)) {

                $hotels = Hotel::whereHas('HotelCategory', function ($query) use ($accommodation_id) {
                    $query->where('hotel_category_id', $accommodation_id);
                })
                    ->whereHas('Rate', function ($r) use ($min_rate, $max_rate, $from_date) {
                        $r->where('rate', '>=', $min_rate);
                        $r->where('rate', '<=', $max_rate);
                        $r->where('from', '<=', $from_date);
                        $r->where('to', '>=', $from_date);
                    })
                    ->where('val', 1)
//                    ->whereHas('HotelFacility', function ($q) use ($facility) {
//                        $q->whereIn('hotel_facility_id', $facility);
//                    })
                    //->whereIn('star_category_id', $star_id)
                    ->paginate(30);

//dd($hotels->getTotal());

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->min('rate');


                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->whereIn('hotel_facility_id', $facility)
                    ->max('rate');

//            dd(DB::getQueryLog());

            }

        } elseif (Input::has('facility')) {

            if (!empty($city_id)) {

                $hotels = Hotel::where('city_id', $city_id)
                    ->WhereHas('HotelFacility', function ($q1) use ($facility) {
                        $q1->whereIn('hotel_facility_id', $facility);
                    })
                    ->WhereHas('Rate', function ($r) use ($min_rate, $max_rate) {
                        $r->where('rate', '=>', $min_rate);
                        $r->where('rate', '=<', $max_rate);
                    })
                    ->where('val', 1)
                    ->whereIn('star_category_id', $star_id)
                    ->paginate(30);

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->min('rate');

                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->max('rate');

                //dd($min_hot_rate.'/'.$max_hot_rate);
            }

            if (!empty($accommodation_id)) {

                $hotels = Hotel::whereHas('HotelCategory', function ($query) use ($accommodation_id) {
                    $query->where('hotel_category_id', $accommodation_id);
                })
                    ->whereHas('HotelFacility', function ($q) use ($facility) {
                        $q->whereIn('hotel_facility_id', $facility);
                    })
//                    ->whereHas('Rate', function ($r) use ($min_rate, $max_rate) {
//                        $r->where('rate', '>=', $min_rate);
//                        $r->where('rate', '<=', $max_rate);
//                    })
                    ->where('val', 1)
                    ->whereIn('star_category_id', $star_id)
                    ->paginate(30);


//                $hotels = Hotel::whereIn('star_category_id', $star_id)
//                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
//                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
//                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
//                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
//                    ->where('hotel_category_id', $accommodation_id)
//                    //->whereIn('hotel_facility_id', $facility)
//                    ->groupBy('hotels.id')
//                    ->paginate(30);

//dd($hotels->getTotal());

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->whereIn('hotel_facility_id', $facility)
                    ->min('rate');


                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->whereIn('hotel_facility_id', $facility)
                    ->max('rate');

//            dd(DB::getQueryLog());

            }

        } else {

            if (!empty($city_id)) {

                $hotels = Hotel::where('city_id', $city_id)
//                ->WhereHas('HotelFacility', function ($q1) use ($facility) {
//                    $q1->whereIn('hotel_facility_id', $facility);
//                })
//                ->orWhereHas('Rate', function ($r1) use ($min_rate, $max_rate) {
//                    $r1->whereBetween('rate', array($min_rate, $max_rate));
//                })
                    ->where('val', 1)
                    ->whereIn('star_category_id', $star_id)
                    ->paginate(30);

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->min('rate');

                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotels.city_id', $city_id)
                    ->max('rate');

                //dd($min_hot_rate.'/'.$max_hot_rate);
            }

            //dd($from_date.'***'.$to_date);
            //dd($min_hot_rate.'***'.$max_hot_rate);

            if (!empty($accommodation_id)) {

                $hotels = Hotel::whereHas('HotelCategory', function ($query) use ($accommodation_id) {
                    $query->where('hotel_category_id', $accommodation_id);
                })
//                    ->whereHas('HotelFacility', function ($q) use ($facility) {
//                        //$q->whereIn('hotel_facility_id', $facility);
//                    })
//                    ->whereHas('Rate', function ($r) use ($min_rate, $max_rate) {
//                        $r->whereBetween('rate', array($min_rate, $max_rate));
//                    })
                    ->where('val', 1)
                    ->whereIn('star_category_id', $star_id)
                    ->paginate(30);


//dd($hotels->getTotal());

                $min_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->min('rate');


                $max_hot_rate = DB::table('hotels')
                    ->join('rates', 'rates.hotel_id', '=', 'hotels.id')
                    ->join('hotel_hotel_category', 'hotel_hotel_category.hotel_id', '=', 'hotels.id')
                    ->join('hotel_categories', 'hotel_categories.id', '=', 'hotel_hotel_category.hotel_category_id')
                    ->join('hotel_hotel_facility', 'hotel_hotel_facility.hotel_id', '=', 'hotels.id')
                    ->join('hotel_facilities', 'hotel_facilities.id', '=', 'hotel_hotel_facility.hotel_facility_id')
                    ->select('rates.rate', 'rates.val')
                    ->where('rates.val', 1)
                    ->where('hotel_category_id', $accommodation_id)
                    ->max('rate');

//            dd(DB::getQueryLog());

            }

        }

        if (!$hotels->count()) {
            return Redirect::to('/403');
        }

        return
            array(

                'hotels' => $hotels,
                'hotel_type' => $hotel_type,
                'hotel_cities' => $hotel_cities,
                'hotel_facilities' => $hotel_facilities,
                'vehicle' => $vehicle,
                'city' => $city,
                'st_date' => $st_date,
                'ed_date' => $ed_date,
                'grid_url' => $grid_url,
                'list_url' => $list_url,
                'min_hot_rate' => $min_hot_rate,
                'max_hot_rate' => $max_hot_rate,
                'selected_min_rate' => $min_rate,
                'selected_max_rate' => $max_rate,

            );

    }

    /*
     *no result page
     */
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

    /*
     *no result page
     */
    public function viewSearch()
    {

        $st_date = Input::get('check_in_date');
        $ed_date = Input::get('check_out_date');

        Session::put('st_date', $st_date);
        Session::put('ed_date', $ed_date);

        if (Input::has('adult')) {
            $adult = Input::get('adult');
            Session::put('adult', $adult);
        } else {
            $adult = 2;
            Session::put('adult', $adult);
        }

        if (Input::has('child')) {
            $child = Input::get('child');
            Session::put('child', $child);
        } else {
            $child = 0;
            Session::put('child', $child);
        }

        if (Input::has('txt-search')) {
            $get_city_or_accommodation = Input::get('txt-search');
        } else {
            $get_city_or_accommodation = Input::get('city_or_acc_hidden');

            if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
                $url = 'grid/view/sri-lanka/' . $get_city_or_accommodation;
                return Redirect::to($url);
            } else {
                $url = 'sri-lanka/' . $get_city_or_accommodation;
                return Redirect::to($url);
            }
        }

        if (!empty($get_city_or_accommodation)) {

            $city_or_hotel = $get_city_or_accommodation;

            $get_city_or_hotel_id = DB::table('cities')->where('city', 'LIKE', $city_or_hotel)->where('val', 1)->first();

            if (!is_null($get_city_or_hotel_id)) {
                $city_id = $get_city_or_hotel_id->id;
                $city = str_replace(' ', '-', $get_city_or_accommodation);

                if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
                    $url = 'grid/view/sri-lanka/' . $city;
                    return Redirect::to($url);
                } else {
                    $url = 'sri-lanka/' . $city;
                    return Redirect::to($url);
                }

            } else {
                $get_city_or_hotel_id = DB::table('hotels')->where('name', 'LIKE', $city_or_hotel)->first();
                $hotel_id = $get_city_or_hotel_id->id;
                $hotel = str_replace(' ', '-', $get_city_or_accommodation);

                $city_id = $get_city_or_hotel_id->city_id;
                $get_city = DB::table('cities')->where('id', '=', $city_id)->first();
                $city_name = $get_city->city;
                $city = str_replace(' ', '-', $city_name);

                if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
                    $url = 'sri-lanka/' . $city . '/' . $hotel;
                } else {
                    $url = 'sri-lanka/' . $city . '/' . $hotel;
                }
                //dd($url);
            }
            return Redirect::to($url);
        } else {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }

    }

    /*
     * Filter Page
     */
    public function viewFilter()
    {

        if ((Input::has('city')) || (Input::has('accommodation'))) {

            if (Input::has('accommodation')) {
                $get_city_or_accommodation = Input::get('accommodation');

                $get_accommodation_name = DB::table('hotel_categories')->where('id', '=', $get_city_or_accommodation)->first();
                $accommodation_name = $get_accommodation_name->hotel_category;
                $accommodation = str_replace(' ', '-', $accommodation_name);

                if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
                    $url = 'grid/view/sri-lanka/' . $accommodation;
                    return Redirect::to($url);
                } else {
                    $url = 'sri-lanka/' . $accommodation;
                    return Redirect::to($url);
                }
            }

            if (Input::has('city')) {
                $get_city_or_accommodation = Input::get('city');

                $get_city_name = DB::table('cities')->where('id', '=', $get_city_or_accommodation)->where('val', 1)->first();
                $city_name = $get_city_name->city;
                $city = str_replace(' ', '-', $city_name);

                if (Session::has('hot_view') && (Session::get('hot_view') == 2)) {
                    $url = 'grid/view/sri-lanka/' . $city;
                    return Redirect::to($url);
                } else {
                    $url = 'sri-lanka/' . $city;
                    return Redirect::to($url);
                }
            }

        } else {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function hotelDetail($country = '', $city = '', $hotel_name)
    {

        if (Session::has('market')) {
            $market = Session::get('market');
        } else {
            $market = 1;
        }

        if (Input::has('check_in_date')) {
            $start = Input::get('check_in_date');
            Session::put('st_date', $start);
        }

        if (Input::has('check_out_date')) {
            $end = Input::get('check_out_date');
            Session::put('ed_date', $end);
        }

        if (Input::has('adult')) {
            $adult = Input::get('adult');
            Session::put('adult', $adult);
        } else {
            Session::put('adult', 2);
        }

        if (Input::has('child')) {
            $child = Input::get('child');
            Session::put('child', $child);
        } else {
            Session::put('child', 0);
        }

        if (Session::has('st_date')) {
            $st_date = Session::get('st_date');
        } else {
            $st_date = date("Y/m/d");
        }

// Session::flush();

        if (Session::has('ed_date')) {
            $ed_date = Session::get('ed_date');
        } else {
            $ed_date = date("Y/m/d", strtotime($st_date . ' + 2 days'));
        }


        $date_ed = new DateTime(Session::get('ed_date'));
        $date_st = new DateTime(Session::get('st_date'));
        $date_difference = $date_ed->diff($date_st);

        $date_gap = $date_difference->d;
        Session::put('date_gap', $date_gap);

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));


        // Filtering
        $hotel_type = DB::table('hotel_categories')->where('val', 1)->get();
        $hotel_cities = DB::table('cities')->where('val', 1)->get();
        $hotel_facilities = DB::table('hotel_facilities')->where('val', 1)->get();


        if (!empty($country)) {
            $country = str_replace('-', ' ', $country);
            $get_country_id = DB::table('countries')->where('country', 'LIKE', $country)->first();
            $country_id = $get_country_id->id;
        }

        if (!empty($city)) {
            $city = str_replace('-', ' ', $city);
            $city = DB::table('cities')->where('city', 'LIKE', $city)->where('val', 1)->first();
            $city_id = $city->id;
        }

        if (!empty($hotel_name)) {
            $hotel_name = str_replace('-', ' ', $hotel_name);
            $get_hotel_id = Hotel::where('name', 'LIKE', $hotel_name)->first();
            $hotel_id = $get_hotel_id->id;
        }

        $path = array();

        $directory = public_path().'/images/hotel_images/';

        $images = glob($directory . $hotel_id . "_" . "*.*");

        foreach ($images as $image) {

            $path[] = $image;
        }

        $hotel = Hotel::where('id', '=', $hotel_id)->where('val', 1)->get();

        $rooms = RoomType::where('hotel_id', '=', $hotel_id)->where('val', 1)->get();

//        dd(DB::getQueryLog());

//        if (!$rooms->count()) {
//            return Redirect::to('/403');
//        }

        return View::make('hotel.hotel_details')
            ->with(
                array(
                    'hotel' => $hotel,
                    'hotel_id' => $hotel_id,
                    'hotel_type' => $hotel_type,
                    'hotel_cities' => $hotel_cities,
                    'hotel_facilities' => $hotel_facilities,
                    'path' => $path,
                    'rooms' => $rooms,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'date_gap' => $date_gap,
                    'market' => $market,
                )
            );
    }


    /* To Load The Map */

    public function getMap()
    {

        $hotel_id = Input::get('hotel_id');

        $hotel = Hotel::where('id', '=', $hotel_id)->select('latitude', 'longitude')->first();

        return Response::json($hotel);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    /* To Load The Map */

    public function getRoomRateBox()
    {

        $hot_id = Input::get('hotel_id');

        if (Input::has('check_room')) {

            $room_identity = Input::get('check_room');

            $hotel_id = Input::get('hotel_id');
            $room_id = Input::get('room_id');
            $meal_basis_id = Input::get('meal_basis_id');
            $room_specification_id = Input::get('room_specification_id');
            $room_count = Input::get('room_count');


            $hotel_name = Hotel::where('id', $hotel_id)->first()->name;
            $hotel_address = Hotel::where('id', $hotel_id)->first()->address;
            $room_name = RoomType::where('id', $room_id)->first()->room_type;

            $room_specification = RoomSpecification::where('id', $room_specification_id)->first()->room_specification;
            $meal_basis = MealBasis::where('id', $meal_basis_id)->first()->meal_basis_name;


            $adult = RoomSpecification::where('id', $room_specification_id)->first()->adults;
            $child = RoomSpecification::where('id', $room_specification_id)->first()->children;
            $nights = Session::get('date_gap');

            if (Input::has('check_in_date')) {
                $st_date = date('Y-m-d', strtotime(Input::get('check_in_date')));
            } else {
                $st_date = date('Y-m-d', strtotime(Session::get('st_date')));
            }

            if (Input::has('check_out_date')) {
                $ed_date = date('Y-m-d', strtotime(Input::get('check_out_date')));
            } else {
                $ed_date = date('Y-m-d', strtotime(Session::get('ed_date')));
            }

            $date_count = Voucher::getNights($st_date, $ed_date)->days;

            $room_rate = RoomRates::lowestRoomRate($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);
            $room_rate_with_tax = RoomRates::lowestRoomRateWithTax($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);

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

            $supplement_rate = RoomRates::supplementRate($hotel_id, $room_id, $room_specification_id, $meal_basis_id, $st_date, $ed_date);

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
                'unit_cost_price' => (double)$hotel_tax+ (double)$room_cost
            );

            if (Session::has('rate_box_details_' . $hotel_id)) {
                $data = Session::get('rate_box_details_' . $hotel_id);
                $data[$room_identity] = $rate_box_details;
            } else {
                $data = [];
                $data[$room_identity] = $rate_box_details;

            }

            //$data['total_cost'] = $total_cost;

            Session::put('rate_box_details_' . $hotel_id, $data);

        }


        $data = Session::get('rate_box_details_' . $hot_id);

        if (Session::has('rate_box_details_' . $hot_id)) {
            foreach ($data as $page_hot_id) {
                $page_hotel_id = $page_hot_id['hotel_id'];

                if ($hot_id == $page_hotel_id) {
                    if ((Session::has('rate_box_details_' . $hot_id)) || (Input::has('check_room'))) {
                        return Response::json(Session::get('rate_box_details_' . $hot_id));
                    } else {
                        return null;
                    }
                } else {
                    // return null;
                }

            }
        } else {
            //  return null;
        }

        //return Response::json(Session::get('rate_box_details'));

    }

    // room rates destroy

    public function roomRateBoxDestroy()
    {
        $deletable = Input::get('del_room_id');

        $hotel_id = explode('_', $deletable)[2];

        if (Session::has('rate_box_details_' . $hotel_id)) {
            $data = Session::get('rate_box_details_' . $hotel_id);
            ///dd($data);
            unset($data[$deletable]);

            if (!empty($data)) {
                Session::put('rate_box_details_' . $hotel_id, $data);
            } else {
                Session::forget('rate_box_details_' . $hotel_id);
                return null;
            }

        }

        return Response::json(Session::get('rate_box_details_' . $hotel_id));

    }

    /*
    *For the auto complete option
    */

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


    // get hotel list full map

    public function hotelListFullMap()
    {

        $hotel_list = Input::get('hotel_list');
        $hotel_list_name = str_replace('-', ' ', $hotel_list);
        $accommodation = DB::table('hotel_categories')->where('hotel_category', 'LIKE', $hotel_list_name)->first();

        if (!is_null($accommodation)) {
            $accommodation_id = $accommodation->id;

            $get_latitudes_longitudes = Hotel::whereHas('HotelCategory', function ($query) use ($accommodation_id) {
                $query->where('hotel_category_id', $accommodation_id);
            })
                ->select('latitude', 'longitude', 'name')
                ->get();

        } else {
            $city = DB::table('cities')->where('city', 'LIKE', $hotel_list_name)->where('val', 1)->first();
            $city_id = $city->id;

            $get_latitudes_longitudes = Hotel::where('city_id', $city_id)
                ->select('latitude', 'longitude', 'name')
                ->get();

        }

        return Response::json($get_latitudes_longitudes);

    }

    // get hotel list full map

    public function hotelListSingleMap()
    {

        $hotel_id = Input::get('hotel_id');

        $get_hotel_lan_lot = Hotel::where('id', $hotel_id)->select('id', 'longitude', 'latitude', 'name')->first();

        return Response::json($get_hotel_lan_lot);

    }

    public function getRoomList()
    {
        $hotel_id = Input::get('hotel_id');

        $rooms = RoomType::where('hotel_id',$hotel_id)->lists('room_type','id');

        return Response::json($rooms);
    }
}
