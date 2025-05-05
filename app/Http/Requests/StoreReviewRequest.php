<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $event = $this->route('event');

            if (!$event) {
                $validator->errors()->add('event', 'El evento no existe.');
                return;
            }

            if (!$event->reservations()->where('user_id', $this->user()->id)->exists()) {
                $validator->errors()->add('access', 'Solo los asistentes pueden dejar una reseña.');
            }

            if ($event->reviews()->where('user_id', $this->user()->id)->exists()) {
                $validator->errors()->add('duplicate', 'Ya dejaste una reseña para este evento.');
            }
        });
    }
}
