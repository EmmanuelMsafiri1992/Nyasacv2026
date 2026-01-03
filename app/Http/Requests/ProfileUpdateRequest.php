<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
                function ($attribute, $value, $fail) {
                    // Block URLs, links, and common spam patterns
                    if (preg_match('/(https?:\/\/|www\.|\.com|\.net|\.org|\.io|\.co|http)/i', $value)) {
                        $fail(__('The :attribute cannot contain URLs or links.'));
                    }
                    // Block common spam patterns
                    if (preg_match('/(\$\d+|\d+\$|payment|confirm|transaction|click here|hs=|xxx)/i', $value)) {
                        $fail(__('The :attribute contains invalid content.'));
                    }
                },
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
