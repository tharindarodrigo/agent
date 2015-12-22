<?php require_once('../../emailStructure/header1.php'); ?>
<style type="text/css">
    .CSSTableGenerator {
        margin: 0px;
        padding: 0px;
        width: 99.6%;
        border: 1px solid #000000;

        -moz-border-radius-bottomleft: 0px;
        -webkit-border-bottom-left-radius: 0px;
        border-bottom-left-radius: 0px;

        -moz-border-radius-bottomright: 0px;
        -webkit-border-bottom-right-radius: 0px;
        border-bottom-right-radius: 0px;

        -moz-border-radius-topright: 0px;
        -webkit-border-top-right-radius: 0px;
        border-top-right-radius: 0px;

        -moz-border-radius-topleft: 0px;
        -webkit-border-top-left-radius: 0px;
        border-top-left-radius: 0px;

    }

    .CSSTableGenerator table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;

        margin: 0px;
        padding: 0px;
    }

    .CSSTableGenerator tr:last-child td:last-child {
        -moz-border-radius-bottomright: 0px;
        -webkit-border-bottom-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    .CSSTableGenerator table tr:first-child td:first-child {
        -moz-border-radius-topleft: 0px;
        -webkit-border-top-left-radius: 0px;
        border-top-left-radius: 0px;
    }

    .CSSTableGenerator table tr:first-child td:last-child {
        -moz-border-radius-topright: 0px;
        -webkit-border-top-right-radius: 0px;
        border-top-right-radius: 0px;
    }

    .CSSTableGenerator tr:last-child td:first-child {
        -moz-border-radius-bottomleft: 0px;
        -webkit-border-bottom-left-radius: 0px;
        border-bottom-left-radius: 0px;
    }

    .CSSTableGenerator tr:hover td {

    }

    .CSSTableGenerator tr:nth-child(odd) {
        background-color: #aad4ff;
    }

    .CSSTableGenerator tr:nth-child(even) {
        background-color: #ffffff;
    }

    .CSSTableGenerator td {
        vertical-align: middle;

        border: 1px solid #000000;
        border-width: 0px 1px 1px 0px;
        text-align: left;
        padding: 7px;
        font-size: 10px;
        font-family: Arial;
        font-weight: normal;
        color: #000000;
    }

    .CSSTableGenerator tr:last-child td {
        border-width: 0px 1px 0px 0px;
    }

    .CSSTableGenerator tr td:last-child {
        border-width: 0px 0px 1px 0px;
    }

    .CSSTableGenerator tr:last-child td:last-child {
        border-width: 0px 0px 0px 0px;
    }

    .CSSTableGenerator tr:first-child td {
        background: -o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f));
        background: -moz-linear-gradient(center top, #005fbf 5%, #003f7f 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");
        background: -o-linear-gradient(top, #005fbf, 003 f7f);

        background-color: #005fbf;
        border: 0px solid #000000;
        text-align: center;
        border-width: 0px 0px 1px 1px;
        font-size: 14px;
        font-family: Arial;
        font-weight: bold;
        color: #ffffff;
    }

    .CSSTableGenerator tr:first-child:hover td {
        background: -o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f));
        background: -moz-linear-gradient(center top, #005fbf 5%, #003f7f 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");
        background: -o-linear-gradient(top, #005fbf, 003 f7f);

        background-color: #005fbf;
    }

    .CSSTableGenerator tr:first-child td:first-child {
        border-width: 0px 0px 1px 0px;
    }

    .CSSTableGenerator tr:first-child td:last-child {
        border-width: 0px 0px 1px 1px;
    }

    th {
        text-align: left;
    }
</style>
<table border="0" width="100%"   style="margin-top: -11px;">
    <tr>
        <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                : <?php echo $voucher->reference_number ?>
        </td>
        <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">HOTEL VOUCHER

        </td>
    </tr>
</table>
<hr/>
<br/>
<div>
    <div>
        <table width="100%" border="1px" cellspacing="0" cellpadding="10" style="font-size: 15px;">
            <tr style="background: ">
                <td colspan="2" style="background: lightgrey">Hotel Details</td>
            </tr>
            <tr>
                <th>Hotel Name</th>
                <td> <?php echo $voucher->hotel->name; ?></td>
            </tr>
            <tr>
                <th>Check In Date</th>
                <td> <?php echo $voucher->check_in; ?></td>
            </tr>
            <tr>
                <th>Check Out Date</th>
                <td> <?php echo $voucher->check_out; ?></td>
            </tr>
            <tr>
                <th>No of Nights</th>
                <td>
                    <?php echo Voucher::getNights($voucher->check_out, $voucher->check_in)->days; ?>
                </td>
            </tr>
            <tr style="background: ">
                <td colspan="2" style="background: lightgrey">Room Details</td>
            </tr>
            <?php foreach ($voucher->roomBooking as $roomBooking) { ?>

                <tr>
                    <td>
                        Room Type <br>
                        Meal Basis <br>
                        No. of Rooms <br>
                        Amount
                    </td>
                    <td>
                        <?php echo $roomBooking->roomType->room_type ?> <br>
                        <?php echo $roomBooking->mealBasis->meal_basis ?> <br>
                        <?php echo $roomBooking->room_count ?> <br>
                        USD <?php echo number_format($roomBooking->room_count * $roomBooking->unit_price * Voucher::getNights($voucher->check_in, $voucher->check_out)->days, 2) ?>
                    </td>

                </tr>
            <?php } ?>

            <tr style="background: lightgrey">
                <th>Total Amount</th>
                <td>USD <?php echo number_format(Voucher::getVoucherAmount($voucher), 2); ?></td>
            </tr>


        </table>
    </div>

</div>
<br/>
<?php require_once('emailStructure/footer.php'); ?>
