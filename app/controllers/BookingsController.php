<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookingsController extends \BaseController
{

    private $_user;

    public function __construct()
    {
        $this->_user = Auth::user();
//        $this->beforeFilter('agent', array('except' => 'create'));
    }

    /**
     * Display a listing of bookings
     *
     * @return Response
     */

    public function index()
    {

        $reference_number = Input::has('reference_number') ? Input::get('reference_number') : '%';


        if (Entrust::hasRole('Admin')) {

            $user_id = Input::has('agent_id')? Input::get('agent_id') : '%';

            $bookings = Booking::whereHas('user', function ($q) use ($user_id) {
                $q->where('users.id', 'like', $user_id);
            })->where('reference_number', 'like', '%' . $reference_number . '%');

        } else {

            $bookings = Booking::whereHas('user', function ($q) {
                $q->where('users.id', $this->_user->id);
            })->where('reference_number', 'like', '%' . $reference_number . '%');
        }

        //return View::make('bookings.index', compact('bookings'));

        if (Input::get('search')) {



            $status = Input::get('status');


            switch ($status) {
                case '0':
                    $val = '%';
                    break;

                case '1':
                    $val = '1';
                    break;

                case '2':
                    $val = '0';
                    break;

            }

            $from = Input::get('from');
            $to = Input::get('to');
            $tour_type = Input::get('tour_type');


            switch ($tour_type) {
                case '0':
                    $tour_type = '0';
                    $tour = 'arrival_date';
                    break;

                case '1':
                    $tour_type = '1';
                    $tour = 'departure_date';
                    break;
            }

            $bookings = $bookings
                ->where($tour, '>=', $from)
                ->where($tour, '<=', $to)
                ->where('val', 'LIKE', $val);
        }

        $bookings = $bookings->get();


        return View::make('bookings.index', compact('bookings', 'from', 'to', 'tour_type', 'status', 'agent_id', 'user_id'));
    }

    //this should be deleted
    public function getSearchedBookings()
    {
        /*
        if (Auth::check()) {

            $reference_number = Input::has('reference_number') ? Input::get('reference_number') : null;
            if (Input::has('reference_number') && (!Input::has('arrival_date') || !Input::has('arrival_date'))) {
                if (Entrust::hasRole('Admin')) {
                    $bookings = Booking::with('user')
                        ->where('reference_number', '=', $reference_number)
                        ->get();
                } else {
                    $bookings = Booking::whereHas('user', function ($q) {
                        $q->where('users.id', $this->_user->id);
                    })->where('reference_number', '=', $reference_number)
                        ->get();

                }
            } elseif (!Input::has('reference_number') && ($arrival_date = Input::has('arrival_date') && $departure_date = Input::has('arrival_date'))) {
                if (Entrust::hasRole('Admin')) {
                    $bookings = Booking::with('user')
                        ->where('arrival_date', '=', $arrival_date)
                        ->where('departure_date', '=', $departure_date)
                        ->get();
                } else {
                    $bookings = Booking::whereHas('user', function ($q) {
                        $q->where('users.id', $this->_user->id);
                    })
                        ->where('arrival_date', '=', $arrival_date)
                        ->where('departure_date', '=', $departure_date)
                        ->get();
                }
            } elseif (Input::has('reference_number') && Input::has('arrival_date') && Input::has('arrival_date')) {
                if (Entrust::hasRole('Admin')) {
                    $bookings = Booking::with('user')
                        ->where('reference_number', '=', $reference_number)
                        ->where('arrival_date', '=', $arrival_date)
                        ->where('departure_date', '=', $departure_date)
                        ->get();
                } else {
                    $bookings = Booking::whereHas('user', function ($q) {
                        $q->where('users.id', $this->_user->id);
                    })->where('reference_number', '=', $reference_number)
                        ->where('arrival_date', '=', $arrival_date)
                        ->where('departure_date', '=', $departure_date)
                        ->get();
                }

            } elseif (!Input::has('reference_number') && !Input::has('arrival_date') && !Input::has('arrival_date')) {


                if (Entrust::hasRole('Admin')) {
                    $bookings = Booking::with('user')->get();
                } else {
                    $bookings = Booking::whereHas('user', function ($q) {
                        $q->where('users.id', $this->_user->id);
                    })->get();
                }
            }

            return View::make('bookings.index', compact('bookings'));
        }*/
    }

    /**
     * Show the form for creating a new booking
     *
     * @return Response
     */
    public function create()
    {

        return View::make('bookings.create');

        Session::put('rate_box_details', '');

        if (Session::has('rate_box_details')) {

            $bookings = Session::get('rate_box_details');
            $hotel_bookings = [];
            $rate_keys = array_keys($bookings);

            foreach ($rate_keys as $rate_key) {
                $hotel_id = explode('_', $rate_key)[2];

                $hotel_bookings[$hotel_id][] = $bookings[$rate_key];
                $hotel_bookings[$hotel_id]['hotel_name'] = $bookings[$rate_key]['hotel_name'];
                $hotel_bookings[$hotel_id]['hotel_address'] = $bookings[$rate_key]['hotel_address'];
                $hotel_bookings[$hotel_id]['room_identity'] = $bookings[$rate_key]['room_identity'];
            }

        } else {
            $hotel_bookings = '';
        }


        // For Create My Trip Transport

        if (Session::has('transport_cart_box')) {
            $transport_bookings = Session::get('transport_cart_box');
        } else {
            $transport_bookings = '';
        }


        // For Predefined Transport

        if (Session::has('predefined_transport')) {
            $predefined_transports = Session::get('predefined_transport');
        } else {
            $predefined_transports = '';
        }


        // For Excursion

        if (Session::has('excursion_cart_details')) {
            $excursion_cart_details = Session::get('excursion_cart_details');
        } else {
            $excursion_cart_details = '';
        }


        if (Session::has('rate_box_details') || Session::has('transport_cart_box') || Session::has('predefined_transport') || Session::has('excursion_cart_details'))
            return View::make('bookings.create')
                ->with(
                    array(
                        'hotel_bookings' => $hotel_bookings,
                        'predefined_transport' => $predefined_transports,
                        'transport_bookings' => $transport_bookings,
                        'excursion_cart_details' => $excursion_cart_details,
                    )
                );

        return Redirect::to('/');

    }

    /**
     * Store a newly created booking in storage.
     * This includes Clients, FlightDetails
     *
     * @return Response
     */
    public function store()
    {

        if (Auth::check()) {
            $user = Auth::user();
            if (Entrust::hasRole('Agent')) {
                $rules = Booking::$agentRules;
            }
        } else {
            $rules = Booking::$guestRules;
        }

        $data = Input::all();

        if (Auth::check())
            $data['user_id'] = Auth::id();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            //dd($validator->errors());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['val'] = 1;

        if ($x = Booking::find(Booking::max('id'))) {
            $data['reference_number'] = ++$x->reference_number;
        } else {
            $data['reference_number'] = 10000000;
        }

        Session::put('MyBookingData', $data);

        $clients = null;

        $newBooking = $this->storeAllData();

        $data = array(
            'details' => $newBooking->booking_name,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            //'reference_number' => $reference_number,
            'amount' => Booking::getTotalBookingAmount($newBooking),
            'payment_status' => 0,
            'my_booking' => 2,
        );
        $reserv_id = Payment::create($data);

        $data_tab_HSBC_payment = array(
            'currency' => 'USD',
            // 'reference_number' => $reference_number,
        );
        $tab_HSBC_payment_id = HsbcPayment::create($data_tab_HSBC_payment);


        $stamp = strtotime("now");

        $payment_id = Payment::orderBy('created_at', 'desc')->first()->id;
        $orderid = "$stamp" . 'A' . "$payment_id";
        $last_res_resid = str_replace(".", "", $orderid);

        $hsbc_id = HsbcPayment::orderBy('created_at', 'desc')->first()->id;
        $hsbc_payment_id_pre = "$stamp" . 'HSBC' . "$hsbc_id";
        $hsbc_payment_id = str_replace(".", "", $hsbc_payment_id_pre);


        if ($last_res_resid) {

            $payment = DB::table('payments')
                ->where('id', $payment_id)
                ->update(
                    array(
                        'reference_number' => $last_res_resid,
                        'HSBC_payment_id' => $hsbc_payment_id
                    )
                );


            $data_tab_HSBC_payment = DB::table('hsbc_payments')
                ->where('id', $hsbc_id)
                ->update(
                    array(
                        'HSBC_payment_id' => $hsbc_payment_id
                    )
                );

        }

        $currency = 'USD';
        //$x = Booking::getTotalBookingAmount($newBooking) * 100 * 1.037;
        $x = 2 * 100 * 1.037;
        $total_price_all_hsbc = round($x, 2);

//        dd($hsbc_payment_id . '/' . $currency . '/' . $total_price_all_hsbc . '/' . $last_res_resid);

        HsbcPayment::goto_hsbc_gateway($hsbc_payment_id, $currency, $total_price_all_hsbc, $last_res_resid);

    }

    public function storeAllData()
    {

        $data = Session::pull('MyBookingData');

        if (Session::has('rate_box_details') || Session::has('transport_cart_box') || Session::has('predefined_transport') || Session::has('excursion_cart_details')) {


            if ($booking = Booking::create($data)) {

                $ehi_users = User::getEhiUsers();

                if (Auth::check()) {
                    //DB::table('booking_user')->insert(array('booking_id' => $booking->id, 'user_id' => $user->id));
                    if (Session::has('client-list')) {
                        $clients = Session::pull('client-list');

                        foreach ($clients as $client) {
                            $client['booking_id'] = $booking->id;
                            $client['gender'] === 'male' ? $client['gender'] = 1 : $client['gender'] = 0;
                            Client::create($client);
                        }
                    }

                    $flight_data = [];
                    $flight_data['booking_id'] = $booking->id;

                    $flight_data['date'] = $data['date_arrival'];
                    $flight_data['time'] = $data['arrival_time'];
                    $flight_data['flight'] = $data['arrival_flight'];
                    $flight_data['flight_type'] = 1;

                    FlightDetail::create($flight_data);

                    //departure flight data
                    $flight_data['date'] = $data['date_departure'];
                    $flight_data['time'] = $data['departure_time'];
                    $flight_data['flight'] = $data['departure_flight'];
                    $flight_data['flight_type'] = 0;

                    FlightDetail::create($flight_data);
                }

                /**
                 *  transport - custom trips
                 */

                $a = 0;

                if (Session::has('transport_cart_box')) {

                    $custom_trips = Session::pull('transport_cart_box');
                    $a++;

                    $x = 1;
                    foreach ($custom_trips as $custom_trip) {

                        $custom_trip['from'] = date('Y-m-d H:i', strtotime($custom_trip['pick_up_date'] . ' ' . $custom_trip['pick_up_time_hour'] . ':' . $custom_trip['pick_up_time_minutes']));
                        $custom_trip['to'] = date('Y-m-d H:i', strtotime($custom_trip['drop_off_date'] . ' ' . $custom_trip['drop_off_time_hour'] . ':' . $custom_trip['drop_off_time_minutes']));
                        $custom_trip['reference_number'] = 'TR' . ($booking->reference_number * 1000 + $x++);
                        $custom_trip['booking_id'] = $booking->id;
                        $custom_trip['locations'] = $custom_trip['destination_1'] . ',' . $custom_trip['destination_2'] or '' . ',' . $custom_trip['destination_3'];
                        $custom_trip['amount'] = rand(100, 200);

                        CustomTrip::create($custom_trip);
                    }
                }

                /**
                 *  predefined package bookings
                 */

                if (Session::has('predefined_transport')) {

                    $a++;

                    $predefined_packages = Session::pull('predefined_transport');
                    foreach ($predefined_packages as $predefined_package) {
                        $package = [];
                        $package['transport_package_id'] = $predefined_package['predefine_id'];
                        $package['booking_id'] = $booking->id;
                        $package['pick_up_date_time'] = $predefined_package['check_in_date'];
                        $package['amount'] = TransportPackage::find($predefined_package['predefine_id'])->rate;
                        PredefinedTrip::create($package);
                    }
                }


                /**
                 * Send Transportation Email to All EHI users
                 */

                $pdf = PDF::loadView('emails/transport', array('booking' => $booking));
                $pdf->save('public/temp-files/transport' . $booking->id . '.pdf');

//                if ($a > 0) {
//                    Mail::send('emails/transport-mail', array(
//                        'booking' => Booking::find($booking->id)
//                    ), function ($message) use ($booking, $ehi_users) {
//                        $message->attach('public/temp-files/transport.pdf')
//                            ->subject('New Transfer : ' . $booking->reference_number)
//                            ->from('transport@srilankahotels.travel', 'SriLankaHotels.Travel')
//                            ->bcc('admin@srilankahotels.travel');
//                        if (!empty($ehi_users))
//                            foreach ($ehi_users as $ehi_user) {
//                                $message->to($ehi_user->email, $ehi_user->first_name);
//                            }
//                    });
//                }


                /**
                 * Excursions
                 */

                if (Session::has('excursion_cart_details')) {
                    $excursions = Session::pull('excursion_cart_details');
                    $x = 1;
                    foreach ($excursions as $excursion) {
                        $excursionBooking = ExcursionRate::with(array('city', 'excursion', 'excursionTransportType'))
                            ->where('city_id', $excursion['city_id'])
                            ->where('excursion_transport_type_id', $excursion['excursion_transport_type'])
                            ->where('excursion_id', $excursion['excursion'])
                            ->first();
                        $excursionBookingData = array(
                            'booking_id' => $booking->id,
                            'city_id' => $excursionBooking->city_id,
                            'excursion_transport_type_id' => $excursionBooking->excursion_transport_type_id,
                            'excursion_id' => $excursionBooking->excursion_id,
                            'unit_price' => $excursionBooking->rate,
                            'pax' => $excursion['excursion_pax'],
                            'date' => $excursion['excursion_date'],
                            'reference_number' => 'EX' . ($booking->reference_number * 1000 + $x++)
                        );

                        ExcursionBooking::create($excursionBookingData);

                    }

                    $pdf = PDF::loadView('emails/excursion', array('booking' => $booking));
                    $pdf->save('public/temp-files/excursions.pdf');

//                    Mail::send('emails/excursion-mail', array(
//                        'booking' => $booking
//                    ), function ($message) use ($booking, $ehi_users) {
//                        $message->attach('public/temp-files/excursions.pdf')
//                            ->subject('New Excursions : ' . $booking->reference_number)
//                            ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel');
//
//                        $message->to('excursions@srilankahotels.travel', 'Excursions');
//                        $message->bcc('admin@srilankahotels.travel', 'Admin');
//                        if (!empty($ehi_users))
//                            foreach ($ehi_users as $ehi_user) {
//                                $message->to($ehi_user->email, $ehi_user->first_name);
//                            }
//                    });
                }


                /**
                 *  hotel bookings
                 */

                if (Session::has('rate_box_details')) {
                    $bookings = Session::pull('rate_box_details');

                    $vouchers = Voucher::arrangeHotelBookingsVoucherwise($bookings, $booking->id);

                    foreach ($vouchers as $voucher) {
                        $created_voucher = Voucher::create($voucher);

                        for ($c = 0; $c < count($voucher) - 6; $c++) {

                            $voucher[$c]['voucher_id'] = $created_voucher->id;

                            $RoomBooking = RoomBooking::create($voucher[$c]);

                        }

                        // voucher

                        $pdf = PDF::loadView('emails/voucher', array('voucher' => $created_voucher));
                        $pdf->save('public/temp-files/voucher' . $created_voucher->id . '.pdf');

//                        $hotel_users = DB::table('users')->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
//                            ->where('hotel_user.hotel_id', $created_voucher->hotel_id)
//                            ->get();
//
//                        Mail::send('emails/voucher-mail', array(
//                            'voucher' => Voucher::find($created_voucher->id)
//                        ), function ($message) use ($booking, $hotel_users,$created_voucher) {
//                            $message->attach('public/temp-files/voucher'.$created_voucher->id.'.pdf')
//                                ->subject('Booking Voucher : ' . $booking->reference_number)
//                                ->from('reservations@srilankahotels.travel', 'SriLankaHotels.Travel')
//                                ->bcc('admin@srilankahotels.travel', 'SriLankaHotels.Travel');
//                            if (!empty($hotel_users))
//                                foreach ($hotel_users as $hotel_user) {
//                                    $message->to($hotel_user->email, $hotel_user->first_name);
//                                }
//                        });
                    }
                }

                //Booking details

//                $pdf = PDF::loadView('emails/booking', array('booking' => $booking));
//                $pdf->save('public/temp-files/booking'.$booking->id.'.pdf');
//
                $ehi_users = User::getEhiUsers();
//
                $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
//
//                Mail::send('emails/booking-mail', array(
//                    'booking' => Booking::getBookingData($booking->id)
//                ), function ($message) use ($booking, $emails, $ehi_users) {
//                    $message->attach('public/temp-files/booking'.$booking->id.'.pdf')
//                        ->subject('New Booking: ' . $booking->reference_number)
//                        ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
//                        ->bcc('admin@srilankahotels.travel', 'Admin');
//                    foreach ($emails as $emailaddress) {
//                        $message->to($emailaddress, 'Admin');
//                    }
//
//                    if (!empty($ehi_users)) {
//                        foreach ($ehi_users as $ehi_user) {
//                            $message->to($ehi_user->email, $ehi_user->first_name);
//                        }
//                    }
//                });


                Invoice::create(
                    array(
                        'booking_id' => $booking->id,
                        'amount' => Booking::getTotalBookingAmount($booking),
                        'count' => 1
                    )
                );


                //Invoice
                $pdf = PDF::loadView('emails/invoice', array('booking' => $booking));
                $pdf->save('public/temp-files/invoice' . $booking->id . '.pdf');
                $pdf = PDF::loadView('emails/service-voucher', array('booking' => $booking));
                $pdf->save('public/temp-files/service-voucher.pdf');

//                if ($user = $booking->user) {
//                    Mail::send('emails/invoice-mail', array(
//                        'booking' => Booking::getBookingData($booking->id)
//                    ), function ($message) use ($user, $booking, $emails) {
//                        $message->subject('Booking Invoice : ' . $booking->reference_number)
//                            ->attach('public/temp-files/invoice'.$booking->id.'.pdf');
//                        $message->to($user->email, $user->first_name . ' ' . $user->last_name);
//                        $message->to('accounts@srilankahotels.travel', 'Accounts');
//                        if (!empty($ehi_users)) {
//                            foreach ($ehi_users as $ehi_user) {
//                                $message->to($ehi_user->email, $ehi_user->first_name);
//                            }
//                        }
//
//                    });
//
//                } else {
//
//                    Mail::send('emails/invoice-mail', array(
//                        'booking' => Booking::getBookingData($booking->id)
//                    ), function ($message) use ($booking, $emails) {
//                        $message->to($booking->email, $booking->name)
//                            ->subject('Booking Created : ' . $booking->reference_number)
//                            ->attach('public/temp-files/invoice'.$booking->id.'.pdf');
//                        $message->to('accounts@srilankahotels.travel', 'Accounts');
//                        if (!empty($ehi_users)) {
//                            foreach ($ehi_users as $ehi_user) {
//                                $message->to($ehi_user->email, $ehi_user->first_name);
//                            }
//                        }
//                    });
//                }

                if (!Auth::check()) {
                    Session::flash('global', 'Emails have been sent to the Respective parties');
                    return View::make('pages.message');
                }
            }

            return $booking;

        } else {
            return Redirect::back();
        }

        return Redirect::route('bookings.index');
    }


    /**
     * Display the specified booking.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

        try {
            $booking = Booking::with('voucher')->with('client')->with('flightDetail')->where('id', $id)->first();
        } catch (ModelNotFoundException $e) {
            return Redirect::to('/404');
        }


        return View::make('bookings.show', compact('booking', 'clients', 'flightDetails', 'vouchers'));
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $booking = Booking::find($id);

        return View::make('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $booking = Booking::findOrFail($id);

        if (Input::has('val')) {
            $rules = ['val'];
            //dd('<pre>',Booking::with('Voucher')->where('id',$id)->first(), '</pre>');

            $bookingVouchers = Booking::whereHas('Voucher', function ($q) {
                $q->where('vouchers.val', 1);
            })->where('id', $id);

            //dd($booking->count());

            if ($bookingVouchers->count() > 0) {
                Session::flash("booking_cancellation_error_" . $id, "<b>Sorry</b>, You cannot cancel the above booking! You have " . $booking->first()->voucher->count() . " active vouchers");

            } else {
                $booking->update(array('val' => Input::get('val')));
                Session::flash('success', 'successfully Updated');

            }
            return Redirect::back();
        }

        $validator = Validator::make($data = Input::all(), Booking::$agentRules);

        if ($validator->fails()) {
            //dd($validator->errors());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['user_id'] = Auth::id();

        $booking->update($data);

        return Redirect::back();

    }

    /**
     * Remove the specified booking from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Booking::destroy($id);

        return Redirect::route('bookings.index');
    }

    /**
     * Client-List Functions
     */


    public
    function addClient()
    {
        $input = Input::all();

        if (Session::has('client-list')) {
            $data = Session::get('client-list');
            $data[] = $input;
            Session::put('client-list', $data);

        } else {
            $data = [];
            $data[] = $input;
            Session::put('client-list', $data);
        }

        return Response::json(Session::get('client-list'));
    }

    public
    function destroyClient()
    {
        $deletable = Input::get('deletable');

        if (Session::has('client-list')) {
            $data = Session::get('client-list');
            unset($data[$deletable]);

            Session::put('client-list', $data);
        }

        return Response::json(Session::get('client-list'));
    }

    public
    function getClientList()
    {
        return Response::json(Session::get('client-list'));
    }

    public
    function cancelBooking()
    {
        Session::forget('add_new_voucher');
        Session::forget('rate_box_details');
        Session::forget('transport_cart_box');
        Session::forget('');
        return Redirect::to('/');
    }

    public
    function sendBookingEmails($booking)
    {
        $ehi_users = User::getEhiUsers();

        Mail::send('emails/transport-mail', array(
            'booking' => Booking::find($booking->id)
        ), function ($message) use ($booking, $ehi_users) {
            $message->attach('public/temp-files/transport.pdf')
                ->subject('New Transfer : ' . $booking->reference_number)
                ->from('transport@srilankahotels.travel', 'SriLankaHotels.Travel')
                ->bcc('admin@srilankahotels.travel');
            if (!empty($ehi_users))
                foreach ($ehi_users as $ehi_user) {
                    $message->to($ehi_user->email, $ehi_user->first_name);
                }
        });


        /**
         * Excursions
         */
        if ($booking->excursion->count()) {
            Mail::send('emails/excursion-mail', array(
                'booking' => $booking
            ), function ($message) use ($booking, $ehi_users) {
                $message->attach('public/temp-files/excursions.pdf')
                    ->subject('New Excursions : ' . $booking->reference_number)
                    ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel');

                $message->to('excursions@srilankahotels.travel', 'Excursions');
                $message->bcc('admin@srilankahotels.travel', 'Admin');
                if (!empty($ehi_users))
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
            });
        }

        /**
         * Hotel Vouchers
         */

        $vouchers = $booking->voucher;

        foreach ($vouchers as $voucher) {
            $hotel_users = DB::table('users')->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
                ->where('hotel_user.hotel_id', $voucher->hotel_id)
                ->get();

            Mail::send('emails/voucher-mail', array(
                'voucher' => $voucher
            ), function ($message) use ($booking, $hotel_users, $voucher) {
                $message->attach('public/temp-files/voucher' . $voucher->id . '.pdf')
                    ->subject('Booking Voucher : ' . $booking->reference_number)
                    ->from('reservations@srilankahotels.travel', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'SriLankaHotels.Travel');
                if (!empty($hotel_users))
                    foreach ($hotel_users as $hotel_user) {
                        $message->to($hotel_user->email, $hotel_user->first_name);
                    }
            });
        }

        /**
         * Bookings
         */

        $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');

        Mail::send('emails/booking-mail', array(
            'booking' => Booking::getBookingData($booking->id)
        ), function ($message) use ($booking, $emails, $ehi_users) {
            $message->attach('public/temp-files/booking' . $booking->id . '.pdf')
                ->subject('New Booking: ' . $booking->reference_number)
                ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
                ->bcc('admin@srilankahotels.travel', 'Admin');
            foreach ($emails as $emailaddress) {
                $message->to($emailaddress, 'Admin');
            }

            if (!empty($ehi_users)) {
                foreach ($ehi_users as $ehi_user) {
                    $message->to($ehi_user->email, $ehi_user->first_name);
                }
            }
        });

        /**
         * Invoice
         *
         *
         * Logged user
         */
        if ($user = $booking->user) {
            Mail::send('emails/invoice-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($user, $booking, $emails) {
                $message->subject('Booking Invoice : ' . $booking->reference_number)
                    ->attach('public/temp-files/invoice' . $booking->id . '.pdf');
                $message->to($user->email, $user->first_name . ' ' . $user->last_name);
                $message->to('accounts@srilankahotels.travel', 'Accounts');
                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }

            });

        } else {

            /**
             * Invoice
             * Guest User
             */

            Mail::send('emails/invoice-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($booking, $emails) {
                $message->to($booking->email, $booking->name)
                    ->subject('Booking Created : ' . $booking->reference_number)
                    ->attach('public/temp-files/invoice' . $booking->id . '.pdf');
                $message->to('accounts@srilankahotels.travel', 'Accounts');
                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }
            });
        }
    }

}
