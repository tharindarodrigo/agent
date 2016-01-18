<?php

class RateInquiriesController extends \BaseController {

	/**
	 * Display a listing of rateinquiries
	 *
	 * @return Response
	 */
	public function index()
	{
		$rateinquiries = RateInquiry::all();

		return View::make('inquiries.rate-inquiries.index', compact('inquiries.rate-inquiries'));
	}

	/**
	 * Show the form for creating a new rateinquiry
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inquiries.rate-inquiries.create');
	}

	/**
	 * Store a newly created rateinquiry in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), RateInquiry::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		RateInquiry::create($data);

		return Redirect::route('inquiries.rate-inquiries.index');
	}

	/**
	 * Display the specified rateinquiry.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rateinquiry = RateInquiry::findOrFail($id);

		return View::make('inquiries.rate-inquiries.show', compact('rateinquiry'));
	}

	/**
	 * Show the form for editing the specified rateinquiry.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rateinquiry = RateInquiry::find($id);

		return View::make('inquiries.rate-inquiries.edit', compact('rateinquiry'));
	}

	/**
	 * Update the specified rateinquiry in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rateinquiry = RateInquiry::findOrFail($id);

		$validator = Validator::make($data = Input::all(), RateInquiry::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rateinquiry->update($data);

		return Redirect::route('inquiries.rate-inquiries.index');
	}

	/**
	 * Remove the specified rateinquiry from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		RateInquiry::destroy($id);

		return Redirect::route('inquiries.rate-inquiries.index');
	}

}
