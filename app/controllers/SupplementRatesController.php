<?php

class SupplementRatesController extends \BaseController
{
    private $_user;
    private $_parameters;

    public function __construct()
    {
        $this->_user = Auth::user();
        $this->_parameters = Route::current()->parameters();
            if (!User::hasHotelPermission($this->_user, $this->_parameters['hotels']))
                if (!Entrust::hasRole('Admin')) {
                    App::abort(403);
                }
    }

    /**
     * Display a listing of rates
     *
     * @return Response
     */
    public function index($hotelid)
    {
        $rates = SupplementRate::where('hotel_id', $hotelid)->orderBy('from')->get();

        return View::make('control-panel.hotel.supplement-rates.index', compact('hotelid', 'rates'));
    }

    /**
     * Show the form for creating a new rate
     *
     * @return Response
     */
    public function create($hotelid)
    {
        $rates = SupplementRate::all();
        return View::make('control-panel.hotel.supplement-rates.create', compact('hotelid', 'rates'));
    }

    /**
     * Store a newly created rate in storage.
     *
     * @return Response
     */
    public function store($hotelid)
    {

        $validator = Validator::make($data = Input::all(), SupplementRate::$rules);

        if ($validator->fails()) {
            return Response::json(array("errors" => $validator->errors()));
        }

        $rates = Input::get('rates');
        $keys = Input::get('keys');
        $markets = Input::get('market_id');

        $inserted_ids = array();

        $rates = explode(',', $rates);
        $keys = explode(',', $keys);
        $markets = explode(',', $markets);

        $data = array();

        mainLoop:
        foreach ($markets as $market) {
            $i = -1;
            foreach ($rates as $rate) {
                $i++;

                $ids = explode("-", $keys[$i]);

                $data = array(

                    'from' => Input::get("from"),
                    'to' => Input::get("to"),
                    'supplement_name' => Input::get("supplement_name"),
                    'rate' => $rate,
                    'hotel_id' => $hotelid,
                    'meal_basis_id' => $ids[0],
                    'room_specification_id' => $ids[1],
                    'room_type_id' => Input::get("room_type_id"),
                    'user_id' => Auth::user()->id,
                    'val' => 1,
                    'market_id' => $market
                );

                $from = $data["from"];
                $to = $data["to"];

                $conditions = array(
                    'meal_basis_id' => $ids[0],
                    'room_specification_id' => $ids[1],
                    'room_type_id' => Input::get("room_type_id"),
                    'market_id' => $market
                );

                $newperiods = array();

                $newperiods[] = array(

                    'from' => $from,
                    'to' => $to,
                    'rate' => $rate
                );

                $from_date = new DateTime($from);
                $to_date = new DateTime($to);

//                $from_date->sub(new DateInterval('P1D'));
//                $to_date->add(new DateInterval('P1D'));

                /*
                 * <------------|------------------|--------------|-------------------|----------------->
                 *              a         <        x      <       y         <         b
                 */

                $existing = SupplementRate::where($conditions)->where('from', '<', $from)->where('to', '>', $to)->first();


                if (!empty($existing->id)) {

                    $newperiods = array(
                        array(
                            "from" => $existing["from"],
                            "to" => $from_date->format('Y-m-d'),
                            "rate" => $existing->rate
                        ), array(
                            "from" => $from,
                            "to" => $to,
                            "rate" => $rate
                        ), array(
                            "from" => $to_date->format('Y-m-d'),
                            "to" => $existing->to,
                            "rate" => $existing->rate
                        )
                    );

                    $this->insertRates($newperiods, $data);


                    SupplementRate::where("id", $existing->id)->delete();

                } else {

                    /*
                     * <------------|------------------|--------------|-------------------|----------------->
                     *              x         <        a      <       b         <         y
                     */

                    $existing1 = SupplementRate::where($conditions)->where('from', '>=', $from)->where('to', '<=', $to)->get();

                    if ($existing1->count()) {

                        $conflicting_ids = array();

                        foreach ($existing1 as $conflict) {
                            $conflicting_ids[] = $conflict->id;
                        }

                        SupplementRate::whereIn('id', $conflicting_ids)->delete();

                        $newperiods = array(
                            array(
                                'from' => $from,
                                'to' => $to,
                                'rate' => $rate
                            )
                        );

                        $this->insertRates($newperiods, $data);

                    }


                    /*
                     * <------------|------------------|--------------|-------------------|----------------->
                     *              a         <        x      <       b         <         y
                     */

                    $existing_condition_1 = SupplementRate::where($conditions)->where('from', '<=', $from)->where('to', '>=', $from)->where('to', '<', $to)->first();

                    if (!empty($existing_condition_1->id)) {

                        SupplementRate::where('id', $existing_condition_1->id)->delete();

                        $newperiods = array(
                            array(
                                'from' => $existing_condition_1->from,
                                'to' => $from_date->format('Y-m-d'),
                                'rate' => $existing_condition_1->rate
                            ),
                            array(
                                'from' => $from,
                                'to' => $to,
                                'rate' => $rate
                            )
                        );

                        $this->insertRates($newperiods, $data);
                    }

                    /*
                     * <------------|------------------|--------------|-------------------|----------------->
                     *              x         <        a      <       y         <         b
                     */

                    $existing_condition_2 = SupplementRate::where($conditions)->where('from', '>=', $from)->where('from', '<=', $to)->where('to', '>', $to)->first();

                    if (!empty($existing_condition_2->id)) {

                        SupplementRate::where('id', $existing_condition_2->id)->delete();

                        $newperiods = array(

                            array(
                                'from' => $from,
                                'to' => $to,
                                'rate' => $rate
                            ), array(
                                'from' => $to_date->format('Y-m-d'),
                                'to' => $existing_condition_2->to,
                                'rate' => $existing_condition_2->rate
                            )
                        );

                        $this->insertRates($newperiods, $data);

                    } else {

                        $this->insertRates($newperiods, $data);

                    }

                }

            }
        }


        Return Response::json($data);

    }


