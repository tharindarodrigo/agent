<?php

class AccountsController extends \BaseController
{
    private $_user;

    public function __construct()
    {
        $this->_user = Auth::user();
//        $this->beforeFilter('agent', array('except' => 'create'));
    }

    public function getBalanceSheet()
    {

        if (Auth::check()) {

            $reference_number = Input::has('reference_number') ? Input::get('reference_number') : '%';
            $user_id = Auth::id();

            $payments_query = Payment::with('user')->with('agent')
                ->select(array('payment_date_time AS date', 'amount AS debit', 'details', 'id'));

            $invoices_query = Booking::join('invoices', 'invoices.booking_id', '=','bookings.id')
                ->select(array('arrival_date AS date', 'reference_number AS details', 'amount as credit'))

                ->where('val','=', 1);

            if(!Entrust::hasRole('Admin')){
                $payments_query->where('user_id',$user_id);
                $invoices_query->where('user_id',$user_id);
            }

            if(Input::get('get_payments')){

                Session::flash('activate_payments_tab','active');

                $from_d = Input::get('from_d');
                $to_d = Input::get('to_d');
                $payments = $payments_query->whereBetween('payment_date_time',array($from_d,$to_d))->get();
                $invoices = $invoices_query->whereBetween('arrival_date',array($from_d,$to_d))->get();

            } else {
                $payments = $payments_query->get();
                $invoices = $invoices_query->get();
            }


            //dd($pay);
            if (Entrust::hasRole('Admin')) {
                $bookings = Booking::with('user')
                    ->where('reference_number', 'like', '%' . $reference_number . '%')
//                ->where('arrival_date', '=', $arrival_date)
//                ->where('departure_date', '=', $departure_date)
                    ->get();
            } else {
                $bookings = Booking::whereHas('user', function ($q) {
                    $q->where('users.id', $this->_user->id);
                })->where('reference_number', 'like', $reference_number)
//                ->where('arrival_date', '=', $arrival_date)
//                ->where('departure_date', '=', $departure_date)
                    ->get();
            }


            $merged_data = array_merge($payments->toArray(), $invoices->toArray());
            foreach ($merged_data as $key => $row) {
                $c[$key] = $row['date'];

            }

            if(!empty($merged_data)){
                array_multisort($c, SORT_ASC, $merged_data);
            }

            $total = 0;

            if(Input::has('get_payment'))
                return View::make('accounts.index', compact('bookings', 'payments', 'merged_data','total'))->withInput();

            return View::make('accounts.index', compact('bookings', 'payments', 'merged_data', 'invoice', 'total'));
        }

        return App::abort(404);

    }

    public function getCreditLimit()
    {
        return View::make('accounts.credit-limit');
    }

    public function getInvoices()
    {
        $reference_number = Input::has('reference_number') ? Input::get('reference_number') : '%';

        if (Entrust::hasRole('Admin')) {
            $bookings = Booking::with('user')->with('invoice')
                ->where('reference_number', 'like', '%' . $reference_number . '%');

        } else {

            $bookings = Booking::whereHas('user', function ($q) {
                $q->where('users.id', $this->_user->id);
            })->with('invoice')->where('reference_number', 'like', '%' . $reference_number . '%');
        }

        //$bookings = Booking::with('invoice')->where('user_id',Auth::id())->get();
        if (Input::get('search')) {

            $from = Input::get('from');
            $to = Input::get('to');


            $bookings = $bookings
                ->where('arrival_date','>=',$from)
                ->where('arrival_date','<=',$to);
        }

        $bookings = $bookings->get();
        return View::make('accounts.invoices', compact('bookings', 'from', 'to','tour_type', 'status', 'reference_number'));

    }




    /**
     * Display a listing of the resource.
     * GET /accounts
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     * GET /accounts/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /accounts
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /accounts/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /accounts/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /accounts/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /accounts/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}