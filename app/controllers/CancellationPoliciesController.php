<?php

class CancellationPoliciesController extends \BaseController
{

    /**
     * Display a listing of cancelationpolicies
     *
     * @return Response
     */
    public function index($id)
    {
        $cancellationpolicies = CancellationPolicy::where('hotel_id' . $id);

        return View::make('control-panel.hotel.cancellation-policies.index');

    }

    /**
     * Show the form for creating a new cancelationpolicy
     *
     * @return Response
     */
    public function create()
    {
        return View::make('cancelationpolicies.create');
    }

    /**
     * Store a newly created cancelationpolicy in storage.
     *
     * @return Response
     */
    public function store($hotel_id)
    {
        Session::put('manage', 'policies');

        $validator = Validator::make($data = Input::all(), CancellationPolicy::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        CancellationPolicy::create($data);

        return Redirect::route('control-panel.hotel.hotels.edit', $hotel_id);
    }

    /**
     * Display the specified cancelationpolicy.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $cancelationpolicy = CancellationPolicy::findOrFail($id);

        return View::make('cancelationpolicies.show', compact('cancelationpolicy'));
    }

    /**
     * Show the form for editing the specified cancelationpolicy.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Session::put('manage', 'policies');
        Session::put('edit', 'policies');

        $cancellationpolicy = CancellationPolicy::findOrFail($id);
        dd($cancellationpolicy);
        return Redirect::back()->with(
            array(
                'cancellationpolicy' => $cancellationpolicy
            )
        );
    }

    /**
     * Update the specified cancelationpolicy in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($hotel_id, $id)
    {
        Session::put('manage', 'policies');
        Session::forget('edit');

        $cancelationpolicy = CancellationPolicy::findOrFail($id);

        $validator = Validator::make($data = Input::all(), CancellationPolicy::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $cancelationpolicy->update($data);

        return Redirect::route('control-panel.hotel.hotels.edit', $hotel_id);
    }

    /**
     * Remove the specified cancelationpolicy from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($hotel_id, $id)
    {
        Session::put('manage', 'policies');

        CancellationPolicy::destroy($id);

        return Redirect::route('control-panel.hotel.hotels.edit', $hotel_id);
    }



}
