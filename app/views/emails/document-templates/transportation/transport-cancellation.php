<?php require_once('../../emailStructure/header1.php'); ?>
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
        <td align="right"><h2 align="right" style="background: #00517e; padding: 10px; color: #FFFFFF ">Transport
                Cancellation
        </td>
    </tr>
</table>
<hr/>
<br>

<table class="table" border="1px" cellpadding="10" cellspacing="0" width="100%" style="font-size: medium">

    <?php if (!empty($customTrip)) { ?>

        <?php if ($customTrip->val == 0) { ?>
            <tr style="background: lightgrey;">
                <th align="left" colspan="2"> Reference No : <?php echo $customTrip->reference_number ?> </th>
            </tr>

            <tr>
                <td>
                    Vehicle Type Custom<br>
                    Date <br>
                    Time <br>
                    Locations <br>
                    Amount
                </td>
                <td align="right">

                    <?php echo $customTrip->vehicle->vehicle_type; ?> <br>
                    <?php echo date('Y-m-d', strtotime($customTrip->from)); ?> <br>
                    <?php echo date('H:i', strtotime($customTrip->from)) ?> <br>
                    <?php echo $customTrip->locations ?> <br>
                    <?php echo number_format($customTrip->amount, 2) ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($predefinedTrip)) { ?>

        <?php if ($predefinedTrip->val == 0) { ?>
            <tr style="background: lightgrey;">
                <th align="left" colspan="2"> Reference No : <?php echo $predefinedTrip->reference_number ?> </th>
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
                    <?php echo $predefinedTrip->reference_number ?><br>
                    <?php echo $predefinedTrip->transportPackage->vehicle->vehicle_type ?><br>
                    <?php echo date('Y-m-d', strtotime($predefinedTrip->transportPackage->start_date)) ?><br>
                    <?php echo date('H:i', strtotime($predefinedTrip->pick_up_date_time)) ?><br>
                    <?php echo City::find($predefinedTrip->transportPackage->origin)->city; ?>
                    , <?php echo City::find($predefinedTrip->transportPackage->destination)->city; ?>
                    <br>
                    <?php echo number_format($predefinedTrip->transportPackage->rate * $predefinedTrip->transportPackage->millage, 2); ?>
                    <br>

                    <?php //echo number_format(TransportPackage::getPredefinedTripTotal($booking), 2); ?>

                </td>
            </tr>
        <?php } ?>
    <?php } ?>

<!--    <tr style="background: lightgrey">-->
<!--        <th>Total</th>-->
<!---->
<!--        <td align="right"><strong>USD --><?php //?><!--</strong></td>-->
<!---->
<!--    </tr>-->

</table>



