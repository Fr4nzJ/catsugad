<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGADCoordinatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $coordinatorId = $this->route('gad_coordinator')?->id;

        return [
            'college_id' => [
                'required',
                'exists:colleges,id',
                Rule::unique('gad_coordinators', 'college_id')
                    ->ignore($coordinatorId),
            ],
            'name' => 'required|string|max:255',
            'email' => 'nullable|email:rfc,dns|max:255',
            'contact_number' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'college_id.required' => 'Please select a college.',
            'college_id.exists' => 'The selected college does not exist.',
            'college_id.unique' => 'This college already has a GAD Coordinator assigned.',
            'name.required' => 'Coordinator name is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'contact_number.max' => 'Contact number must not exceed 20 characters.',
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'Image must be JPEG, PNG, JPG, GIF, or WebP.',
            'photo.max' => 'Image must not exceed 2MB.',
        ];
    }
}
