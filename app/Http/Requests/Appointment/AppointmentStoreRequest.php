<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'address' => 'string',
            'postcode' => 'required|string',
            'appointment_date' => 'required|date|date_format:Y-m-d H:i:s|after:now',
            'out_of_office_date' => 'date|date_format:Y-m-d H:i:s|after:now',
            'back_to_office_date' => 'date|date_format:Y-m-d H:i:s|after:now',
            'contact_id' => 'required|integer|exists:contacts,id',
            'consultant_id' => 'required|integer|exists:users,id'
        ];
    }
}
