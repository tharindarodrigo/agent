<?php

class CartController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function bookingCart()
    {

        if (Session::has('rate_box_details')) {

            $bookings = Session::get('rate_box_details');
            $hotel_bookings = [];
           // dd($bookings);

            $rate_keys = array_keys($bookings);

            foreach ($rate_keys as $rate_key) {
                $hotel_id = explode('_', $rate_key)[0];

                $hotel_bookings[$hotel_id][] = $bookings[$rate_key];
                $hotel_bookings[$hotel_id]['hotel_name'] = $bookings[$rate_key]['hotel_name'];
                $hotel_bookings[$hotel_id]['hotel_address'] = $bookings[$rate_key]['hotel_address'];
                $hotel_bookings[$hotel_id]['room_identity'] = $bookings[$rate_key]['room_identity'];
            }
        } else {
            $hotel_bookings = '';
        }


        if ((Session::has('rate_box_details'))) {
            return View::make('reservations.booking_cart')
                ->with(
                    array(
                        'hotel_bookings' => $hotel_bookings,
                    )
                );
        } else {
            return Redirect::to('/403');
        }
    }


    public function bookingCart1()
    {

        if (Session::has('rate_box_details')) {

            $bookings = Session::get('rate_box_details');
            $hotel_bookings = [];

            $rate_keys = array_keys($bookings);
            $hotel_id_str = implode("_", $rate_keys);

            foreach ($rate_keys as $rate_key) {
                $hotel_id = explode('_', $rate_key)[2];

                if (strpos($hotel_id_str, $hotel_id) !== false) {

                    $hotel_bookings[$hotel_id][] = $bookings[$rate_key];
                    $hotel_bookings[$hotel_id]['hotel_name'] = $bookings[$rate_key]['hotel_name'];
                    $hotel_bookings[$hotel_id]['hotel_address'] = $bookings[$rate_key]['hotel_address'];
                    $hotel_bookings[$hotel_id]['hotel_id'] = $bookings[$rate_key]['hotel_id'];
                    Session::put('booking_cart', $hotel_bookings);
                    //dd($hotel_bookings);
                } else {
                    Session::put('booking_cart', Session::get('rate_box_details'));
                }

            }

            //Session::forget('booking_cart');
            //dd(Session::get('booking_cart'));

            $hotel_bookings = Session::get('booking_cart');

            return View::make('payments.booking_cart')
                ->with(compact('hotel_bookings'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function cartItemDelete()
    {

        $deletable = Input::get('delete_item');

        $hotel_id = explode('_', $deletable)[2];

        $bookings = Session::get('rate_box_details');
        $rate_keys = array_keys($bookings);

        for ($a = 0; $a < count($rate_keys); $a++) {

            $get_element_hotel_id = $rate_keys[$a];
            $element_hotel_id = explode('_', $get_element_hotel_id)[2];

            if ($element_hotel_id == $hotel_id) {

                if (Session::has('rate_box_details')) {
                    $data = Session::get('rate_box_details');
                    //dd($data);
                    //dd($data[$deletable]);
                    // dd($data[$hotel_id]);
                    unset($data[$get_element_hotel_id]);

                    if (!empty($data)) {
                        Session::put('rate_box_details', $data);
                    } else {
                        Session::forget('rate_box_details');
                    }
                }

            }

        }

        return Redirect::to('/booking-cart');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function singleCartItemDelete()
    {

        $deletable = Input::get('delete_single_item');

        if (Session::has('rate_box_details')) {
            $data = Session::get('rate_box_details');
            //dd($data[$deletable]);
            // dd($data[$hotel_id]);
            unset($data[$deletable]);

            if (!empty($data)) {
                Session::put('rate_box_details', $data);
            } else {
                Session::forget('rate_box_details');
            }
        }

        return Redirect::to('/booking-cart');

    }


    public function transportCartDelete()
    {

        $deletable = Input::get('delete_transport_item');

        if (Session::has('transport_cart_box')) {
            $data = Session::get('transport_cart_box');
            //dd($data[$deletable]);
            // dd($data[$hotel_id]);
            unset($data[$deletable]);

            if (!empty($data)) {
                Session::put('transport_cart_box', $data);
            } else {
                Session::forget('transport_cart_box');
            }

        }

        return Redirect::to('/booking-cart');

    }

    public function addToCart()
    {
        //Session::flush();

        $hotel_id = Input::get('hotel_id');

        $x = Session::pull('rate_box_details_' . $hotel_id);
        $y = Session::get('rate_box_details');

       // dd($y);

        if (Session::has('rate_box_details')) {
            Session::put('rate_box_details', $x + $y);
        } else {
            Session::put('rate_box_details', $x);
        }

        return Response::json(true);

    }

}
