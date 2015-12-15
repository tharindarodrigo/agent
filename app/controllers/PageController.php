<?php

class pageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function tourismInSrilanka()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.tourism_in_srilanka')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
	}


    public function srilankaAdvance()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.srilankan_advice')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }

    public function aboutSrilanka()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.about_srilanka')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }

    public function faq()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.faq')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }

    public function termsAndConditions()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.terms_and_conditions')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }

    public function privacyAndPolicy()
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

        $filter_tours = Tour::get();
        $filter_cities = City::get();


        $path = array();

//        dd(DB::getQueryLog());

        return View::make('pages.privacy_policy')
            ->with(
                array(


                    'path' => $path,
                    'st_date' => $st_date,
                    'ed_date' => $ed_date,
                    'filter_tours' => $filter_tours,
                    'filter_cities' => $filter_cities,

                )
            );
    }



}
