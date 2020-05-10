<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Services\UserService;
use App\User;
use App\Validators\Booking as BookingValidator;
use App\Validators\UserExists;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\BookingCreatedEvent;

class BookingController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $validator = BookingValidator::make($request->all());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => ['message' => [
                    'error' => $validator->errors(),
                ]]]);
        }

        if (!$this->sameSlotBookingCheck($request))
        {
            return response()->json([
                'status' => 'error',
                'data' => ['message' => [
                    'error' => 'Slot already occupied'
                ]
                ]]);
        }

        $user = null;
        $userExistsValidator = UserExists::make($request->all());

        if ($userExistsValidator->fails())
        {
            $start = $request->get('start');
            $email = $request->get('email');
            $user = User::where('email', $email)->first();

            if($this->sameHourBookingCheck($user, $start))
            {
                return response()->json([
                    'status' => 'error',
                    'data' => ['message' => [
                        'error' => 'Booking was created recently'
                    ]]]);
            };

        } else {
            $user = $this->userService->create($request->all());
        }

        Booking::create([
            'user_id' => $user['id'],
            'title' => $user['name'],
            'start' => Carbon::parse($request->get('start')),
            'resourceId' => $request->get('resourceId')
        ]);

        event(new BookingCreatedEvent('booking created'));

        return response()->json([
            'status' => 'ok'
        ], 200);

    }

    private function sameHourBookingCheck(User $user, $start)
    {
        $datePlus = Carbon::parse($start)->addMinutes(30);
        $dateMinus = Carbon::parse($start)->addMinutes(-30);

        $bookingsCount = Booking::where('user_id', $user['id'])
            ->whereBetween('start', array($dateMinus, $datePlus))
            ->count();

        return $bookingsCount > 0;
    }

    private function sameSlotBookingCheck($request) {
        $resourceId = $request->get('resourceId');
        $start = $request->get('start');

        $bookingsCount = Booking::where('resourceId', $resourceId)
            ->where('start', $start)
            ->count();

        return $bookingsCount === 0;
    }
}
