<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255|unique:announcements,title,' . $this->announcement?->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date_format:Y-m-d H:i|required_if:status,published',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The announcement title is required.',
            'title.unique' => 'An announcement with this title already exists.',
            'content.required' => 'The announcement content is required.',
            'content.min' => 'The content must be at least 10 characters.',
            'status.required' => 'Please select a status (draft or published).',
            'published_at.required_if' => 'Published date is required when status is published.',
            'image.mimes' => 'The image must be a valid image file (JPEG, PNG, GIF, WebP).',
            'image.max' => 'The image must not exceed 5MB.',
        ];
    }
}
