<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CreateCustomerRequest extends FormRequest
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
            
            'name' => 'unique:customers||required',
            'email' => 'unique:customers||required||email',
            'phone' => 'unique:customers||required||numeric||min:100000000||max:100000000000000',
            'description' => 'max:400'
        
        ];
    }
    
    public function messages() 
    {
        return [
            'phone.min' => __('message.phone_min'),
            'phone.max' => __('message.phone_max')
        ];
    }
}
