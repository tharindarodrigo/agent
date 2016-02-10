<?php

class RateInquiriesController extends \BaseController
{

    /**
     * Display a listing of rateinquiries
     *
     * @return Response
     */
    public function index()
    {

        RateInquiry::where('viewed', 0)->where('status', 1)->update(array('viewed'=> 1));

        $rateinquiries = RateInquiry::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

        return View::make('inquiries.rate-inquiries.index', compact('rateinquiries'));
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

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data->user_id = Auth::id();

		if (RateInquiry::create($data)) {

            $hotel_users = DB::table('users')->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
                ->where('hotel_user.hotel_id', $data->hotel_id)
                ->get();

            Mail::send('emails/rate-inquiry', function ($message) use ($hotel_users, $data) {
                $message
                    ->subject('New Inquiry')
                    ->from('info@srilankahotels.travel', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'SriLankaHotels.Travel');
                if (!empty($hotel_users))
                    foreach ($hotel_users as $hotel_user) {
                        $message->to($hotel_user->email, $hotel_user->first_name);
                    }
            });
        }

		return Redirect::route('inquiries.rate-inquiries.index');
	}

    /**
     * Display the specified rateinquiry.
     *
     * @param  int $id
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
     * @param  int $id
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
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $rateinquiry = RateInquiry::findOrFail($id);

        $validator = Validator::make($data = Input::all(), RateInquiry::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $rateinquiry->update($data);

        return Redirect::route('inquiries.rate-inquiries.index');
    }

    /**
     * Remove the specified rateinquiry from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        RateInquiry::destroy($id);

        return Redirect::route('inquiries.rate-inquiries.index');
    }

}
