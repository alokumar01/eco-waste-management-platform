<?php

namespace App\Http\Requests\Provider;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isProvider() === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'service_area' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string', 'max:1200'],
        ];
    }
}
