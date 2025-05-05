<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Event $event): JsonResponse
    {
        $review = Review::create([
            'user_id'  => Auth::id(),
            'event_id' => $event->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return response()->json([
            'message' => 'Reseña guardada con éxito.',
            'review'  => $review,
        ], 201);
    }


    public function index(Event $event): JsonResponse
    {
        $reviews = $event->reviews()->with('user')->get();
        $average = $reviews->avg('rating');

        return response()->json([
            'average_rating' => round($average, 2),
            'reviews' => $reviews,
        ]);
    }
}
