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

    Route::resource('bookings', 'BookingsController');

    Route::resource('bookings.custom-trip', 'CustomTripsController');
    Route::resource('bookings.predefined-trip', 'PredefinedTripsController');
    Route::resource('bookings.excursion-bookings', 'ExcursionBookingsController');

    Route::resource('bookings.clients', 'ClientsController');
    Route::resource('bookings.flightDetails', 'FlightDetailsController');
    Route::resource('accounts/payments', 'PaymentsController');


    Route::get('/my-bookings', function () {
        return View::make('agent-bookings.bookings');
    });

//Vouchers
    Route::resource('bookings.vouchers', 'VouchersController');
    Route::get('accounts/balance-sheet/{reference_number?}', 'AccountsController@getBalanceSheet');
    Route::get('accounts/credit-limit', 'AccountsController@getCreditLimit');
    Route::get('accounts/invoices', 'AccountsController@getInvoices');

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

