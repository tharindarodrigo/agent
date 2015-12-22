<?php require_once('emailStructure/header1.php'); ?>
<style type="text/css">
    th {
        font-size: medium;
    }
</style>
<table border="0" width="100%" style="margin-top: -11px;">
    <tr>
        <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                : <?php echo $booking->reference_number ?>
        </td>
        <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">New Excursions
        </td>
    </tr>
</table>
<hr/>


<table class="table" border="1px" cellpadding="10" cellspacing="0" width="100%" style="font-size: medium">


    <?php if ($booking->excursionBooking->count()) { ?>
        <?php foreach ($booking->excursionBooking as $excursionBooking ) { ?>
            <?php if ($excursionBooking->val == 1) { ?>

                <tr style="background: lightgrey;">
                    <th align="left" colspan="2">Reference No : <?php echo $excursionBooking->reference_number; ?> <br>
                    </th>
                </tr>
                <tr>
                    <td>
                        Excursion <br>
                        Transport Type <br>
                        Starting From <br>
                        Date <br>
                        Rate <br>
                        Pax <br>
                        Amount
                    </td>
                    <td align="right">
                        <?php echo $excursionBooking->excursion->excursion; ?> <br>
                        <?php echo $excursionBooking->excursionTransportType->transport_type; ?> <br>
                        <?php echo $excursionBooking->city->city; ?> <br>
                        <?php echo date('Y-m-d', strtotime($excursionBooking->date)); ?> <br>
                        <?php echo number_format($excursionBooking->unit_price, 2); ?> <br>
                        <?php echo $excursionBooking->pax; ?> <br>
                        <?php echo number_format(ExcursionBooking::getTotalExcursionBookingAmount($booking), 2); ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <tr style="background: lightgrey">
        <th>Total</th>
        <td align="right"><strong>USD. <?php echo number_format(ExcursionBooking::getTotalExcursionBookingAmount($booking), 2); ?></strong></td>
    </tr>

</table>



