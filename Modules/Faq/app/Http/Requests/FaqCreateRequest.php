<?php

namespace Modules\Faq\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [                   
            'question' => 'required|string|min:3|max:255|unique:faqs,question',
            'answer' => 'required|string|min:3|max:65535',
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
