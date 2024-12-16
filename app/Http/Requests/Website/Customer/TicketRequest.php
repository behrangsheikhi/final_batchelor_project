<?php

namespace App\Http\Requests\Website\Customer;

use App\Models\Admin\Ticket\TicketCategory;
use App\Models\Admin\Ticket\TicketPriority;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\returnArgument;

class   TicketRequest extends FormRequest
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
            'subject' => 'sometimes|persian_alpha_num|max:64',
            'description' => 'required|persian_alpha_num|max:255',
            'ticket_category_id' => 'required|exists:'.TicketCategory::class.',id',
            'ticket_priority_id' => 'required|exists:'.TicketPriority::class.',id',
        ];
    }

    public function attributes(): array
    {
        return [
            'subject' => 'موضوع',
            'description' => 'متن تیکت',
            'ticket_category_id' => 'دسته بندی تیکت',
            'ticket_priority_id' => 'درجه اهمیت موضوع'
        ];
    }
}
