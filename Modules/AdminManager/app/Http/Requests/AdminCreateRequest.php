<?php

namespace Modules\AdminManager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use tidy;

class AdminCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [                   
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admins,email',
                'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/'
            ],
            'first_name' => 'nullable|string|min:3|max:255',
            'last_name' => 'nullable|string|min:3|max:255',
            'mobile' => 'required|digits_between:7,15|numeric',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
