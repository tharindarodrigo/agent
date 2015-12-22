<?php require_once('emailStructure/header1.php'); ?>
<style type="text/css">
    th {
        font-size: medium;
    }
</style>
<table border="0" width="100%" style="margin-top: -11px;">
    <tr>
        <td><h2 align="left" style="background: #00517e; padding: 10px; color: #FFFFFF ">Reference No
                : <?php echo $booking->reference_number?>
        </td>
        <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">New Transport
        </td>
    </tr>
</table>
<hr/>


<table class="table" border="1px" cellpadding="10" cellspacing="0" width="100%" style="font-size: medium">


    <?php if ($booking->customTrip->count()) { ?>
        <?php foreach ($booking->customTrip as $trip) { ?>

            <?php if ($trip->val == 1) { ?>
                <tr style="background: lightgrey;">
                    <th align="left" colspan="2"> Reference No : <?php echo $trip->reference_number ?> </th>
                </tr>

                <tr>
                    <td>
                        Vehicle Type <br>
                        Date <br>
                        Time <br>
                        Locations <br>
                        Amount
                    </td>
                    <td align="right">

                        <?php echo $trip->vehicle->vehicle_type; ?> <br>
                        <?php echo date('Y-m-d', strtotime($trip->from)); ?> <br>
                        <?php echo date('H:i', strtotime($trip->from)) ?> <br>
                        <?php echo $trip->locations ?> <br>
                        <?php echo number_format($trip->amount, 2) ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php if ($booking->predefinedTrip->count()) { ?>

        <?php foreach ($booking->predefinedTrip as $trip) { ?>

            <?php if ($trip->val == 1) { ?>
                <tr style="background: lightgrey;">
                    <th align="left" colspan="2"> Reference No : <?php echo $trip->reference_number ?> </th>
                </tr>
                <tr>
                    <td>
                        Reference No <br>
                        Vehicle Type <br>
                        Date <br>
                        Time <br>
                        Locations <br>
                        Amount
                    </td>
                    <td align="right">
                        <?php echo $trip->reference_number ?> <br>
                        <?php echo $trip->transportPackage->vehicle->vehicle_type ?><br>
                        <?php echo $trip->pick_up_date_time ?><br>
                        <?php echo date('H:i', strtotime($trip->pick_up_date_time)) ?><br>
                        <?php echo City::find($trip->transportPackage->origin)->city; ?>, <?php echo City::find($trip->transportPackage->destination)->city; ?>
                        <br>
                        <?php echo number_format($trip->amount, 2); ?>
                        <br>

                        <?php //echo number_format(TransportPackage::getPredefinedTripTotal($booking), 2); ?>

                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>


    <tr style="background: lightgrey">
        <th>Total</th>

        <td align="right"><strong>USD. <?php echo number_format(TransportPackage::getTotalTransportationAmount($booking),2) ?></strong></td>

    </tr>

</table>



