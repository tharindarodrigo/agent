<?php

class HomeController extends BaseController
{

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function index()
    {

        if (Session::has('st_date')) {
            $st_date = Session::get('st_date');
        } else {
            $st_date = date("Y/m/d");
        }

        //Session::flush();

        if (Session::has('ed_date')) {
            $ed_date = Session::get('ed_date');
        } else {
            $ed_date = date("Y/m/d", strtotime($st_date . ' + 2 days'));
        }


        $tour = Tour::take(5)->get();
        $excursion = Excursion::take(5)->get();
        $user_review = HotelReview::take(3)->get();
        $transport_packages = TransportPackage::take(5)->get();

        return View::make('index')
            ->with(
                array(
                    'tour' => $tour,
                    'excursion' => $excursion,
                    'user_review' => $user_review,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'transport_packages' => $transport_packages,

                )
            );
    }

    public function message()
    {
        return View::make('pages.message');
    }

    /*
 *no result page
 */
    public function view403()
    {
        if (Session::has('st_date')) {
            $st_date = Session::get('st_date');
        } else {
            $st_date = date("Y/m/d");
        }

        //Session::flush();

        if (Session::has('ed_date')) {
            $ed_date = Session::get('ed_date');
        } else {
            $ed_date = date("Y/m/d", strtotime($st_date . ' + 2 days'));
        }

        return View::make('layout.403')
            ->with(
                array(
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                )
            );
    }

    // make currency rate

    public function createCurrency()
    {
        function converCurrency($from, $to, $amount)
        {
            $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
            $request = curl_init();
            $timeOut = 0;
            curl_setopt($request, CURLOPT_URL, $url);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
            $response = curl_exec($request);
            curl_close($request);
            return $response;
        }

        $from_currency = 'USD';
        $to_currency = $_POST['currency'];
        $amount = 1;
        $results = converCurrency($from_currency, $to_currency, $amount);

        $regularExpression = '#\<span class=bld\>(.+?)\<\/span\>#s';
        preg_match($regularExpression, $results, $finalData);
        $finalData[1];
        $str = $finalData[1];
        $rr = (explode(" ", $str));

        Session::put('currency', $rr[1]);
        Session::put('currency_rate', $rr[0]);

        return Response::json(true);

    }

    public function getConfirmedInquiries()
    {
        $allotment_inquiries = null;
        $rate_inquiries = null;
        $rInq = RateInquiry::where('status',1)->where('viewed',0)->where('user_id',Auth::id())->get();
        $aInq = AllotmentInquiry::where('status',1)->where('viewed',0)->where('user_id',Auth::id())->get();
        $inquiry_count = $rInq->count() + $aInq->count();

//        dd($rInq);

        if ($rInq->count()) {
            $rate_inquiries =[];
            foreach ($rInq as $inq) {
                $rate_inquiries[] = [
                    'id' => $inq->id,
                    'hotel' => $inq->hotel->name,
                    'room_type' => $inq->roomType->room_type,
                    'meal_basis' => $inq->mealBasis->meal_basis,
                    'room_specification' => $inq->roomSpecification->room_specification,
                    'from' => $inq->from,
                    'to' => $inq->to,
                    'rateinquiries_url'=> URL::to('inquiries/rate-inquiries')
                ];
            }
        }

        if ($aInq->count()) {
            $allotment_inquiries=[];
            foreach ($rInq as $inq) {
                $inq[] = [
                    'id' => $aInq->id,
                    'hotel' => $aInq->hotel->name,
                    'room_type' => $aInq->roomType->room_type,
                    'from' => $aInq->from,
                    'to' => $aInq->to
                ];
            };
        }


        $inquiries = [
            'rate_inquiries' => $rate_inquiries,

            'allotment_inquiries' => $allotment_inquiries,

            'inquiry_count' => $a = $inquiry_count == 0 ? null: $inquiry_count
        ];

        return Response::json($inquiries);

    }
}

