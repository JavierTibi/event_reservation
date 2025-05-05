<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class ReservationRequest extends FormRequest
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
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $event = $this->route('event');

            if (! $event) {
                $validator->errors()->add('event', 'El evento no existe.');
                return;
            }

            if (Carbon::parse($event->reservation_deadline)->isPast()) {
                $validator->errors()->add('deadline', 'Ya pasó la fecha límite para reservar.');
            }

            if ($event->reservations()->count() >= $event->attendee_limit) {
                $validator->errors()->add('limit', 'Se alcanzó el límite de asistentes.');
            }

            if ($event->reservations()->where('user_id', $this->user()->id)->exists()) {
                $validator->errors()->add('duplicate', 'Ya reservaste este evento.');
            }
        });
    }
}
