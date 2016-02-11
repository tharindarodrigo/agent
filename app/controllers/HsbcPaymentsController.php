<?php

class HsbcPaymentsController extends \BaseController
{

    public function sendPayment()
    {

        $data = array();

//        if ($x = Booking::find(Booking::max('id'))) {
//            $data['reference_number'] = ++$x->reference_number;
//        } else {
//            $data['reference_number'] = 10000000;
//        }
//        $reference_number = $data['reference_number'];


        $data = array(
            'details' => 'thilina', //payments table
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            //'reference_number' => $reference_number,
            'amount' => 0.1,
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
        $orderid = "$stamp" . 'B' . "$payment_id";
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
        }


        $amount = Input::get('amount');
        Session::put('payment_amount', $amount);

        // $hsbc_payment_id = 1000;
        $currency = 'USD';
        $total_price_all_hsbc = 0.1 * 100;
        // $last_res_resid = 101;

        //dd($hsbc_payment_id.'/'.$currency.'/'.$total_price_all_hsbc.'/'.$last_res_resid);

        HsbcPayment::goto_hsbc_gateway($hsbc_payment_id, $currency, $total_price_all_hsbc, $last_res_resid);


    }

    public function sendToPaymentGateway()
    {

        /* -----------------------------------------------------------------------------
         Version 2.0
        ------------------ Disclaimer --------------------------------------------------

        Copyright 2004 Dialect Holdings.  All rights reserved.


        This document is provided by Dialect Holdings on the basis that you will treat

        it as confidential.


        No part of this document may be reproduced or copied in any form by any means

        without the written permission of Dialect Holdings.  Unless otherwise expressly

        agreed in writing, the information contained in this document is subject to

        change without notice and Dialect Holdings assumes no responsibility for any

        alteration to, or any error or other deficiency, in this document.



        All intellectual property rights in the Document and in all extracts and things

        derived from any part of the Document are owned by Dialect and will be assigned

        to Dialect on their creation. You will protect all the intellectual property

        rights relating to the Document in a manner that is equal to the protection

        you provide your own intellectual property.  You will notify Dialect

        immediately, and in writing where you become aware of a breach of Dialect's

        intellectual property rights in relation to the Document.



        The names "Dialect", "QSI Payments" and all similar words are trademarks of

        Dialect Holdings and you must not use that name or any similar name.



        Dialect may at its sole discretion terminate the rights granted in this

        document with immediate effect by notifying you in writing and you will

        thereupon return (or destroy and certify that destruction to Dialect) all

        copies and extracts of the Document in its possession or control.



        Dialect does not warrant the accuracy or completeness of the Document or its

        content or its usefulness to you or your merchant customers.   To the extent

        permitted by law, all conditions and warranties implied by law (whether as to

        fitness for any particular purpose or otherwise) are excluded.  Where the

        exclusion is not effective, Dialect limits its liability to $100 or the

        resupply of the Document (at Dialect's option).



        Data used in examples and sample data files are intended to be fictional and

        any resemblance to real persons or companies is entirely coincidental.



        Dialect does not indemnify you or any third party in relation to the content or

        any use of the content as contemplated in these terms and conditions.



        Mention of any product not owned by Dialect does not constitute an endorsement

        of that product.



        This document is governed by the laws of New South Wales, Australia and is

        intended to be legally binding.


        -------------------------------------------------------------------------------


        Following is a copy of the disclaimer / license agreement provided by RSA:



        Copyright (C) 1991-2, RSA Data Security, Inc. Created 1991. All rights reserved.



        License to copy and use this software is granted provided that it is identified

        as the "RSA Data Security, Inc. MD5 Message-Digest Algorithm" in all material

        mentioning or referencing this software or this function.



        License is also granted to make and use derivative works provided that such

        works are identified as "derived from the RSA Data Security, Inc. MD5

        Message-Digest Algorithm" in all material mentioning or referencing the

        derived work.



        RSA Data Security, Inc. makes no representations concerning either the

        merchantability of this software or the suitability of this software for any

        particular purpose. It is provided "as is" without express or implied warranty

        of any kind.



        These notices must be retained in any copies of any part of this documentation

        and/or software.



        --------------------------------------------------------------------------------



        This example assumes that a form has been sent to this example with the

        required fields. The example then processes the command and displays the

        receipt or error to a HTML page in the users web browser.



        NOTE:

        =====

          You may have installed the libeay32.dll and ssleay32.dll libraries
          into your x:\WINNT\system32 directory to run this example.

        --------------------------------------------------------------------------------
         @author Dialect Payment Solutions Pty Ltd Group
        ------------------------------------------------------------------------------*/


// *********************
// START OF MAIN PROGRAM
// *********************

// Define Constants

// ----------------

// This is secret for encoding the MD5 hash

// This secret will vary from merchant to merchant

// To not create a secure hash, let SECURE_SECRET be an empty string - ""

// $SECURE_SECRET = "secure-hash-secret";

        $MID = $_POST["vpc_Merchant"];

        switch ($MID) {

            case '037000959003': //USD
                $SECURE_SECRET = "7D3DE66BAAC683C390B11FD63B236D29";
                break;

            case '037000959002': //LKR
                $SECURE_SECRET = "243CED25A88D3A11FA429305FE408A4B";
                break;

            default:
                $SECURE_SECRET = "7D3DE66BAAC683C390B11FD63B236D29";
                break;

        }


// add the start of the vpcURL querystring parameters

        $vpcURL = $_POST["virtualPaymentClientURL"] . "?";

// Remove the Virtual Payment Client URL from the parameter hash as we

// do not want to send these fields to the Virtual Payment Client.

        unset($_POST["virtualPaymentClientURL"]);

        unset($_POST["SubButL"]);


// The URL link for the receipt to do another transaction.

// Note: This is ONLY used for this example and is not required for

// production code. You would hard code your own URL into your application.


// Get and URL Encode the AgainLink. Add the AgainLink to the array

// Shows how a user field (such as application SessionIDs) could be added

//$_POST['AgainLink']=urlencode($HTTP_REFERER);


// Create the request to the Virtual Payment Client which is a URL encoded GET

// request. Since we are looping through all the data we may as well sort it in

// case we want to create a secure hash and add it to the VPC data if the

// merchant secret has been provided.

        $md5HashData = $SECURE_SECRET;
        ksort($_POST);

// set a parameter to show the first pair in the URL

        $appendAmp = 0;

        foreach ($_POST as $key => $value) {
            // create the md5 input and URL leaving out any fields that have no value

            if (strlen($value) > 0) {

                // this ensures the first paramter of the URL is preceded by the '?' char

                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;

                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }

                $md5HashData .= $value;
            }

        }


// Create the secure hash and append it to the Virtual Payment Client Data if

// the merchant secret has been provided.

