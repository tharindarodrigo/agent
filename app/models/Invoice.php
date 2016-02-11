<?php

class Invoice extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = ['booking_id', 'amount'];


    public static function getInvoiceAmount($booking)
    {
        $total = 0;

        /**
         *  Hotel Booking Amount
         */
        if(count($booking->voucher)){
            foreach ($booking->voucher as $voucher) {
                $total += Voucher::getVoucherAmount($voucher);
            }
        }

        /**
         *  Transportation Bookings
         */

        return $total;
    }

    public function booking()
    {
        return $this->belongsTo('booking');
    }



    public static function amendInvoice($booking)
    {
        $total = Booking::getTotalBookingAmount($booking);

        $invoice = Invoice::where('booking_id', $booking->id)->first();
        if ($invoice) {
            $invoice->count = ++$invoice->count;
            $invoice->amount = $total;
            $invoice->save();

            return true;

        } else {
            $invoiceData = array(
                'amount' => $total,
                'booking_id' => $booking->id
            );

            Invoice::create($invoiceData);

            return false;
        }

    }



}