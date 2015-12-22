<?php require_once('emailStructure/header1.php'); ?>
<style type="text/css">
    th {
        font-size: medium;
    }
</style>


<?php if ($booking->invoice->count == 0) { ?>
    <table border="0" width="100%" style="margin-top: -11px;">
        <tr>
            <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                    : <?php echo $booking->reference_number . '-' . $booking->invoice->count; ?>
            </td>
            <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">Service
                    Voucher

            </td>
        </tr>
    </table>
<?php } else { ?>
    <table border="0" width="100%" style="margin-top: -11px;">
        <tr>
            <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                    : <?php echo $booking->reference_number . '/' . $booking->invoice->count; ?>
            </td>
            <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">Amended
                    Serveice Voucher
            </td>
        </tr>
    </table>

<?php } ?>


<table class="table" border="1px" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th width="100%">Description</th>

    </tr>
    <?php if ($booking->voucher->count()) { ?>
        <tr>

            <td>

                <h3>Hotel Reservations</h3>

                <?php foreach ($booking->voucher as $voucher) { ?>
                    <p>
                        Being cost for <?php echo $voucher->hotel->name; ?>
                        <?php foreach ($voucher->roomBooking as $roomBooking) ?>
                            for <?php echo $roomBooking->room_count . ' ' . $roomBooking->roomSpecification->room_specification . ' ' . $roomBooking->roomType->room_type . ' ' ?>
                        rooms on
                        <?php echo $roomBooking->mealBasis->meal_basis; ?> basis
                        - <?php echo $f = $voucher->check_in; ?> TO <?php echo $t = $voucher->check_out; ?>
                        <?php // echo Voucher::getNights($f, $t)->days;?>
                    </p>

                <?php } ?>

            </td>

        </tr>
    <?php } ?>

    <?php if ($booking->customTrip->count() || $booking->predefinedTrip->count()) { ?>

        <tr>
            <td>
                <h3>Transportation</h3>
                <?php foreach ($booking->customTrip as $trip) { ?>
                    <p><b><?php //echo $trip->reference_number ?></b> Trip
                        By <?php echo $trip->vehicle->vehicle_type; ?>, picked up
                        on <?php echo date('Y-m-d', strtotime($trip->from)); ?>
                        at <?php echo date('H:i', strtotime($trip->from)) ?>. Path (Origin to Destination)
                        : <?php echo $trip->locations ?></p>
                <?php } ?>

                <?php foreach ($booking->predefinedTrip as $trip) { ?>
                    <p>Trip By <?php echo $trip->transportPackage->vehicle->vehicle_type ?>, picked up
                        on <?php echo date('Y-m-d', strtotime($trip->transportPackage->start_date)); ?>
                        at <?php echo date('H:i', strtotime($trip->pick_up_date_time)) ?>. Path (Origin to Destination)
                        : <?php echo City::find($trip->transportPackage->origin)->city; ?> <?php echo City::find($trip->transportPackage->destination)->city; ?>
                    </p>
                <?php } ?>


            </td>

        </tr>

    <?php } ?>

    <?php if ($booking->excursionBooking->count()) { ?>
        <tr>
            <td>
                <h3>Excursions</h3>
                <?php foreach ($booking->excursionBooking as $excursionBooking) { ?>
                    <p>
                        <b>
                            <em><?php echo $excursionBooking->excursion->excursion; ?> </em></b>
                        <?php echo $excursionBooking->excursionTransportType->transport_type; ?> excursion

                        From <?php echo $excursionBooking->city->city; ?>
                        on the <?php echo date('Y-m-d', strtotime($excursionBooking->date)); ?>
                        <?php echo $excursionBooking->pax; ?> pax

                    </p>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>

</table>

<!--<h4>Bank Details</h4>-->
<!---->
<!--<p><b>Beneficiary Bank</b><br>-->
<!--    A/C Name: Exotic Holidays International (PVT) LTD. <br>-->
<!--    MCB BANK LTD-SRI LANKA <br>-->
<!--    A/C No. : 004126000591 </p>-->
<!--<b>Beneficiary's Bank Address</b><br>-->
<!--No. 8, Leyden BastianRoad, Colombo 01, Sri Lanka <br>-->
<!--<b>Swift Code : MUCBKLC</b>-->

<br>

<?php include_once('emailStructure/footer.php') ?>

