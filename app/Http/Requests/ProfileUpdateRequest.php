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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['string', 'max:20', 'required', 'unique:users,phone_number,' . $this->user()->id, 'regex:/^[0-9\-\+\(\)\s]+$/'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_image' => ['nullable', 'in:0,1'],
            // 'email' => [
            //     'required',
            //     'string',
            //     'lowercase',
            //     'email',
            //     'max:255',
            //     Rule::unique(User::class)->ignore($this->user()->id),
            // ],
        ];
    }
}
