<?php

/**
 * Created by PhpStorm.
 * User: thilina
 * Date: 2015-08-06
 * Time: 5:19 PM
 */
class ExcursionController extends \BaseController
{

    /*
     excursion list page
    */

    public function viewExcursionList($excursion_type_name)
    {
        $x = 0;
        $path = array();

        $grid_url = 'tour/sri-lanka/grid/view/' . $excursion_type_name;
        $list_url = 'tour/sri-lanka/' . $excursion_type_name;


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
        $filter_excursion = ExcursionType::get();
        $filter_cities = City::where('val', 1)->get();


        if (!empty($excursion_type_name)) {
            $get_excursion_type_name = str_replace('-', ' ', $excursion_type_name);
            $get_excursion_type_id = DB::table('excursion_types')->where('excursion_type', 'LIKE', $get_excursion_type_name)->first();
            $excursion_type_id = $get_excursion_type_id->id;
        }

        if (!empty($excursion_type_id)) {
            $excursions = Excursion::where('excursion_type_id', '=', $excursion_type_id)
                ->where('val', 1)
                ->paginate(6);
        }


        if (!$excursions->count()) {
            return Redirect::to('/403');
        }

        return
            array(

                'excursions' => $excursions,
                'grid_url' => $grid_url,
                'list_url' => $list_url,
                'excursion_type_id' => $excursion_type_id,
                'st_date' => $st_date,
                'ed_date' => $ed_date,
                'filter_excursion' => $filter_excursion,
                'filter_cities' => $filter_cities,

            );

    }


    /*
     Hotel list page redirect page
    */

    public function excursionList($excursion_name = '')
    {
        Session::put('excursion_view', 1);

        try {
            $tour_results = $this->viewExcursionList($excursion_name);
            return View::make('excursion.excursion_list')
                ->with($tour_results);
        } catch (Exception $e) {
            $no_result = $this->viewNoResult();
            return View::make('hotel.no_results')
                ->with($no_result);
        }
    }

