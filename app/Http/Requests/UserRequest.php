<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $path = $this->path();
        switch ($path) {
            case 'api/user/info':
                return [
                    'uid' => 'required|int',
                ];
            case 'api/user/search':
                return [
                    's' => ['required','string','min:1','max:10000','regex:/^[()\[\]{}]+$/'],
                ];
            default:
                return [];
        }

    }
}
