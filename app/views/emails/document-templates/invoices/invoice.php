<?php require_once('../../emailStructure/header1.php'); ?>
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
            <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">INVOICE

            </td>
        </tr>
    </table>
<?php } else { ?>
    <table border="0" width="100%" style="margin-top: -11px;">
        <tr>
            <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                    : <?php echo $booking->reference_number . '/' . $booking->invoice->count; ?>
            </td>
            <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">AMENDED
                    INVOICE
            </td>
        </tr>
    </table>

<?php } ?>
<hr/>


<table class="table" border="1px" cellpadding="10" cellspacing="0" width="100%">
    <tr style="background: lightgrey;">
        <th width="80%">Description</th>
        <th width="20%">Amount</th>
    </tr>
    <?php if ($booking->voucher->count()) { ?>
        <!--        <tr style="padding-left: 10px;">-->
        <!---->
        <!--            <td colspan="2" >-->
        <!---->
        <!--                <h3>Hotel Reservations</h3>-->
        <!--            </td>-->
        <!--        </tr>-->

        <?php foreach ($booking->voucher as $voucher) { ?>
            <tr>
                <?php if ($voucher->val == 1) { ?>
                    <td>
                        <p>
                            Being cost for <?php echo $voucher->hotel->name; ?>
                            <?php foreach ($voucher->roomBooking as $roomBooking) ?>
                                for <?php echo $roomBooking->room_count . ' ' . $roomBooking->roomSpecification->room_specification . ' ' . $roomBooking->roomType->room_type . ' ' ?>
                            rooms on
                            <?php echo $roomBooking->mealBasis->meal_basis; ?> basis
                            - <?php echo $f = $voucher->check_in; ?> TO <?php echo $t = $voucher->check_out; ?> at
                            USD <?php echo number_format(Voucher::getVoucherAmount($voucher), 2); ?>  <?php // echo Voucher::getNights($f, $t)->days;?>
                        </p>
                    </td>

                    <td align="right">
                        <?php echo number_format(Booking::getTotalVoucherAmount($booking), 2) ?>

                    </td>
                <?php } else {
                    if ($voucher->cancellation_amount != 0) {
                        ?>
                        <td>
                            <p>
                                Canellation charges for <?php echo $voucher->hotel->name; ?>
                                (FROM <?php echo $f = $voucher->check_in; ?> TO <?php echo $t = $voucher->check_out; ?>/
                                <?php foreach ($voucher->roomBooking as $roomBooking) ?>
                                    for <?php echo $roomBooking->room_count . ' ' . $roomBooking->roomSpecification->room_specification . ' ' . $roomBooking->roomType->room_type . ' ' ?>
                                rooms on
                                <?php echo $roomBooking->mealBasis->meal_basis; ?> basis )
                            </p>
                        </td>
                        <td align="right">
                            <?php echo number_format($voucher->cancellation_amount, 2) ?>
                        </td>


                    <?php }
                } ?>
            </tr>

        <?php } ?>


        <!--            </td>-->
        <!---->
        <!--            <td align="right">-->
        <!--                --><?php //echo number_format(Booking::getTotalVoucherAmount($booking), 2) ?>
        <!--                --><?php ////echo number_format($voucher->cancellation_voucher, 2) ?>
        <!--            </td>-->
    <?php } ?>

    <?php if ($booking->customTrip->count()) { ?>

        <tr>
            <td>
                <?php foreach ($booking->customTrip as $trip) { ?>
                    <p><b>#<?php echo $trip->reference_number ?> :</b> Trip
                        By <?php echo $trip->vehicle->vehicle_type; ?>, picked up
                        on <?php echo date('Y-m-d', strtotime($trip->from)); ?>
                        at <?php echo date('H:i', strtotime($trip->from)) ?>. Path (Origin to Destination)
                        : <?php echo $trip->locations ?></p>
                <?php } ?>


            </td>
            <td align="right">
                <?php echo number_format(TransportPackage::getCustomTripTotal($booking), 2); ?>
            </td>
        </tr>

    <?php } ?>
    <?php if ($booking->predefinedTrip->count()) { ?>

        <?php foreach ($booking->predefinedTrip as $trip) { ?>

            <?php if ($trip->val == 1) { ?>
                <tr>
                    <td>
                        <p>Trip By <?php echo $trip->transportPackage->vehicle->vehicle_type ?>, picked up
                            on <?php echo date('Y-m-d', strtotime($trip->transportPackage->start_date)); ?>
                            at <?php echo date('H:i', strtotime($trip->pick_up_date_time)) ?>. Path (Origin to
                            Destination)
                            : <?php echo City::find($trip->transportPackage->origin)->city; ?><?php echo City::find($trip->transportPackage->destination)->city; ?>
                            @ <?php echo number_format($trip->transportPackage->rate * $trip->transportPackage->millage, 2); ?></p>


                    </td>
                    <td align="right">
                        <?php echo number_format(TransportPackage::getPredefinedTripTotal($booking), 2); ?>

                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php if ($booking->excursionBooking->count()) { ?>
        <?php foreach ($booking->excursionBooking as $excursionBooking ) { ?>
            <?php if ($excursionBooking->val == 1) { ?>
                <tr>
                    <td>
                        <p>
                            <b>#<?php echo $excursionBooking->reference_number; ?> :
                                <em><?php echo $excursionBooking->excursion->excursion; ?> </em></b>
                            <?php echo $excursionBooking->excursionTransportType->transport_type; ?> excursion

                            From <?php echo $excursionBooking->city->city; ?>
                            on the <?php echo date('Y-m-d', strtotime($excursionBooking->date)); ?>
                            @ USD. <?php echo number_format($excursionBooking->unit_price, 2); ?> <b>X</b>
                            <?php echo $excursionBooking->pax; ?> pax

                        </p>

                    </td>
                    <td align="right">

                        <?php echo number_format(ExcursionBooking::getTotalExcursionBookingAmount($booking), 2); ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <tr>
        <th>Total</th>

        <td align="right">USD. <?php echo number_format(Booking::getTotalBookingAmount($booking), 2) ?></td>

    </tr>

</table>

<h4>Bank Details</h4>

<p><b>Beneficiary Bank</b><br>
    A/C Name: Exotic Holidays International (PVT) LTD. <br>
    MCB BANK LTD-SRI LANKA <br>
    A/C No. : 004126000591 </p>
<b>Beneficiary's Bank Address</b><br>
No. 8, Leyden BastianRoad, Colombo 01, Sri Lanka <br>
<b>Swift Code : MUCBKLC</b>
<br>
<br>
<?php echo include_once('emailStructure/footer.php') ?>

