<?php require_once('emailStructure/header1.php') ?>


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
</style>

<div style="background: #0099cc; padding: 1px; padding-left: 20px;">
    <?php if ($booking->count == 0) { ?>
        <table border="0" width="100%" style="margin-top: -11px;">
            <tr>
                <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                        : <?php echo $booking->reference_number; ?>
                </td>
                <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">
                        Booking</h2>

                </td>
            </tr>
        </table>
    <?php } else { ?>
        <table border="0" width="100%" style="margin-top: -11px;">
            <tr>
                <td>
                    <h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                        : <?php echo $booking->reference_number . '/' . $booking->count; ?>
                    </h2>
                </td>
                <td align="right">
                    <h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">Amended
                        Booking
                    </h2>
                </td>
            </tr>
        </table>
    <?php } ?>

</div>
<br/>

<div>

    <table width="100%">
        <tr>
            <td>
                <table>
                    <thead style="text-align: left;">
                    <tr>
                        <th align="left">Booking No</th>
                        <td>: <?php echo $booking->reference_number ?></td>
                    </tr>
                    <tr>
                        <th align="left">Booked By</th>
                        <td>
                            : <?php echo !empty($booking->user) ? $booking->user->first_name . ' ' . $booking->user->last_name : $booking->booking_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Tour</th>
                        <td>: <?php echo $booking->tour; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Remark</th>
                        <td>: <?php echo $booking->remarks; ?></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td></td>
            <td>&nbsp;&nbsp;</td>
            <td>
                <table>
                    <tr>
                        <th align="left">Arrival Date</th>
                        <td>: <?php echo $booking->arrival_date; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Departure Date</th>
                        <td>: <?php echo $booking->departure_date; ?></td>
                    </tr>
                    <tr>
                        <th align="left">Pax</th>
                        <td>: Adults - <?php echo $booking->adults; ?></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>&nbsp;&nbsp;Children - <?php echo $booking->children; ?></td>
                    </tr>

                </table>
            </td>

        </tr>
    </table>

</div>

<br/>

