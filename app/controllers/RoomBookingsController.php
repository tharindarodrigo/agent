<?php

class RoomBookingsController extends \BaseController {

	/**
	 * Display a listing of roombookings
	 *
	 * @return Response
	 */
	public function index()
	{
		$roombookings = RoomBooking::all();

		return View::make('roombookings.index', compact('roombookings'));
	}

	/**
	 * Show the form for creating a new roombooking
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('roombookings.create');
	}

	/**
	 * Store a newly created roombooking in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), RoomBooking::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		RoomBooking::create($data);

		return Redirect::route('roombookings.index');
	}

	/**
	 * Display the specified roombooking.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$roombooking = RoomBooking::findOrFail($id);

		return View::make('roombookings.show', compact('roombooking'));
	}

	/**
	 * Show the form for editing the specified roombooking.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$roombooking = RoomBooking::find($id);

		return View::make('roombookings.edit', compact('roombooking'));
	}

	/**
	 * Update the specified roombooking in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$roombooking = RoomBooking::findOrFail($id);

		$validator = Validator::make($data = Input::all(), RoomBooking::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$roombooking->update($data);

		return Redirect::route('roombookings.index');
	}

	/**
	 * Remove the specified roombooking from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		RoomBooking::destroy($id);

		return Redirect::route('roombookings.index');
	}

}
