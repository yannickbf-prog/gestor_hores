<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditTypeBagHourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('type_bag_hours')->ignore($this->id)],
            'hour_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'max:400'
        ];
    }
    
    public function messages(){
        return [
            'hour_price.regex' => __('The price must have the next format: 20, 2000, 20.25 or 20,25 (example values).')
        ];
    }
}