<?php if ($booking->voucher->count()) { ?>

    <div style="background: #0099cc; padding: 1px; padding-left: 20px;">
        <h4>Hotel Details</h4>
    </div>

    <br/>

    <div class="CSSTableGenerator">
        <table width="100%">


            <tr align="left">
                <td width="30%">Hotel Name</td>
                <td width="15%">Check In</td>
                <td width="15%">Check Out</td>
                <td width="10%">Rooms</td>
                <td width="10%">Basis</td>
                <td width="10%">No. of Rooms</td>

            </tr>


            <!--            --><?php //dd($clients); ?>
            <?php foreach ($booking->voucher as $voucher) { ?>

                <tr>
                    <td><?php echo $voucher->hotel->name; ?></td>
                    <td style="text-align: center"><?php echo $voucher->check_in; ?></td>
                    <td style="text-align: center"><?php echo $voucher->check_out; ?></td>
                    <td style="text-align: center">
                        <?php
                        $x = 1;
                        foreach ($voucher->roomBooking as $roomBooking) { ?>
                            <?php

                            echo $roomBooking->roomType->room_type;
                            echo count($voucher->roomBooking) != $x ? '<br><hr>' : '';
                            $x++;
                            ?>

                        <?php } ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $x = 1;
                        foreach ($voucher->roomBooking as $roomBooking) { ?>
                            <?php

                            echo $roomBooking->mealBasis->meal_basis;
                            echo count($voucher->roomBooking) != $x ? '<br><hr>' : '';
                            $x++;
                            ?>
                        <?php } ?>
                    </td>
                    <td style="text-align: right">
                        <?php
                        $x = 1;
                        foreach ($voucher->roomBooking as $roomBooking) { ?>

                            <?php
                            echo $roomBooking->room_count;
                            echo count($voucher->roomBooking) != $x ? '<br><hr>' : '';
                            $x++;
                            ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>


        </table>
    </div>

<?php } ?>

<br/>

<?php if ($booking->client->count()) { ?>
<div style="background: #0099cc; padding: 1px; padding-left: 20px;">
    <h4>Client Details</h4>
</div>

<br/>

<div class="CSSTableGenerator">
    <table>

        <tr align="left">
            <td width="50%">Name</td>
            <td width="20%">Passport</td>
            <td width="20%">DoB</td>
            <td width="10%">Gender</td>
        </tr>

        <?php

        foreach ($booking->client as $client) { ?>
            <!--        --><?php //foreach (Client::all() as $client) { ?>

            <tr>
                <td><?php echo $client['name'] ?></td>
                <td><?php echo $client['passport_number'] ?></td>
                <td><?php echo $client['dob'] ?></td>
                <td><?php echo $client['gender'] == 1 ? 'Male' : 'Female' ?></td>
            </tr>
        <?php } ?>

    </table>
</div>


<br/>


<div>

    <?php } ?>
    <?php if ($booking->flightDetail->count()) { ?>


        <div style="background: #0099cc; padding: 1px; padding-left: 20px;">
            <h4>Flight Details</h4>
        </div>
        <br/>

        <div class="CSSTableGenerator">
            <table>
                <tr align="left">
                    <td width="20%">Date</td>
                    <td width="20%">Time</td>
                    <td width="40%">Flight</td>
                    <td width="20%">Flight Type</td>

                </tr>
                <?php foreach ($booking['flight_detail'] as $flight) { ?>
                    <?php //foreach (FlightDetail::all() as $flight) { ?>

                    <tr>
                        <td><?php echo $flight['date'] ?></td>
                        <td><?php echo $flight['time'] ?></td>
                        <td><?php echo $flight['flight'] ?></td>
                        <td><?php echo $flight['flight_type'] == 1 ? 'Arrival' : 'Departure' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </div>

        <br/>
    <?php } ?>
</div>

<div>
    <?php if ($booking->customTrip->count() || $booking->predefinedTrip->count()) { ?>
        <div style="background: #0099cc; padding: 1px; padding-left: 20px;">
            <h4>Transportation</h4>
        </div>
        <br/>
        <div class="CSSTableGenerator">
            <table>
                <tr>
                    <td>Reference No.</td>
                    <td>From</td>
                    <td>Vehicle</td>
                    <td>Locations</td>
                    <td>Amount</td>
                </tr>
                <?php if ($booking->customTrip->count()) { ?>
                    <?php foreach ($booking->customTrip as $customTrip) { ?>
                        <tr>
                            <td><?php echo /*$customTrip->reference_number*/
                                10000000; ?></td>
                            <td><?php echo $customTrip->from ?></td>
                            <td><?php echo $customTrip->vehicle->vehicle_type ?></td>
                            <td><?php str_replace(',', '<br>', $customTrip->locations) ?></td>
                            <td style="text-align: right"><?php echo number_format($customTrip->amount, 2) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php if ($booking->predefinedTrip->count()) { ?>
                    <?php foreach ($booking->predefinedTrip as $predefinedTrip) { ?>
                        <tr>
                            <td><?php echo /*$predefinedTrip->reference_number*/
                                10000001 ?></td>
                            <td><?php echo $predefinedTrip->pick_up_date_time ?></td>
                            <td><?php echo $predefinedTrip->transportPackage->vehicle->vehicle_type ?></td>
                            <td><?php echo $predefinedTrip->transportPackage->originCity->city ?><br>
                                <?php echo $predefinedTrip->transportPackage->destinationCity->city ?></td>
                            <td style="text-align: right"><?php echo number_format($predefinedTrip->amount, 2) ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>

    <?php } ?>
</div>

<br>

<div>
    <?php if ($booking->excursionBooking->count()) { ?>
        <div style="background: #0099cc; padding: 1px; padding-left: 20px;">
            <h4> Excursions</h4>
        </div>
        <br/>
        <div class="CSSTableGenerator">
            <table>
                <tr>
                    <td>Reference No.</td>
                    <td>Excursion</td>
                    <td>Date</td>
                    <td>Type</td>
                    <td>Pax</td>
                    <td>Unit Prices</td>
                    <td>Amount</td>
                </tr>
                <?php foreach ($booking->excursionBooking as $excursionBooking) { ?>
                    <tr>
                        <td><?php echo $excursionBooking->reference_number ?></td>
                        <td><?php echo $excursionBooking->excursion->excursion ?></td>
                        <td><?php echo date('Y-m-d', strtotime($excursionBooking->date)) ?></td>
                        <td style="text-align: right"><?php echo $excursionBooking->excursionTransportType->transport_type ?></td>
                        <td style="text-align: right"><?php echo $excursionBooking->pax ?></td>
                        <td style="text-align: right"><?php echo number_format($excursionBooking->unit_price, 2) ?></td>
                        <td style="text-align: right"><?php echo number_format(ExcursionBooking::getTotalExcursionBookingAmount($booking), 2) ?></td>
                    </tr>
                <?php } ?>
            </table>

        </div>

    <?php } ?>
</div>









