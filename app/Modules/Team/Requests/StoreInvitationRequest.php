<?php

namespace App\Modules\Team\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'unique:user_invitations,email',
            ],
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'There is already an invitation for this email.',
        ];
    }
}
