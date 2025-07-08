<?php

namespace Modules\Category\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [          
            'parent_category_id' => 'nullable|numeric',
            'title' => 'required|string|min:3|max:255|unique:categories,title,' . $this->route('category')->id,            
            'sort_order' => 'nullable|numeric|max:255',
            'status' => 'required|in:0,1',
        ];

        // Make image required if not exist
        if (!$this->route('category') || !$this->route('category')->image) {
            $rules['image'] = 'required|image';
        } else {
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
