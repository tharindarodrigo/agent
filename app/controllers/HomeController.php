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


        // Filtering
        $hotel_type = DB::table('hotel_categories')->where('val', 1)->get();
        $hotel_cities = DB::table('cities')->where('val', 1)->get();
        $hotel_facilities = DB::table('hotel_facilities')->where('val', 1)->get();

        return View::make('errors.403')
            ->with(
                array(
                    'hotel_type' => $hotel_type,
                    'hotel_cities' => $hotel_cities,
                    'hotel_facilities' => $hotel_facilities,
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
}

