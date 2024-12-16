<?php

namespace App\Http\Requests\Admin\Ticket;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check())
            return true;
        return false;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'description' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'description' => 'پاسخ تیکت',
        ];
    }
}
