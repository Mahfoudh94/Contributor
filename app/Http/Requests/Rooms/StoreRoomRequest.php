<?php

namespace App\Http\Requests\Rooms;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'repository' => 'required|string',
            'branch' => 'required|string',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'start_at' => 'sometimes|date|after:now'
        ];
    }
}
