<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Bookings

Route::group(array('before' => 'auth'), function () {

    /**
     * User Account - after signIn
     */

    Route::get('/', function () {
        return View::make('index');
    });

    Route::group(array('before' => 'csrf'), function () {

        /*
             Change Password (POST)
         */

        Route::post('account/update-profile', 'AccountController@updateProfile');

//        Route::post('/profile/edit-user', array(
//            'as' => 'profile-edit-user-post',
//            'uses' => 'AccountController@postChangePassword',
//        ));

        //Change password

    });

    //Sign Out


    /*
        Sign out (GET)
    */

    Route::get('/account/sign-out', array(
        'as' => 'account-sign-out',
        'uses' => 'AccountController@getSignOut',
    ));

    Route::get('account/profile/change-password', 'AccountController@getChangePassword');
    Route::post('account/profile/post-change-password', 'AccountController@updateProfile');

    Route::get('bookings/cancel-booking', 'BookingsController@cancelBooking');
    Route::post('/bookings/create-client', 'BookingsController@addClient');
    Route::post('/bookings/destroy-client', 'BookingsController@destroyClient');
    Route::post('/bookings/get-clients', 'BookingsController@getClientList');

    Route::get('vouchers/{id}/cancel', 'VouchersController@cancelVoucher');

    Route::post('bookings/post-bookings', 'BookingsController@getSearchedBookings');

    Route::resource('bookings', 'BookingsController');

    Route::resource('bookings.custom-trip', 'CustomTripsController');
    Route::resource('bookings.predefined-trip', 'PredefinedTripsController');
    Route::resource('bookings.excursion-bookings', 'ExcursionBookingsController');

    Route::resource('bookings.clients', 'ClientsController');
    Route::resource('bookings.flightDetails', 'FlightDetailsController');
    Route::post('accounts/get-payment-list', 'PaymentsController@getPaymentsList');
    Route::resource('accounts/payments', 'PaymentsController');
    Route::resource('inquiries/rate-inquiries', 'RateInquiriesController');
    Route::post('hotel/get-room-list','HotelController@getRoomList');


    Route::get('/my-bookings', function () {
        return View::make('agent-bookings.bookings');
    });

    //Vouchers
    Route::resource('bookings.vouchers', 'VouchersController');
    Route::get('accounts/balance-sheet/{reference_number?}', 'AccountsController@getBalanceSheet');
    Route::get('accounts/credit-limit', 'AccountsController@getCreditLimit');
    Route::get('accounts/invoices', 'AccountsController@getInvoices');

    Route::resource('inquiries/rate-inquiries', 'RateInquiriesController');
    Route::resource('inquiries/allotment-inquiries', 'AllotmentInquiriesController');
    Route::post('inquiries/get-inquiry-notifications', 'HomeController@getConfirmedInquiries');

    Route::get('voucher/{id}', function ($id) {
        $voucher = Voucher::find($id);
        $pdf = PDF::loadView('emails/voucher', array('voucher' => $voucher));
        $pdf->setPaper('a4')->save(public_path() . '/temp-files/voucher.pdf');
        return $pdf->stream('abc.pdf');
    });

    Route::get('transport/{id}', function ($id) {
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/transport', array('booking' => $booking));
        $pdf->setPaper('a4')->save(public_path() . '/temp-files/transport.pdf');
        return $pdf->stream('abc.pdf');
    });


    Route::get('excursion/{id}', function ($id) {
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/excursion', array('booking' => $booking));
        $pdf->setPaper('a4')->save(public_path() . '/temp-files/excursion.pdf');
        return $pdf->stream('abc.pdf');
    });

    Route::get('excursion-cancellation/{id}', function ($id) {
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/excursion', array('booking' => $booking));
        $pdf->setPaper('a4')->save(public_path() . '/temp-files/excursion.pdf');
        return $pdf->stream('abc.pdf');
    });

    Route::get('cancellation-voucher/{id}', function ($id) {
        $voucher = Voucher::find($id);
        $pdf = PDF::loadView('emails/cancellation-voucher', array('voucher' => $voucher));
        $pdf->setPaper('a4')->save(public_path() . '/temp-files/cancellation-voucher.pdf');
        return $pdf->stream();

    });


    Route::get('booking/{id}', function ($id) {
//    $hotel_users = DB::table('users')->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
//        ->where('hotel_user.hotel_id', 1065)
//        ->get();
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/booking', array('booking' => $booking));

        return $pdf->stream();
    });

    Route::get('invoice/{id}', function ($id) {
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/invoice', array('booking' => $booking));

        return $pdf->stream();
    });

    Route::get('service-voucher/{id}', function ($id) {
        $booking = Booking::find($id);
        $pdf = PDF::loadView('emails/service-voucher', array('booking' => $booking));

        return $pdf->stream();
    });

});


Route::group(array('prefix' => 'account'), function () {
    Route::get('sign-up', 'AccountController@signUp');
    Route::post('create', 'AccountController@createAccount');
    Route::get('activate/{code}', 'AccountController@activateAccount');
    Route::get('sign-in', 'AccountController@getSignIn');
    Route::post('sign-in', 'AccountController@signIn');
    Route::get('forgot-password', 'AccountController@getForgotPassword');
    Route::post('forgot-password', 'AccountController@postForgotPassword');
    Route::get('recover/{code}', 'AccountController@recoverAccount');
    Route::post('recover-account/{code}', 'AccountController@postRecoverPassword');
});

