<?php

/**
 * Created by PhpStorm.
 * User: thilina
 * Date: 2015-08-06
 * Time: 5:19 PM
 */
class TourController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function gridView($tour = '', $city_or_accommodation = '')
    {
        Session::put('tour_view', 2);

        try {
            $hotel_results = $this->viewHotelList($tour, $city_or_accommodation);
            return View::make('hotel.hotel_grid')
                ->with($hotel_results);
        } catch (Exception $e) {
            $no_result = $this->viewNoResult();
            return View::make('tour.no_results')
                ->with($no_result);
        }
    }

    /*
     Hotel list page
    */

    public function viewTourList($tour_name)
    {

        $x = 0;
        $path = array();

        $grid_url = 'tour/sri-lanka/grid/view/' . $tour_name;
        $list_url = 'tour/sri-lanka/' . $tour_name;


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

        $country = Country::where('val', 1)->lists('country', 'id');
        $city = City::where('val', 1)->lists('city', 'id');

        $filter_tours = Tour::where('val', 1)->get();
        $filter_cities = City::where('val', 1)->get();


        if (Input::has('tour')) {
            $tour_id = Input::get('tour');
        } elseif (!empty($tour_name)) {
            $tour_name = str_replace('-', ' ', $tour_name);
            $get_tour_id = DB::table('tours')->where('tour_title', 'LIKE', $tour_name)->first();
            $tour_id = $get_tour_id->id;
        }


        if (!empty($tour_id)) {
            $tours = TourType::where('tour_id', '=', $tour_id)
                ->where('val', 1)
                ->paginate(6);
        }

        if (!$tours->count()) {
            return Redirect::to('/403');
        }

        return
            array(

                'tours' => $tours,
                'tour_id' => $tour_id,
                'st_date' => $st_date,
                'ed_date' => $ed_date,
                'grid_url' => $grid_url,
                'list_url' => $list_url,
                'country' => $country,
                'city' => $city,
                'filter_tours' => $filter_tours,
                'filter_cities' => $filter_cities,

            );

    }


    /*
     Hotel list page redirect page
    */

    public function tourList($tour_name = '')
    {
        Session::put('tour_view', 1);

        try {
            $tour_results = $this->viewTourList($tour_name);
            return View::make('tour.tour_list')
                ->with($tour_results);
        } catch (Exception $e) {
            $no_result = $this->viewNoResult();
            return View::make('tour.no_results')
                ->with($no_result);
        }
    }

    /*
     *no result page
     */
    public function viewNoResult()
    {
        // Filtering
        $country = Country::where('val', 1)->lists('country', 'id');
        $city = City::where('val', 1)->lists('city', 'id');

        $filter_tours = Tour::where('val', 1)->get();
        $filter_cities = City::where('val', 1)->get();

        return
            array(
                'filter_tours' => $filter_tours,
                'filter_cities' => $filter_cities,
                'country' => $country,
                'city' => $city,
            );
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function tourDetail($country = '', $tour = '', $tour_type = '')
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


        $filter_tours = Tour::where('val', 1)->get();
        $filter_cities = City::where('val', 1)->get();


        if (!empty($country)) {
            $country = str_replace('-', ' ', $country);
            $get_country_id = DB::table('countries')->where('country', 'LIKE', $country)->first();
            $country_id = $get_country_id->id;
        }


        if (!empty($tour)) {
            $tour = str_replace('-', ' ', $tour);
            $get_tour_id = DB::table('tours')->where('tour_title', 'LIKE', $tour)->first();
            $tour_id = $get_tour_id->id;
        }

        if (!empty($tour_type)) {
            $tour_type = str_replace('-', ' ', $tour_type);
            $get_tour_type_id = DB::table('tour_types')->where('tour_type_title', 'LIKE', $tour_type)->first();
            $tour_type_id = $get_tour_type_id->id;
        }

        $path = array();

        $tour = Tour::where('id', $tour_id)->where('val', 1)->get();

        $tour_type = TourType::where('id', $tour_type_id)->where('val', 1)->first();

//        dd(DB::getQueryLog());

        if (!$tour_type->count()) {
            return Redirect::to('/403');
        }

        return View::make('tour.tour_details')
            ->with(
                array(

                    'tour' => $tour,
                    'tour_id' => $tour_id,
                    'tour_type_id' => $tour_type_id,
                    'path' => $path,
                    'tour_type' => $tour_type,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }

    public function viewFilter()
    {

        if (Input::has('tour')) {
            $get_tour = Input::get('tour');

            $get_tour_name = DB::table('tours')->where('id', '=', $get_tour)->first();
            $tour_name = $get_tour_name->tour_title;
            $tour = str_replace(' ', '-', $tour_name);

            $url = 'tour/sri-lanka/' . $tour;
            return Redirect::to($url);
        }

    }

}