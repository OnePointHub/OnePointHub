<?php

namespace Modules\Tickets\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subject' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'priority' => [
                'required',
                Rule::in(['Low', 'Medium', 'High', 'Urgent']),
            ],
        ];
    }
}