    public function insertRates($newperiods, $data)
    {
        foreach ($newperiods as $newperiod) {

            $data_wo_user_id = $data = array_merge($data, $newperiod);

            unset($data_wo_user_id['user_id']);

            $duplicate_rate = SupplementRate::where($data_wo_user_id)->get();

            if ($duplicate_rate->count() == 0) {
                if ($insertion = SupplementRate::create($data)) {
                    $inserted_ids[] = $insertion->id;
                } else {
                    SupplementRate::whereIn('id', $inserted_ids)->delete();
                    return Response::json(array('error' => 'There was an error entering rates. Please Contact Your Administrator'));
                }
            }

        }
    }

    public function updateSupplementRates($hotelid)
    {

        $validator = Validator::make($data = Input::all(), SupplementRate::$rules);

        if ($validator->fails()) {
            return Response::json(array("errors" => $validator->errors()));
        }

        $rates = Input::get('rates');
        $keys = Input::get('keys');
        $market = Input::get('market_id');
        $inserted_ids = array();

        $rates = explode(',', $rates);
        $keys = explode(',', $keys);

        $data = array();
        $deleted_items = false;


        $i = -1;
        foreach ($rates as $rate) {
            $i++;

            $ids = explode("-", $keys[$i]);

            $data = array(

                'from' => Input::get("from"),
                'to' => Input::get("to"),
                'supplement_name' => Input::get("supplement_name"),
                'rate' => $rate,
                'hotel_id' => $hotelid,
                'meal_basis_id' => $ids[0],
                'room_specification_id' => $ids[1],
                'room_type_id' => Input::get("room_type_id"),
                'user_id' => Auth::user()->id,
                'val' => 1,
                'market_id' => $market
            );

            $from = $data["from"];
            $to = $data["to"];


            $conditions = array(
                'meal_basis_id' => $ids[0],
                'room_specification_id' => $ids[1],
                'room_type_id' => Input::get("room_type_id"),
                'market_id' => $market
            );

            $newperiods = array();

            $newperiods[] = array(

                'from' => $from,
                'to' => $to,
                'rate' => $rate
            );

            $from_date = new DateTime($from);
            $to_date = new DateTime($to);

            $from_date->sub(new DateInterval('P1D'));
            $to_date->add(new DateInterval('P1D'));

            /*
             * <------------|------------------|--------------|-------------------|----------------->
             *              a         <        x      <       y         <         b
             */

            $existing = SupplementRate::where($conditions)->where('from', '<', $from)->where('to', '>', $to)->first();


            if (!empty($existing->id)) {

                $newperiods = array(
                    array(
                        "from" => $existing["from"],
                        "to" => $from_date->format('Y-m-d'),
                        "rate" => $existing->rate
                    ), array(
                        "from" => $from,
                        "to" => $to,
                        "rate" => $rate
                    ), array(
                        "from" => $to_date->format('Y-m-d'),
                        "to" => $existing->to,
                        "rate" => $existing->rate
                    )
                );

                $this->insertRates($newperiods, $data);


                SupplementRate::where("id", $existing->id)->delete();

            } else {

                /*
                 * <------------|------------------|--------------|-------------------|----------------->
                 *              x         <        a      <       b         <         y
                 */

                $existing1 = SupplementRate::where($conditions)->where('from', '>=', $from)->where('to', '<=', $to)->get();

                if ($existing1->count()) {

                    $conflicting_ids = array();

                    foreach ($existing1 as $conflict) {
                        $conflicting_ids[] = $conflict->id;
                    }

                    SupplementRate::whereIn('id', $conflicting_ids)->delete();

                    $newperiods = array(
                        array(
                            'from' => $from,
                            'to' => $to,
                            'rate' => $rate
                        )
                    );

                    $this->insertRates($newperiods, $data);

                }


                /*
                 * <------------|------------------|--------------|-------------------|----------------->
                 *              a         <        x      <       b         <         y
                 */

                $existing_condition_1 = SupplementRate::where($conditions)->where('from', '<=', $from)->where('to', '>=', $from)->where('to', '<', $to)->first();

                if (!empty($existing_condition_1->id)) {

                    SupplementRate::where('id', $existing_condition_1->id)->delete();

                    $newperiods = array(
                        array(
                            'from' => $existing_condition_1->from,
                            'to' => $from_date->format('Y-m-d'),
                            'rate' => $existing_condition_1->rate
                        ),
                        array(
                            'from' => $from,
                            'to' => $to,
                            'rate' => $rate
                        )
                    );

                    $this->insertRates($newperiods, $data);
                }

                /*
                 * <------------|------------------|--------------|-------------------|----------------->
                 *              x         <        a      <       y         <         b
                 */

                $existing_condition_2 = SupplementRate::where($conditions)->where('from', '>=', $from)->where('from', '<=', $to)->where('to', '>', $to)->first();

                if (!empty($existing_condition_2->id)) {

                    SupplementRate::where('id', $existing_condition_2->id)->delete();

                    $newperiods = array(

                        array(
                            'from' => $from,
                            'to' => $to,
                            'rate' => $rate
                        ), array(
                            'from' => $to_date->format('Y-m-d'),
                            'to' => $existing_condition_2->to,
                            'rate' => $existing_condition_2->rate
                        )
                    );

                    $this->insertRates($newperiods, $data);

                } else {

                    if (!$deleted_items) {
                        Rate::where(array('from' => Input::get('old_from'), 'to' => Input::get('old_to'), 'room_type_id' => Input::get('room_type_id'), 'market_id' => Input::get('market_id')))->delete();
                        $deleted_items = true;
                    }
                    $this->insertRates($newperiods, $data);

                }

            }

        }

        Return Response::json('/control-panel/hotel/hotels/' . $hotelid . '/supplement-rates');
    }

