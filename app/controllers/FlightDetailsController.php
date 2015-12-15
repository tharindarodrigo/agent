<?php

class FlightDetailsController extends \BaseController
{

    /**
     * Display a listing of flightdetails
     *
     * @return Response
     */
    public function index()
    {
        $flightdetails = FlightDetail::all();

        return View::make('flightdetails.index', compact('flightdetails'));
    }

    /**
     * Show the form for creating a new flightdetail
     *
     * @return Response
     */
    public function create()
    {
        return View::make('flightdetails.create');
    }

    /**
     * Store a newly created flightdetail in storage.
     *
     * @return Response
     */
    public function store($bookingId)
    {
        $user = Auth::user();

        Session::flash('bookings_show_tabs', 'flight-details-tab');
        $validator = Validator::make($data = Input::all(), FlightDetail::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['booking_id'] = $bookingId;

        if (FlightDetail::create($data)) {
            $booking = Booking::getBookingData($bookingId);
            $pdf = PDF::loadView('emails/booking', array('booking' => $booking));
            $pdf->save(public_path() . '/temp-files/booking' . $booking->id . '.pdf');

            $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
            $ehi_users = User::getEhiUsers();

            Mail::send('emails/booking-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($booking, $emails, $ehi_users) {
                $message->attach(public_path() . '/temp-files/booking' . $booking->id . '.pdf')
                    ->subject('Amended Booking(Flight Info Added): ' . $booking->reference_number)
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
        }

        return Redirect::back();
    }

    /**
     * Display the specified flightdetail.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $flightdetail = FlightDetail::findOrFail($id);

        return View::make('flightdetails.show', compact('flightdetail'));
    }

    /**
     * Show the form for editing the specified flightdetail.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $flightdetail = FlightDetail::find($id);

        return View::make('flightdetails.edit', compact('flightdetail'));
    }

    /**
     * Update the specified flightdetail in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($bookingId, $id)
    {
        $user = Auth::user();

        Session::flash('bookings_show_tabs', 'flight-details-tab');

        $flightdetail = FlightDetail::findOrFail($id);

        $data = [];

        $data['date'] = Input::get('date_' . $id);
        $data['time'] = Input::get('time_' . $id);
        $data['flight'] = Input::get('flight_' . $id);
        $data['flight_type'] = Input::get('flight_type_' . $id);

        $validator = Validator::make($data, FlightDetail::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        if ($flightdetail->update($data)) {

            $booking = Booking::getBookingData($bookingId);

            $Currentbooking = Booking::findOrFail($bookingId);
            $Currentbooking->count = $Currentbooking->count++;
            $Currentbooking->save();

            $pdf = PDF::loadView('emails/booking', array('booking' => $booking));
            $pdf->save(public_path() . '/temp-files/booking' . $booking->id . '.pdf');

            $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
            $ehi_users = User::getEhiUsers();

            Mail::send('emails/booking-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($booking, $emails, $ehi_users) {
                $message->attach(public_path() . '/temp-files/booking' . $booking->id . '.pdf')
                    ->subject('Amended Booking(Flight Info Deleted): ' . $booking->reference_number)
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
        };

        return Redirect::back();
    }

    /**
     * Remove the specified flightdetail from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($bookingId, $id)
    {
        $user = Auth::user();
        Session::flash('bookings_show_tabs', 'flight-details-tab');
        if (FlightDetail::destroy($id)) {
            $booking = Booking::getBookingData($bookingId);

            $Currentbooking = Booking::first($bookingId);
            $Currentbooking->count = $Currentbooking->count++;
            $Currentbooking->save();

            $pdf = PDF::loadView('emails/booking', array('booking' => $booking));
            $pdf->save(public_path() . '/temp-files/booking' . $booking->id . '.pdf');

            $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
            $ehi_users = User::getEhiUsers();

            Mail::send('emails/booking-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($booking, $emails, $ehi_users) {
                $message->attach(public_path() . '/temp-files/booking' . $booking->id . '.pdf')
                    ->subject('Amended Booking(Flight Info Deleted): ' . $booking->reference_number)
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
        }

        return Redirect::back();
    }

}
