
<style type="text/css">
.CSSTableGenerator {
	margin:0px;padding:0px;
	width:100%;
	border:1px solid #000000;

	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;

	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;

	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;

	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;

}.CSSTableGenerator table{
    border-collapse: collapse;
    border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.CSSTableGenerator tr:hover td{

}
.CSSTableGenerator tr:nth-child(odd){ background-color:#aad4ff; }
.CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
	vertical-align:middle;


	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

	background-color:#005fbf;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #005fbf 5%, #003f7f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #005fbf), color-stop(1, #003f7f) );
	background:-moz-linear-gradient( center top, #005fbf 5%, #003f7f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#005fbf", endColorstr="#003f7f");	background: -o-linear-gradient(top,#005fbf,003f7f);

	background-color:#005fbf;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
</style>

<div style="background: #0099cc; padding: 1px; padding-left: 20px;">
    <h3>Reference No. : 123456789</h3>
</div>
<br/>


<div>

<table width="100%">
<tr>
<td><table >
    <thead style="text-align: left;">
    <tr>
        <th>Booking No</th>
        <td>: 4568796</td>
        </tr>
        <tr>
        <th>Agent Name</th>
        <td>: Tharinda</td>
        </tr>
        <tr>
        <th>Tour</th>
        <td>: Gem of Sri Lanka</td>
        </tr>
            <tr>
        <th>Remark</th>
        <td>: Pleas Note</td>
        </tr>
        </thead>
        </table>
</td>
<td></td>
<td>&nbsp;&nbsp;</td>
<td>
<table>
<thead style="text-align: left;">
<tr>
    <th>Arrival Date</th>
    <td>: 2015-02-04</td>
    </tr>
        <tr>
    <th>Departure Date</th>
    <td>: 2015-02-04</td>
    </tr>
        <tr>
    <th>Pax</th>
    <td>: Adults - 04 </td>
    </tr>
          <tr>
        <th>&nbsp;</th>
        <td>&nbsp;&nbsp;Children - 03</td>
        </tr>

</thead>
</table></td>

</tr>
</table>

</div>

<br/>

<div style="background: #0099cc; padding: 1px; padding-left: 20px;">
<h4>Hotel Details</h4>
</div>

<br/>

<div class="CSSTableGenerator">
    <table width="100%" >


<tr align="left">
    <td width="30%">Hotel Name</td>
    <td width="15%">Check In</td>
    <td width="15%">Check Out</td>
    <td width="20%">Room Type</td>
    <td width="10%">Basis</td>
    <td width="10%">No. of Rooms</td>

</tr>



<?php /*foreach($booking['client'] as $client) */?>
<?php foreach(Client::all() as $client){?>

    <tr>
        <td><?php $client['name']?></td>
        <td><?php $client['passport_number']?></td>
        <td><?php $client['dob']?></td>
        <td><?php $client['gender'] == 1 ? 'Male':'Female'?></td>
        <td><?php $client['gender'] == 1 ? 'Male':'Female'?></td>
        <td><?php $client['gender'] == 1 ? 'Male':'Female'?></td>
    </tr>
<?php } ?>

</table>
</div>

<br/>

<div style="background: #0099cc; padding: 1px; padding-left: 20px;">
    <h4>Client Details</h4>
</div>

<br/>

<div class="CSSTableGenerator">
    <table>

<tr align="left">
    <td width="50%">Name</td>
    <td width="20%" >Passport</td>
    <td width="20%">DoB</td>
    <td width="10%">Gender</td>
</tr>

<?php /* foreach($booking['client'] as $client) */?>
<?php foreach(Client::all() as $client) { ?>

    <tr>
        <td><?php $client['name']?></td>
        <td><?php $client['passport_number']?></td>
        <td><?php $client['dob']?></td>
        <td><?php $client['gender'] == 1 ? 'Male':'Female'?></td>
    </tr>
<?php } ?>

</table>
</div>


<br/>


<div>


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
    <?php /*foreach($booking['flight_detail'] as $flight)*/ ?>
        @foreach(FlightDetail::all() as $flight)

        <tr>
            <td><?php $flight['date']?></td>
            <td><?php $flight['time']?></td>
            <td><?php $flight['flight']?></td>
            <td><?php $flight['flight_type'] == 1 ? 'Arrival' : 'Departure' ?></td>
        </tr>
    @endforeach

</table>
</div>

<br/>
</div>

