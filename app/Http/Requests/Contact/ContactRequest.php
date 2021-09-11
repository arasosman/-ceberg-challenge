<?php

namespace App\Http\Requests\Contact;

use App\Rules\ValidatePostcode;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'address' => 'string',
            'postcode' => ['string', new ValidatePostcode]
        ];
    }
}