    /*
     *no result page
     */
    public function viewNoResult()
    {

        // Filtering
        $filter_excursion = Tour::get();
        $filter_cities = City::get();

        return
            array(
                'filter_excursion' => $filter_excursion,
                'filter_cities' => $filter_cities,
            );
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function excursionDetail($country = '', $excursion_type = '', $excursion = '')
    {

        $x = 0;

        if (!empty($country)) {
            $country = str_replace('-', ' ', $country);
            $get_country_id = DB::table('countries')->where('country', 'LIKE', $country)->where('val', 1)->first();
            $country_id = $get_country_id->id;
        }

        if (!empty($excursion_type)) {
            $excursion_type = str_replace('-', ' ', $excursion_type);
            $get_excursion_type_id = DB::table('excursion_types')->where('excursion_type', 'LIKE', $excursion_type)->first();
            $excursion_type_id = $get_excursion_type_id->id;
        }

        if (!empty($excursion)) {
            $excursion = str_replace('-', ' ', $excursion);
            $get_excursion_id = DB::table('excursions')->where('excursion', 'LIKE', $excursion)->where('val', 1)->first();
            $excursion_id = $get_excursion_id->id;
        }

        $transport_type = ExcursionTransportType::where('excursion_type_id', '=', $excursion_type_id)->lists('transport_type', 'id');

        $path = array();

        $directory = public_path().'/images/excursion_images/excursion_types/';

        $images = glob($directory . $excursion_id . "_" . "*.*");

        foreach ($images as $image) {
            $path[] = $image;
        }

        $excursion = Excursion::where('id', $excursion_id)->where('val', 1)->first();

        $excursion_type = ExcursionType::where('id', $excursion_type_id)->first();

        $excursion_rate = ExcursionRate::where('excursion_id', $excursion_id)->where('val', 1)->get();

//        dd(DB::getQueryLog());

        if (!$excursion->count()) {
            return Redirect::to('/403');
        }

        return View::make('excursion.excursion_details')
            ->with(
                array(

                    'x' => $x,
                    'excursion' => $excursion,
                    'excursion_id' => $excursion_id,
                    'excursion_type_id' => $excursion_type_id,
                    'path' => $path,
                    'excursion_type' => $excursion_type,
                    'transport_type' => $transport_type,
                    'excursion_rate' => $excursion_rate,

                )
            );
    }

    public function viewFilter()
    {

        if (Input::has('excursion')) {
            $get_excursion = Input::get('excursion');

            $get_excursion_name = DB::table('excursion_types')->where('id', '=', $get_excursion)->first();
            $excursion_name = $get_excursion_name->excursion_type;
            $excursion = str_replace(' ', '-', $excursion_name);

            $url = 'excursion/sri-lanka/' . $excursion;
            return Redirect::to($url);
        }

    }

    public function excursionSetTransport()
    {

        $transport_id = Input::get('transport_type');
        $excursion = Input::get('ex_id');
        $city_id = Input::get('hidden_ex_city_id');

        $get_excursion_rate = ExcursionRate::where('excursion_id', '=', $excursion)
            ->where('excursion_transport_type_id', '=', $transport_id)
            ->where('city_id', '=', $city_id)
            ->where('val', 1)
            ->select('rate')
            ->first();

        if(!empty($get_excursion_rate)) {
            $ex_rate = ($get_excursion_rate->rate * Session::get('currency_rate'));
        }else{
            $ex_rate = 0;
        }

        return Response::json($ex_rate);

    }

    public function excursionGetTotal()
    {

        $total_rate = 0;
        $price_details = array();

        $price_box_transport_id = Input::get('price_box_transport_id');
        $price_box_ex_id = Input::get('price_box_ex_id');
        $price_box_city_id = Input::get('price_box_city_id');
        $pax = Input::get('price_box_pax');

        $city = City::where('id', $price_box_city_id)->where('val', 1)->first()->city;
        $transport_type = ExcursionTransportType::where('id', $price_box_transport_id)->first()->transport_type;

        $get_excursion_price = ExcursionRate::where('excursion_id', '=', $price_box_ex_id)
            ->where('excursion_transport_type_id', '=', $price_box_transport_id)
            ->where('city_id', '=', $price_box_city_id)
            ->where('val', 1)
            ->select('rate')
            ->first();

        $get_ex_rate = $get_excursion_price->rate;

        $ex_rate = Session::get('currency') . '&nbsp;' . number_format(($get_ex_rate * Session::get('currency_rate')), 2, '.', '');

        $get_total_rate = $get_ex_rate * $pax;
        $total_rate = Session::get('currency') . '&nbsp;' . number_format(($get_total_rate * Session::get('currency_rate')), 2, '.', '');

        $price_details = array(
            'city' => $city,
            'transport_type' => $transport_type,
            'pax' => $pax,
            'ex_rate' => $ex_rate,
            'total_rate' => $total_rate,
        );

        return Response::json($price_details);

    }

    public function excursionAddToCart()
    {

        $excursion = Input::get('excursion');
        $excursion_city = Input::get('excursion_city');
        $excursion_transport = Input::get('excursion_transport');
        $excursion_pax = Input::get('excursion_pax');
        $excursion_rate = Input::get('excursion_rate');
        $excursion_total = Input::get('excursion_total');
        $excursion_date = date("Y-m-d", strtotime(Input::get('excursion_date')));
        $city_id = City::where('city', $excursion_city)->first()->id;
        $transport_type = Input::get('excursion_transport_type');

        $excursion_cart_key = $excursion_date . '_' . $excursion . '_' . $city_id . '_' . $excursion_transport;

        $excursion_details = array(
            'excursion' => $excursion,
            'excursion_city' => $excursion_city,
            'excursion_transport' => $excursion_transport,
            'transport_type' => $excursion_transport,
            'city_id' => $city_id,
            'excursion_pax' => $excursion_pax,
            'excursion_rate' => $excursion_rate,
            'excursion_total' => $excursion_total,
            'excursion_date' => $excursion_date,
            'excursion_cart_key' => $excursion_cart_key,
            'excursion_transport_type' => $transport_type
        );

        if (Session::has('excursion_cart_details')) {
            $data = Session::get('excursion_cart_details');
            $data[$excursion_cart_key] = $excursion_details;
        } else {
            $data = [];
            $data[$excursion_cart_key] = $excursion_details;
        }

        //$data['total_cost'] = $total_cost;

        Session::put('excursion_cart_details', $data);

        return Response::json(Session::get('excursion_cart_details'));

    }

    public function excursionCartItemDelete()
    {

        $deletable = Input::get('delete_excursion_cart_item');

        if (Session::has('excursion_cart_details')) {
            $data = Session::get('excursion_cart_details');
            //dd($data);
            unset($data[$deletable]);

            if (!empty($data)) {
                Session::put('excursion_cart_details', $data);
            } else {
                Session::forget('excursion_cart_details');
            }

        }

        return Redirect::to('/booking-cart');

    }

}