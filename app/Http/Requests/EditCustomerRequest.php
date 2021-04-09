<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditCustomerRequest extends FormRequest
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
            'name' => ['required', Rule::unique('customers')->ignore($this->id)],
            'email' => ['required','email',Rule::unique('customers')->ignore($this->id)],
            'phone' => ['required', 'numeric', 'min:100000000', 'max:100000000000000', Rule::unique('customers')->ignore($this->id)],
            'description' => 'max:400'
        ];
    }
}
