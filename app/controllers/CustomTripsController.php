<?php

class CustomTripsController extends \BaseController
{

    /**
     * Display a listing of customtrips
     *
     * @return Response
     */
    public function index()
    {
        $customtrips = CustomTrip::all();

        return View::make('customtrips.index', compact('customtrips'));
    }

    /**
     * Show the form for creating a new customtrip
     *
     * @return Response
     */
    public function create()
    {
        return View::make('customtrips.create');
    }

    /**
     * Store a newly created customtrip in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), CustomTrip::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        CustomTrip::create($data);

        return Redirect::route('customtrips.index');
    }

    /**
     * Display the specified customtrip.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $customtrip = CustomTrip::findOrFail($id);

        return View::make('customtrips.show', compact('customtrip'));
    }

    /**
     * Show the form for editing the specified customtrip.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $customtrip = CustomTrip::find($id);

        return View::make('customtrips.edit', compact('customtrip'));
    }

    /**
     * Update the specified customtrip in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($bookingid, $id)
    {
        $customtrip = CustomTrip::findOrFail($id);
        $booking = Booking::getBookingData($bookingid);

        if (Input::has('val')) {
            if (Input::get('val') == 0) {
                $customtrip->amount = 0;
                $customtrip->val = 0;

                $customtrip->save();

//                $pdf = PDF::loadView('emails/transport-cancellation',
//                    array('customTrip' => $customtrip,
//                        'booking' => Booking::find($bookingid)
//                    )
//                );
            }

            $ehi_users = User::getEhiUsers();
            $pdf = PDF::loadView('emails/transport-cancellation',
                array(
                    'customTrip' => $customtrip,
                    'booking' => Booking::find($bookingid)
                )
            );

            $pdf->setPaper('a4')->save(public_path() . '/temp-files/transport-cancellation_' . $bookingid . '.pdf');


            //Cancellation email

            Mail::send('emails/transport-cancellation-mail', array(
                'customTrip' => $customtrip,
            ), function ($message) use ($customtrip, $ehi_users) {
                $message->attach(public_path() . '/temp-files/excursions.pdf')
                    ->subject('Cancel Transfer : ' . $customtrip->reference_number)
                    ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel');

                $message->to('transport@srilankahotels.travel', 'Transportation');
                $message->bcc('admin@srilankahotels.travel', 'Admin');
                if (!empty($ehi_users))
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
            });

            // Cancellation email

            Invoice::amendInvoice($booking);
            Booking::amendBooking($bookingid);

            // Service Voucher

            $pdf = PDF::loadView('emails/service-voucher', array('booking' => $booking));
            $pdf->setPaper('a4')->save(public_path() . '/temp-files/service_voucher_' . $booking->id . '.pdf');

            $ehi_users = User::getEhiUsers();
            //$booking = Booking::getBookingData($booking->id);

            Mail::send('emails/service-voucher-mail', array(
                'booking' => $booking
            ), function ($message) use ($booking, $ehi_users) {
                $message->attach(public_path() . '/temp-files/service_voucher_' . $booking->id . '.pdf')
                    ->subject('Amended Service Voucher: ' . $booking->reference_number)
                    ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'Admin');

                $message->to(Auth::user()->email, Auth::user()->first_name);

                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }

            });

            $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');

            $pdf = PDF::loadView('emails/booking', array('booking' => $booking));
            $pdf->save(public_path() . '/temp-files/booking_' . $booking->id . '.pdf');

            Mail::send('emails/booking-mail', array(
                'booking' => $booking
            ), function ($message) use ($booking, $emails, $ehi_users) {
                $message->attach(public_path() . '/temp-files/booking_' . $booking->id . '.pdf')
                    ->subject('Amended Booking: ' . $booking->reference_number)
                    ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'Admin');
//                foreach ($emails as $emailaddress) {
//                    $message->to($emailaddress, 'Admin');
//                }

                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }

            });

            $pdf = PDF::loadView('emails/invoice', array('booking' => $booking));
            $pdf->save(public_path() . '/temp-files/invoice_' . $booking->id . '.pdf');

            Mail::send('emails/invoice-mail', array(
                'booking' => $booking
            ), function ($message) use ($booking, $emails, $ehi_users) {
                $message->attach(public_path() . '/temp-files/invoice_' . $booking->id . '.pdf')
                    ->subject('Amended Invoice: ' . $booking->reference_number)
                    ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'Admin');
//                foreach ($emails as $emailaddress) {
//                    $message->bcc($emailaddress, 'SysAdmin');
//                }

                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }

            });

            return Redirect::back();
        }

        $validator = Validator::make($data = Input::all(), CustomTrip::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $customtrip->update($data);

        return Redirect::back();
    }

    /**
     * Remove the specified customtrip from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        CustomTrip::destroy($id);
        return Redirect::route('customtrips.index');
    }

}
