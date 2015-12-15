<?php

class VouchersController extends \BaseController
{

    /**
     * Display a listing of vouchers
     *
     * @return Response
     */
    public function index()
    {
        $vouchers = Voucher::all();

        return View::make('vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new voucher
     *
     * @return Response
     */
    public function create($booking_id)
    {
        Session::put('add_new_voucher', $booking_id);
        return Redirect::to('/');
    }

    /**
     * Store a newly created voucher in storage.
     *
     * @return Response
     */
    public function store($booking_id)
    {
        $bookings = Session::pull('rate_box_details');

        $vouchers = Voucher::arrangeHotelBookingsVoucherwise($bookings, $booking_id);

        foreach ($vouchers as $voucher) {
            $create_voucher = Voucher::create($voucher);

            for ($c = 0; $c < count($voucher) - 6; $c++) {

                $voucher[$c]['voucher_id'] = $create_voucher->id;
                $voucher[$c]['amount'] = $voucher[$c]['room_cost'];
                RoomBooking::create($voucher[$c]);
            }
        }

        Session::forget('add_new_voucher');


//        Booking::where('id', $booking_id)->update('user_id', Auth::user()->id);

//		$validator = Validator::make($data = Input::all(), Voucher::$rules);
//
//		if ($validator->fails())
//		{
//			return Redirect::back()->withErrors($validator)->withInput();
//		}
//
//		Voucher::create($data);

        return Redirect::route('bookings.show', [$booking_id]);
    }

    /**
     * Display the specified voucher.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $voucher = Voucher::findOrFail($id);

        return View::make('vouchers.show', compact('voucher'));
    }

    /**
     * Show the form for editing the specified voucher.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $voucher = Voucher::find($id);

        return View::make('vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified voucher in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $voucher = Voucher::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Voucher::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $voucher->update($data);

        return Redirect::route('vouchers.index');
    }

    /**
     * Remove the specified voucher from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Voucher::destroy($id);

        return Redirect::route('vouchers.index');
    }

    public function cancelVoucher($voucherid)
    {
        $percentage_charged = 0;
        $voucher = Voucher::findOrFail($voucherid);

        $daysToBooking = Voucher::getDaysToBooking($voucher)->days;
        $cancellation_policies = CancellationPolicy::where('hotel_id', $voucher->hotel_id)->get();
        foreach ($cancellation_policies as $policy) {

            if ($daysToBooking >= $policy->from && $daysToBooking <= $policy->to) {
                $percentage_charged = $policy->percentage_charged;
                break;
            } else {
                if (empty($policy->to)) {
                    $percentage_charged = $policy->percentage_charged;
                    break;
                }
            }
        }

        $bookingAmount = Voucher::getVoucherAmount($voucher);

        $cancellation_amount = $bookingAmount * $percentage_charged * 0.01;

        $voucher->val = 0;
        $voucher->cancellation_amount = $cancellation_amount;
        $voucher->save();

        $agent_user = $voucher->booking->user;

        $pdf = PDF::loadView('emails/cancellation-voucher', array('voucher' => $voucher));
        $pdf->save(public_path() . '/temp-files/cancellation-voucher.pdf');

        $hotel = Hotel::findOrFail($voucher->hotel_id);

        $hotel_users = $hotel->user;

        Mail::send('emails/cancellation-voucher-mail', array(
            'voucher' => $voucher
        ), function ($message) use ($voucher, $agent_user, $hotel_users) {
            $message->attach(public_path() . '/temp-files/cancellation-voucher.pdf')
                ->subject('Cancellation Voucher :' . $voucher->reference_number)
                ->from('reservations@srilankahotels.travel');
            if (!empty($hotel_users))
                foreach ($hotel_users as $hotel_user) {
                    $message->to($hotel_user->email, $hotel_user->first_name);
                }
            if (!empty($agent_user)) {
                $message->to($agent_user->email, $agent_user->first_name);
            }
        });

        Booking::getTotalBookingAmount($voucher->booking);

        return Redirect::back();
    }

}
