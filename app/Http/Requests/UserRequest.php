<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return match ($this->route()?->getName()) {
            'users.create' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users'],
                'email' => ['required', 'string', 'min:4', 'max:32', 'unique:users'],
                'password' => ['required', 'string', 'min:4', 'max:16'],
            ],
            'users.update' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users,username,' . $user->id],
                'email' => ['required', 'string', 'min:4', 'max:32', 'unique:users'],
                'password' => ['sometimes', 'string', 'min:4', 'max:16'],
            ],
            default => []
        };
    }
}
