<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function store(StoreEventRequest $request): JsonResponse
    {
        $data = $request->validated();
      
        $data['user_id'] = Auth::id();

        $event = Event::create($data);

        return response()->json([
            'message' => 'Evento creado con éxito.',
            'event' => $event,
        ], 201);
    }


    public function index(): JsonResponse
    {
        $events = Event::with('user')
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();

        return response()->json($events);
    }
}
