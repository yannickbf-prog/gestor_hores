<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use Auth;

class EditCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->isAdmin()){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        App::setLocale($this->lang);
        
        return [
            'name' => ['required', Rule::unique('customers')->ignore($this->customer->id), 'max:50'],
            'email' => ['required','email',Rule::unique('customers')->ignore($this->customer->id), 'max:50'],
            'phone' => ['required', 'numeric', 'min:100000000', 'max:100000000000000', Rule::unique('customers')->ignore($this->customer->id)],
            'tax_number' => ['required', Rule::unique('customers')->ignore($this->customer->id), 'regex:/^\d{8}[a-zA-Z]{1}$/'],
            'contact_person' => 'max:150',
            'description' => 'max:400'
        ];
    }
    public function messages() 
    {
        return [
            'phone.numeric' => __('message.phone_numeric'),
            'phone.min' => __('message.phone_min'),
            'phone.max' => __('message.phone_max')
        ];
    }
}