        if (strlen($SECURE_SECRET) > 0) {
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
        }

//dd($vpcURL);

// FINISH TRANSACTION - Redirect the customers using the Digital Order

// ===================================================================
        //return Redirect::to($vpcURL);
        // return Response::make( '', 302 )->header( 'Location', $vpcURL );

        header("Location: " . $vpcURL);

// *******************

// END OF MAIN PROGRAM

// *******************

    }

    public function paymentGet()
    {
        if (isset($_GET)) {

            $amount = HsbcPayment::null2unknown($_GET["vpc_Amount"]);

            $locale = HsbcPayment::null2unknown($_GET["vpc_Locale"]);

            $batchNo = HsbcPayment::null2unknown($_GET["vpc_BatchNo"]);

            $command = HsbcPayment::null2unknown($_GET["vpc_Command"]);

            $message = HsbcPayment::null2unknown($_GET["vpc_Message"]);

            $version = HsbcPayment::null2unknown($_GET["vpc_Version"]);

            $cardType = HsbcPayment::null2unknown($_GET["vpc_Card"]);

            $orderInfo = HsbcPayment::null2unknown($_GET["vpc_OrderInfo"]);

            $receiptNo = HsbcPayment::null2unknown($_GET["vpc_ReceiptNo"]);

            $merchantID = HsbcPayment::null2unknown($_GET["vpc_Merchant"]);

            $authorizeID = HsbcPayment::null2unknown($_GET["vpc_AuthorizeId"]);

            $merchTxnRef = HsbcPayment::null2unknown($_GET["vpc_MerchTxnRef"]);

            $transactionNo = HsbcPayment::null2unknown($_GET["vpc_TransactionNo"]);

            $acqResponseCode = HsbcPayment::null2unknown($_GET["vpc_AcqResponseCode"]);

            $txnResponseCode = HsbcPayment::null2unknown($_GET["vpc_TxnResponseCode"]);


            $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";

            $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";

            $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";

            $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";

            $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";

            $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";

            $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";

            $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";


            $payment_info = HsbcPayment::where('HSBC_payment_id', $merchTxnRef);

            if ($payment_info) {

                $qsi_res_code = HsbcPayment::getResponseDescription($txnResponseCode);

                $pay = array();

                $pay = array(
                    'paid_amount' => $amount / 100,
                    'vpc_txn_res_code' => $txnResponseCode,
                    'qsi_res_code' => $qsi_res_code,
                    'vpc_message' => $message,
                    'vpc_receipt_number' => $receiptNo,
                    'vpc_txn_no' => $transactionNo,
                    'vpc_acq_res_code' => $acqResponseCode,
                    'vpc_bank_auth_id' => $authorizeID,
                    'vpc_batch_no' => $batchNo,
                    'card_type' => $cardType,
                    'vpc_merchant' => $merchantID,
                    'vpc_command' => $command,
                    'vpc_version' => $version,
                    'vpc_Locale' => $locale,
                    'vpc_OrderInfo' => $orderInfo,

                );


                $HSBC_payments = DB::table('hsbc_payments')
                    ->where('HSBC_payment_id', $merchTxnRef)
                    ->update($pay);


                if (substr_count($orderInfo, 'B') != 0) {

                    if ($txnResponseCode == 0) {
                        $mybooking = 0;

                        $payment = DB::table('payments')
                            ->where('HSBC_payment_id', $merchTxnRef)
                            ->update(
                                array(
                                    'my_booking' => $mybooking
                                )
                            );

                        return Redirect::route('online-hotel-payments-send-email');
                    }
                }

                if (substr_count($orderInfo, 'A') != 0) {

                    if ($txnResponseCode == 0) {
                        $mybooking = 0;

                        $payment = DB::table('payments')
                            ->where('HSBC_payment_id', $merchTxnRef)
                            ->update(
                                array(
                                    'my_booking' => $mybooking
                                )
                            );

                        $booking = Booking::where('payment_reference_number', $orderInfo)->first();
                        $payment = Payment::where('reference_number', $orderInfo)->first();

                        //dd($booking->email);

//                        Mail::send('emails/online-payment', array(
//                            'payment' => $payment,
//                            'booking' => $booking
//                        ), function ($message) use ($booking) {
//                            $message->subject('Online Payment Receipt : ' . $booking->reference_number)
//                                ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel')
//                                ->bcc('admin@srilankahotels.travel')
//                                ->to('tharindarodrigo@gmail.com');
//                        });


                        Mail::send('emails/online-payment', array(
                            'booking' => $booking,
                            'payment' => $payment
                        ), function ($message) use ($booking, $payment) {
                            $message->subject('Payment : ' . $payment->reference_number)
                                ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel')
                                ->to($booking->email, $booking->booking_name)
                                ->bcc('admin@srilankahotels.travel', 'Admin');
                        });

                        Session::flash('global', 'Thank you for paying online. </br> We have emailed you the online payment invoice');
                        return View::make('pages.message');

                    }

                    Session::flash('global', 'Sorry Your Payment was unsuccessful!');
                    return View::make('pages.message');
                }


                $url = "http://srilankahotels.travel";

                header("Location: $url");
                exit;

            } else {
                die("An error occurred. Please contact administrator");
            }
        } else {
            header("Location:index.php");
            exit;
        }
    }

    public function sendBookingEmails($booking)
    {
        $ehi_users = User::getEhiUsers();

        Mail::send('emails/transport-mail', array(
            'booking' => Booking::find($booking->id)
        ), function ($message) use ($booking, $ehi_users) {
            $message->attach('public/temp-files/transport.pdf')
                ->subject('New Transfer : ' . $booking->reference_number)
                ->from('transport@srilankahotels.travel', 'SriLankaHotels.Travel')
                ->bcc('admin@srilankahotels.travel');
            if (!empty($ehi_users))
                foreach ($ehi_users as $ehi_user) {
                    $message->to($ehi_user->email, $ehi_user->first_name);
                }
        });


        /**
         * Excursions
         */
        if ($booking->excursion->count()) {
            Mail::send('emails/excursion-mail', array(
                'booking' => $booking
            ), function ($message) use ($booking, $ehi_users) {
                $message->attach('public/temp-files/excursions.pdf')
                    ->subject('New Excursions : ' . $booking->reference_number)
                    ->from('noreply@srilankahotels.travel', 'SriLankaHotels.Travel');

                $message->to('excursions@srilankahotels.travel', 'Excursions');
                $message->bcc('admin@srilankahotels.travel', 'Admin');
                if (!empty($ehi_users))
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
            });
        }

        /**
         * Hotel Vouchers
         */

        $vouchers = $booking->voucher;

        foreach($vouchers as $voucher){
            $hotel_users = DB::table('users')->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
                ->where('hotel_user.hotel_id', $voucher->hotel_id)
                ->get();

            Mail::send('emails/voucher-mail', array(
                'voucher' => $voucher
            ), function ($message) use ($booking, $hotel_users, $voucher) {
                $message->attach('public/temp-files/voucher' . $voucher->id . '.pdf')
                    ->subject('Booking Voucher : ' . $booking->reference_number)
                    ->from('reservations@srilankahotels.travel', 'SriLankaHotels.Travel')
                    ->bcc('admin@srilankahotels.travel', 'SriLankaHotels.Travel');
                if (!empty($hotel_users))
                    foreach ($hotel_users as $hotel_user) {
                        $message->to($hotel_user->email, $hotel_user->first_name);
                    }
            });
        }

        /**
         * Bookings
         */

        $emails = array('tharinda@exotic-intl.com', 'lahiru@exotic-intl.com', 'umesh@exotic-intl.com');

        Mail::send('emails/booking-mail', array(
            'booking' => Booking::getBookingData($booking->id)
        ), function ($message) use ($booking, $emails, $ehi_users) {
            $message->attach('public/temp-files/booking'.$booking->id.'.pdf')
                ->subject('New Booking: ' . $booking->reference_number)
                ->from('noreply@srilankahotels.com', 'SriLankaHotels.Travel')
                ->bcc('admin@srilankahotels.travel', 'Admin');
            foreach ($emails as $emailaddress) {
                $message->to($emailaddress, 'Admin');
            }

            if (!empty($ehi_users)) {
                foreach ($ehi_users as $ehi_user) {
                    $message->to($ehi_user->email, $ehi_user->first_name);
                }
            }
        });

        /**
         * Invoice
         *
         *
         * Logged user
         */
        if ($user = $booking->user) {
            Mail::send('emails/invoice-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($user, $booking, $emails) {
                $message->subject('Booking Invoice : ' . $booking->reference_number)
                    ->attach('public/temp-files/invoice'.$booking->id.'.pdf');
                $message->to($user->email, $user->first_name . ' ' . $user->last_name);
                $message->to('accounts@srilankahotels.travel', 'Accounts');
                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }

            });

        } else {

            /**
             * Invoice
             * Guest User
             */

            Mail::send('emails/invoice-mail', array(
                'booking' => Booking::getBookingData($booking->id)
            ), function ($message) use ($booking, $emails) {
                $message->to($booking->email, $booking->name)
                    ->subject('Booking Created : ' . $booking->reference_number)
                    ->attach('public/temp-files/invoice'.$booking->id.'.pdf');
                $message->to('accounts@srilankahotels.travel', 'Accounts');
                if (!empty($ehi_users)) {
                    foreach ($ehi_users as $ehi_user) {
                        $message->to($ehi_user->email, $ehi_user->first_name);
                    }
                }
            });
        }
    }




}
