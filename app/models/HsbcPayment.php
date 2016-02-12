<?php

class HsbcPayment extends \Eloquent
{

    //-------------- payment gateway --------------
    //--------------HSBC-----------

    static function goto_hsbc_gateway($payment_id, $currency, $payment_amount, $orderid)
    {

        $returnUrl = "http://agent.srilankahotels.travel/payment-get";

        switch ($currency) {
            case "USD": //USD account
                $MerchantID = '037000959003';
                $VPC_access_code = "8ADA1F12";
                break;

            case "LKR": //LKR account
                $MerchantID = '037000959002';
                $VPC_access_code = "A1ED122A";
                break;

            default:
                $MerchantID = '037000959003';
                $VPC_access_code = "8ADA1F12";
                break;
        }
        ?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
            <title>Exotic Securely Transferring to Payment Gateway</title>

            <!-- Bootstrap -->
            <link href="dist/css/bootstrap.css" rel="stylesheet" media="screen">
            <link href="assets/css/custom.css" rel="stylesheet" media="screen">

            <!-- Updates -->
            <link href="updates/update1/css/style01.css" rel="stylesheet" media="screen">

            <!-- Animo css-->
            <link href="plugins/animo/animate+animo.css" rel="stylesheet" media="screen">

            <link href="examples/carousel/carousel.css" rel="stylesheet">
            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
            <script src="/assets/js/html5shiv.js"></script>
            <script src="/assets/js/respond.min.js"></script>
            <![endif]-->

            <!-- Fonts -->
            <link
                href='http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic'
                rel='stylesheet' type='text/css'>
            <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400,300,300italic' rel='stylesheet'
                  type='text/css'>
            <!-- Font-Awesome -->
            <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css" media="screen"/>
            <!--[if lt IE 7]>
            <link rel="stylesheet" type="text/css" href="assets/css/font-awesome-ie7.css" media="screen"/><![endif]-->

            <!-- Load jQuery -->
            <script src="/assets/js/jquery.v2.0.3.js"></script>

            <style type="">
                .logo {
                    width: 304px !important;
                    height: 92px !important;
                }
            </style>
        </head>

        <body style="background: url('/images/login-bg.jpg', #fff no-repeat">

        <div align="center">
            <!--<p>Please wait while you are being transferred to the payment gateway </p>-->

            <!-- Login Wrap  -->
            <div align="center" style="margin-top: 250px">

                <img src="/images/site/logo11.png" class="logo search-logo" alt=""/>
                <br/><br/>

                <span class="opensans size18 caps bold blue">
                    SriLankaHotels.Travel online reservations..
                </span><br/>

                <span class="opensans size18 grey xsmall">
                   Please wait your payment is being processed..!!
                </span>
                <br/><br/>

                <img src="/updates/update1/img/loading.gif" class="" alt=""/>
                <br/><br/>

            </div>
            <!-- End of Login Wrap  -->

            <form method="POST" action="/send-payment-gateway">
                <input type="hidden" name="currency" value="<?php echo $currency; ?>">
                <input type="hidden" name="Title" value="Exotic - Reservation">
                <input type="hidden" name="virtualPaymentClientURL"
                       value="https://migs.mastercard.com.au/vpcpay">
                <input type="hidden" name="vpc_Version" value="1">
                <input type="hidden" name="vpc_Command" value="pay">
                <input type="hidden" name="vpc_MerchTxnRef" value="<?php echo $payment_id; ?>">
                <input type="hidden" name="vpc_AccessCode" value="<?php echo $VPC_access_code; ?>">
                <input type="hidden" name="vpc_Merchant" value="<?php echo $MerchantID; ?>">
                <input type="hidden" name="vpc_OrderInfo" value="<?php echo $orderid; ?>">
                <input type="hidden" name="vpc_Locale" value="en">
                <input type="hidden" name="vpc_ReturnURL" value="<?php echo $returnUrl; ?>">
                <input type="hidden" name="vpc_Amount" id="vpc_Amount" value="<?php echo $payment_amount; ?>">
            </form>

            <script type="text/javascript">
                document.forms[0].submit()
            </script>

        </div>


        <!-- Javascript  -->
        <script src="/updates/update1/js/initialize-wearesearching.js"></script>
        <script src="/assets/js/jquery.easing.js"></script>

        <!-- Load Animo -->
        <script src="/plugins/animo/animo.js"></script>
        <script type="text/javascript">
            function errorMessage() {
                $('.login-wrap').animo({animation: 'tada'});
            }
        </script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/dist/js/bootstrap.min.js"></script>

        </body>

        </html>

    <?php
    }

    //end function goto_hsbc_gateway
    // This method uses the QSI Response code retrieved from the Digital
    // Receipt and returns an appropriate description for the QSI Response Code
    //
    // @param $responseCode String containing the QSI Response Code
    //
    // @return String containing the appropriate description
    //

