<?php

class HsbcPaymentsController extends \BaseController {

	/**
	 * Display a listing of hsbcpayments
	 *
	 * @return Response
	 */
	public function index()
	{
		$hsbcpayments = Hsbcpayment::all();

		return View::make('hsbcpayments.index', compact('hsbcpayments'));
	}

	/**
	 * Show the form for creating a new hsbcpayment
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('hsbcpayments.create');
	}

	/**
	 * Store a newly created hsbcpayment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Hsbcpayment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Hsbcpayment::create($data);

		return Redirect::route('hsbcpayments.index');
	}

	/**
	 * Display the specified hsbcpayment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$hsbcpayment = Hsbcpayment::findOrFail($id);

		return View::make('hsbcpayments.show', compact('hsbcpayment'));
	}

	/**
	 * Show the form for editing the specified hsbcpayment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$hsbcpayment = Hsbcpayment::find($id);

		return View::make('hsbcpayments.edit', compact('hsbcpayment'));
	}

	/**
	 * Update the specified hsbcpayment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$hsbcpayment = Hsbcpayment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Hsbcpayment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$hsbcpayment->update($data);

		return Redirect::route('hsbcpayments.index');
	}

	/**
	 * Remove the specified hsbcpayment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Hsbcpayment::destroy($id);

		return Redirect::route('hsbcpayments.index');
	}

}
