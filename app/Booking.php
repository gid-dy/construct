<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function bookings(){
        return $this->hasMany('App\BookingsService', 'Booking_id');
    }
    public static function getBookingDetails($Booking_id){
        $getBookingDetails = Booking::where('id', $Booking_id)->first();
        return $getBookingDetails;
    }
}
