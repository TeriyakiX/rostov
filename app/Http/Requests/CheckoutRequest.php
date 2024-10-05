<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     *   "is_fiz" => "1"
     *   "name" => "test"
     *   "phone_number" => "535353"
     *   "email" => "test@mail.ru"
     *   "form" => array:2 [▶]
     *   "file2" => null
     *   "delivery_type_id" => "1"
     *   "address" => "test address"
     *   "customer_comment" => "test"
     *   "payment_type_id" => "2"
     *   "confirm" => "1"
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required_if:delivery_type_id,1',
            'confirm' => 'accepted',
            'file' => 'nullable|file|mimes:jpeg,pdf',
            'file2' => 'nullable|file|mimes:jpeg,pdf'
        ];
    }
}
