<?php

namespace Modules\Banner\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [          
            'title' => 'required|string|min:3|max:255|unique:banners,title,' . $this->route('banner')->id,            
            'sub_title' => 'nullable|string|max:255',
            'button_title' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'sort_order' => 'required|numeric|min:0|max:2147483647|unique:banners,sort_order,' . $this->route('banner')->id,
            'description' => 'required|string|min:3|max:65535',
            'status' => 'required|boolean',
        ];

        // Make image required if not exist
        if (!$this->route('banner') || !$this->route('banner')->image) {
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
