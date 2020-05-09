<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use App\Events\BookingCreatedEvent;

class BookingController extends Controller
{
    public function get()
    {
        // Todo get by calender view only not the whole thing

        return response()->json([
            'status' => 'ok',
            'data' => Booking::all()
        ], 200);
    }

    public function create(Request $request)
    {
        // Todo Check if customer has done a booking in the same hour, max 3 weeks from now, cannot book in the past
        event(new BookingCreatedEvent('booking created bro'));

        return response()->json([
            'status' => 'ok'
        ], 200);
    }
}
