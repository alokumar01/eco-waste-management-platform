<?php

namespace App\Http\Requests\Provider;

use App\Models\CompostingService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompostingServiceRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(array_keys(CompostingService::categories()))],
            'description' => ['required', 'string', 'min:40', 'max:3000'],
            'location' => ['required', 'string', 'max:255'],
            'service_radius_km' => ['nullable', 'integer', 'min:1', 'max:500'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'unit' => ['required', 'string', 'max:80'],
            'capacity_kg_per_week' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'availability' => ['nullable', 'string', 'max:1200'],
            'submit_for_review' => ['nullable', 'boolean'],
        ];
    }
}
