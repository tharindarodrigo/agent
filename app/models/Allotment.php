<?php

class Allotment extends \Eloquent {

    // room allotments

    public static function allotmentsCount($room_id, $st_date, $ed_date)
    {

        $x = 0;
        $allotments = 0;

        $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $st_date)));
        $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $ed_date)));

        $dates = (strtotime($ed_date) - strtotime($st_date)) / 86400;

        for ($x = 1; $x <= $dates; $x++) {

            $get_allotments = Allotment::where('room_type_id', $room_id)
                ->where('from', '<=', $from_date)
                ->where('to', '>=', $from_date)
                ->get();

            foreach($get_allotments as $allotment){
                $allotments = $allotment->rooms;
            }

            $from_date = date('Y-m-d', strtotime($from_date . ' + 1 days'));

        }

        return ($allotments);

    }

	// Add your validation rules here
	public static $rules = [
		'room_type_id' => 'required',
        'from' => 'required|date',
        'to' => 'required|date|after:from',
        'rooms' => 'required|integer'
	];

	// Don't forget to fill this array
	protected $fillable = ['room_type_id','from','to','rooms','hotel_id', 'val', 'user_id'];

    public function roomType(){
        return $this->belongsTo('RoomType');
    }

}