<?php

class ClientsController extends \BaseController {



	/**
	 * Display a listing of clients
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients = Client::all();

		return View::make('clients.index', compact('clients'));
	}

	/**
	 * Show the form for creating a new client
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('clients.create');
	}

	/**
	 * Store a newly created client in storage.
	 *
	 * @return Response
	 */
	public function store($bookingId)
	{

        $user = Auth::user();

		$validator = Validator::make($data = Input::all(), Client::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $data['booking_id'] =$bookingId;

		if($bookingdata = Client::create($data)){
			$booking = Booking::getBookingData($bookingdata->booking_id);
			$pdf = PDF::loadView('emails/booking', array('booking' => $booking));
			$pdf->save(public_path() . '/temp-files/booking'.$booking->id.'.pdf');

			$emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
			$ehi_users = User::getEhiUsers();

			Mail::send('emails/booking-mail', array(
				'booking' => Booking::getBookingData($booking->id)
			), function ($message) use ($booking, $emails, $ehi_users) {
				$message->attach(public_path() . '/temp-files/booking'.$booking->id.'.pdf')
					->subject('Amended Booking(Client Added): ' . $booking->reference_number)
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

		return Redirect::route('bookings.show',$bookingId);
	}

	/**
	 * Display the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client = Client::findOrFail($id);

		return View::make('clients.show', compact('client'));
	}

	/**
	 * Show the form for editing the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::find($id);

		return View::make('clients.edit', compact('client'));
	}

	/**
	 * Update the specified client in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($bookingId,$id)
	{
		$client = Client::findOrFail($id);

        $data = [];
        $data['name'] = Input::get('name_'.$id);
        $data['passport_number'] = Input::get('passport_number_'.$id);
        $data['dob'] = Input::get('dob_'.$id);
        $data['gender'] =  Input::get('gender_'.$id);

		$validator = Validator::make($data, Client::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if($client->update($data)){
            Booking::emailBookingDetails($bookingId);
        }

		return Redirect::back();
	}

	/**
	 * Remove the specified client from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($bookingId,$id)
	{

		if(Client::destroy($id)){
			$booking = Booking::getBookingData($bookingId);
			$pdf = PDF::loadView('emails/booking', array('booking' => $booking));
			$pdf->save(public_path() . '/temp-files/booking'.$booking->id.'.pdf');

			$emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');
			$ehi_users = User::getEhiUsers();

			Mail::send('emails/booking-mail', array(
				'booking' => Booking::getBookingData($booking->id)
			), function ($message) use ($booking, $emails, $ehi_users) {
				$message->attach(public_path() . '/temp-files/booking'.$booking->id.'.pdf')
					->subject('Amended Booking (Client Removed): ' . $booking->reference_number)
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
