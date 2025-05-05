<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    public function reserve(ReservationRequest $request, Event $event): JsonResponse
    {
        $reservation = Reservation::create([
            'user_id'  => Auth::id(),
            'event_id' => $event->id,
        ]);

        return response()->json([
            'message' => 'Reserva realizada con éxito.',
            'reservation' => $reservation,
        ], 201);
    }
}
