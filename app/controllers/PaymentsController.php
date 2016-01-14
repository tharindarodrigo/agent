<?php

class PaymentsController extends \BaseController
{

    /**
     * Display a listing of payments
     *
     * @return Response
     */
    public function index()
    {
        $data = Input::all();
//        dd($data);
        if (Input::get('search')) {

            $validator = Validator::make($data, array(
                'from_date' => 'required|date',
                'to_date' => 'required|date',
            ));

            if ($validator->fails()) {
                return Redirect::back()->with($validator->errors());
            }

            $from = Input::get('from_date');
            $to = Input::get('to_date');

            $payments = Payment::where('payment_date_time', '>=', $from)->where('payment_date_time', '<=', $to)->get();
            return View::make('payments.index', compact('payments','from','to'));

        } else {
            $payments = Payment::all();
            return View::make('payments.index', compact('payments'));
        }

    }

    public function getPaymentsList()
    {
        $data = Input::all();
//        dd($data);
        if (Input::get('search')) {

            $validator = Validator::make($data, array(
                'from_date' => 'required|date',
                'to_date' => 'required|date',
            ));

            if ($validator->fails()) {
                return Redirect::back()->with($validator->errors());
            }

            $from = Input::get('from_date');
            $to = Input::get('to_date');

            $payments = Payment::where('payment_date_time', '>=', $from)->where('payment_date_time', '<=', $to)->get();
//            dd($payments);

        } else {
            $payments = Payment::all();
        }

        return View::make('payments.index', compact('payments','from','to'));

    }

    /**
     * Show the form for creating a new payment
     *
     * @return Response
     */
    public function create()
    {
        return View::make('payments.create');
    }

    /**
     * Store a newly created payment in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();

        $data['user_id'] = Auth::id();


        $validator = Validator::make($data, Payment::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        /**
         * Payments are starting from "BK" numbers
         */



        if ($x = Payment::find(Payment::max('id'))) {
            $y = (int)substr($x->reference_number, 2);
            $data['reference_number'] = 'BK' . ++$y;
        } else {
            $data['reference_number'] = 'BK10000000';
        }

        if(Entrust::hasRole('Agent')){
            $data['agent_id'] = User::getAgentOfUser(Auth::id());
        }

        Payment::create($data);

        return Redirect::route('payments.index');
    }

    /**
     * Display the specified payment.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return View::make('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     *
     * @param  int $id
     * @return Response
     */

    public function edit($id)
    {
        $payment = Payment::find($id);

        return View::make('payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $payment = Payment::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Payment::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $payment->update($data);

        return Redirect::route('payments.index');
    }

    /**
     * Remove the specified payment from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Payment::destroy($id);

        return Redirect::route('payments.index');
    }

}