    /**
     * Display the specified rate.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $rate = SupplementRate::findOrFail($id);

        return View::make('control-panel.hotel.supplement-rates.show', compact('rate'));
    }

    /**
     * Show the form for editing the specified rate.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($hotelid, $id)
    {
        $rate = SupplementRate::find($id);
        $rates = SupplementRate::where('from', $rate->from)->where('to', $rate->to)->where('room_type_id', $rate->room_type_id)->where('market_id', $rate->market_id)->get();
        $checkedmarketids = array();

        $roomtype = RoomType::with('roomSpecification')->find($rate->room_type_id);
        $mealbases = MealBasis::all();

        return View::make('control-panel.hotel.supplement-rates.edit', compact('hotelid', 'rate', 'rates', 'mealbases', 'checkedmarketids', 'roomtype'));
    }

    /**
     * Update the specified rate in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $rate = SupplementRate::findOrFail($id);

        $validator = Validator::make($data = Input::all(), SupplementRate::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $rate->update($data);

        return Redirect::route('rates.index');
    }

    /**
     * Remove the specified rate from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($hotelid, $id)
    {
        SupplementRate::destroy($id);
        return Redirect::back();
    }

    public function getRateData($hotelid)
    {
        $room_id = Input::get('room_type_id');

        $roomspaces = RoomType::with('roomSpecification')->find($room_id);
        return Response::json(array($roomspaces, MealBasis::all()));
    }

}
