<?php

class AllotmentInquiriesController extends \BaseController
{

    /**
     * Display a listing of allotmentinquiries
     *
     * @return Response
     */
    public function index()
    {
        //AllotmentInquiry::where('viewed', 0)->where('status', 1)->update(array('viewed'=> 1));


        $from = null;
        $to = null;
        if (Input::has('search')) {

            //dd(Input::all());

            $from = Input::get('from');
            $to = Input::get('to');

            if (Entrust::hasRole('Admin')) {

                $user_id = Input::get('agent_id');
                $allotmentinquiries = AllotmentInquiry::whereHas('user', function ($q) use ($user_id) {
                    $q->where('users.id', 'like', '%' . $user_id . '%');
                });

            } elseif (Entrust::hasRole('Agent')) {
                $allotmentinquiries = AllotmentInquiry::whereHas('user', function ($q) {
                    $q->where('users.id', '=', Auth::id());
                });
            }

            if (!empty($from) && !empty($to)) {
                $allotmentinquiries = $allotmentinquiries->where('from', '>=', $from)->where('to', '<=', $to);
            }

            $allotmentinquiries = $allotmentinquiries->get();

        } else {

            if (Entrust::hasRole('Admin')) {
                $allotmentinquiries = AllotmentInquiry::orderBy('updated_at', 'desc')->get();
            } elseif (Entrust::hasRole('Agent')) {
                $allotmentinquiries = AllotmentInquiry::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
            }


        }

        return View::make('inquiries.allotment-inquiries.index', compact('allotmentinquiries', 'user_id', 'from', 'to'));
    }

    /**
     * Show the form for creating a new allotmentinquiry
     *
     * @return Response
     */
    public
    function create()
    {
        return View::make('inquiries.allotment-inquiries.create');
    }

    /**
     * Store a newly created allotmentinquiry in storage.
     *
     * @return Response
     */
    public
    function store()
    {
        $validator = Validator::make($data = Input::all(), AllotmentInquiry::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (AllotmentInquiry::create($data)) {

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

        return Redirect::route('inquiries.allotment-inquiries.index');
    }

    /**
     * Display the specified allotmentinquiry.
     *
     * @param  int $id
     * @return Response
     */
    public
    function show($id)
    {
        $allotmentinquiry = AllotmentInquiry::findOrFail($id);

        return View::make('inquiries.allotment-inquiries.show', compact('allotmentinquiry'));
    }

    /**
     * Show the form for editing the specified allotmentinquiry.
     *
     * @param  int $id
     * @return Response
     */
    public
    function edit($id)
    {
        $allotmentinquiry = AllotmentInquiry::find($id);

        return View::make('inquiries.allotment-inquiries.edit', compact('allotmentinquiry'));
    }

    /**
     * Update the specified allotmentinquiry in storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function update($id)
    {
        $allotmentinquiry = AllotmentInquiry::findOrFail($id);

        $validator = Validator::make($data = Input::all(), AllotmentInquiry::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $allotmentinquiry->update($data);

        return Redirect::route('inquiries.allotment-inquiries.index');
    }

    /**
     * Remove the specified allotmentinquiry from storage.
     *
     * @param  int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        AllotmentInquiry::destroy($id);

        return Redirect::route('inquiries.allotment-inquiries.index');
    }

}
