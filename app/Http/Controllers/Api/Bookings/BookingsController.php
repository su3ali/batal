<?php

namespace App\Http\Controllers\Api\Bookings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingResource;
use App\Models\User;
use App\Support\Api\ApiResponse;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }
    protected function myBookings(){
        $user = User::with('bookings.booking_status', 'bookings.service.BookingSetting')->where('id', auth('sanctum')->user()->id)->first();
        $this->body['bookings'] = BookingResource::collection($user->bookings);
        return self::apiResponse(200, null, $this->body);
    }
}
