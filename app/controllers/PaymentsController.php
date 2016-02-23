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
            $agent_id = Input::has('agent_id');

            $validator = Validator::make($data, array(
                'from_date' => 'required|date',
                'to_date' => 'required|date',
            ));

            if ($validator->fails()) {
                return Redirect::back()->with($validator->errors());
            }

            $from = Input::get('from_date');
            $to = Input::get('to_date');

            $payments = Payment::where('payment_date_time', '>=', $from)->where('payment_date_time', '<=', $to)->where('agent_id', 'like', '%' . $agent_id . '%')->get();
            return View::make('payments.index', compact('payments', 'from', 'to', 'agent_id'));

        } else {

            if (Entrust::hasRole('Agent')) {
                $payments = Payment::where('user_id', Auth::id())->get();

            } elseif (Entrust::hasRole('Admin')) {
                $payments = Payment::all();
            }

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

        return View::make('payments.index', compact('payments', 'from', 'to'));

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

        $user_id = Auth::id();

        $validator = Validator::make(Input::all(),

            array(
                'amount' => 'required|numeric',
            )
        );

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

        $data['agent_id'] = User::getAgentOfUser(Auth::id());

        if (Entrust::hasRole('Agent')) {

            $agent_id = $data['agent_id']->user_id;

            $name = User::where('id', $user_id)->first()->first_name .' '. User::where('id', $user_id)->first()->last_name;
            ;
            $email = User::where('id', $user_id)->first()->email;
            $phone = Agent::where('user_id', $user_id)->first()->phone;
            $amount = Input::get('amount');
            $details = Input::get('details');

            $data = array(
                'details' => $name,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                //'reference_number' => $reference_number,
                'amount' => $amount,
                'payment_status' => 0,
                'my_booking' => 2,
            );
            $reserv_id = Payment::create($data);

            $data_tab_HSBC_payment = array(
                'currency' => 'USD',
                // 'reference_number' => $reference_number,
            );
            $tab_HSBC_payment_id = HsbcPayment::create($data_tab_HSBC_payment);


            $stamp = strtotime("now");

            $payment_id = Payment::orderBy('created_at', 'desc')->first()->id;
            $orderid = "$stamp" . 'AP' . "$payment_id";
            $last_res_resid = str_replace(".", "", $orderid);

            $hsbc_id = HsbcPayment::orderBy('created_at', 'desc')->first()->id;
            $hsbc_payment_id_pre = "$stamp" . 'HSBC' . "$hsbc_id";
            $hsbc_payment_id = str_replace(".", "", $hsbc_payment_id_pre);


            if ($last_res_resid) {

                $payment = DB::table('payments')
                    ->where('id', $payment_id)
                    ->update(
                        array(
                            'reference_number' => $last_res_resid,
                            'HSBC_payment_id' => $hsbc_payment_id
                        )
                    );


                $data_tab_HSBC_payment = DB::table('hsbc_payments')
                    ->where('id', $hsbc_id)
                    ->update(
                        array(
                            'HSBC_payment_id' => $hsbc_payment_id
                        )
                    );

                $client = array(
                    'booking_name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'remarks' => $details,
                    'val' => 0,
                    'payment_reference_number' => $last_res_resid
                );
                $client_payment_id = Booking::create($client);

            }


            $currency = 'USD';
            $x = $amount * 1.037;
            $total_price_all_hsbc = round($x, 2) * 100;

            //dd($hsbc_payment_id . '/' . $currency . '/' . $total_price_all_hsbc . '/' . $last_res_resid);

            HsbcPayment::goto_hsbc_gateway($hsbc_payment_id, $currency, $total_price_all_hsbc, $last_res_resid);

            //  return $this->storeAllDataAndSendEmails();

        }

        //Payment::create($data);

        return Redirect::route('accounts.payments.index');
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