    static function getResponseDescription($responseCode)
    {

        switch ($responseCode) {
            case "0" :
                $result = "Transaction Successful";
                break;
            case "?" :
                $result = "Response Unknown";
                break;
            case "1" :
                $result = "Transaction Rejected, please try again....";
                break;
            case "2" :
                $result = "Bank Declined Transaction";
                break;
            case "3" :
                $result = "Transaction unsuccessful, please try again....";
                break;
            case "4" :
                $result = "Transaction Declined - Expired Card";
                break;
            case "5" :
                $result = "Transaction Rejected, please try again...";
                break;
            case "6" :
                $result = "Transaction unsuccessful, please try again.....";
                break;
            case "7" :
                $result = "Transaction unsuccessful, please try again.....";
                break;
            case "8" :
                $result = "Transaction Declined - Transaction Type Not Supported";
                break;
            case "9" :
                $result = "Bank Declined Transaction (Do not contact Bank)";
                break;
            case "A" :
                $result = "Transaction Aborted";
                break;
            case "C" :
                $result = "Transaction Cancelled";
                break;
            case "D" :
                $result = "Deferred Transaction";
                break;
            case "F" :
                $result = "3D Secure Authentication failed";
                break;
            case "E" :
                $result = "Issuer Returned a Referral Response";
                break;
            case "I" :
                $result = "Card Security Code Failed";
                break;
            case "L" :
                $result = "Shopping Transaction Locked (Please try the transaction again later)";
                break;
            case "N" :
                $result = "Cardholder is not enrolled in 3D Secure (Authentication Only)";
                break;
            case "P" :
                $result = "Transaction is Pending";
                break;
            case "R" :
                $result = "Retry Limits Exceeded, Transaction Not Processed";
                break;
            case "S" :
                $result = "Duplicate OrderInfo used. ";
                break;
            case "T" :
                $result = "Address Verification Failed";
                break;
            case "U" :
                $result = "Card Security Code Failed";
                break;
            case "V" :
                $result = "Address Verification and Card Security Code Failed";
                break;
            default :
                $result = "Unable to be determined";
        }
        return $result;
    }

    //  -----------------------------------------------------------------------------
    // This method uses the verRes status code retrieved from the Digital
    // Receipt and returns an appropriate description for the QSI Response Code
    // @param statusResponse String containing the 3DS Authentication Status Code
    // @return String containing the appropriate description

    static function getStatusDescription($statusResponse)
    {
        if ($statusResponse == "" || $statusResponse == "No Value Returned") {
            $result = "3DS not supported or there was no 3DS data provided";
        } else {
            switch ($statusResponse) {
                Case "Y" :
                    $result = "The cardholder was successfully authenticated.";
                    break;
                Case "E" :
                    $result = "The cardholder is not enrolled.";
                    break;
                Case "N" :
                    $result = "The cardholder was not verified.";
                    break;
                Case "U" :
                    $result = "The cardholder's Issuer was unable to authenticate due to some system error at the Issuer.";
                    break;
                Case "F" :
                    $result = "There was an error in the format of the request from the merchant.";
                    break;
                Case "A" :
                    $result = "Authentication of your Merchant ID and Password to the ACS Directory Failed.";
                    break;
                Case "D" :
                    $result = "Error communicating with the Directory Server.";
                    break;
                Case "C" :
                    $result = "The card type is not supported for authentication.";
                    break;
                Case "S" :
                    $result = "The signature on the response received from the Issuer could not be validated.";
                    break;
                Case "P" :
                    $result = "Error parsing input from Issuer.";
                    break;
                Case "I" :
                    $result = "Internal Payment Server system error.";
                    break;
                default :
                    $result = "Unable to be determined";
                    break;
            }
        }
        return $result;
    }

    //  -----------------------------------------------------------------------------
    // If input is null, returns string "No Value Returned", else returns input

    static function null2unknown($data)
    {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }


    /**
     *********************** Relations
     **/

    public function starCategory()
    {
        return $this->belongsTo('StarCategory');
    }

    /**
     *********************** validation rules
     **/


    // Add your validation rules here

    public static $hsbcPaymentRules = [
        'HSBC_payment_id' => '',
        'currency'=> 'required',
        'vpc_txn_res_code' => 'required',
        'qsi_res_code' => 'required',
        'vpc_message' => 'required',
        'vpc_receipt_number' => 'required',
        'vpc_txn_no' => 'required',
        'vpc_acq_res_code' => 'required',
        'vpc_bank_auth_id' => 'required',
        'vpc_batch_no' => 'required',
        'card_type' => 'required',
        'vpc_merchant' => 'required',
        'vpc_command' => 'required',
        'vpc_version' => 'required',
        'vpc_Locale' => 'required',
        'vpc_OrderInfo' => 'required',
        'paid_amount' => 'required|numeric',
    ];

    // Don't forget to fill this array

    protected $fillable = [
        'reference_number',
        'HSBC_payment_id',
        'currency',
        'vpc_txn_res_code',
        'qsi_res_code',
        'vpc_message',
        'vpc_receipt_number',
        'vpc_txn_no',
        'vpc_acq_res_code',
        'vpc_bank_auth_id',
        'vpc_batch_no',
        'card_type',
        'vpc_merchant',
        'vpc_command',
        'vpc_version',
        'vpc_Locale',
        'vpc_OrderInfo',
        'paid_amount',
    ];

}