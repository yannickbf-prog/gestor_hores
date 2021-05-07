<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class CreateUserRequest extends FormRequest
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
            'nickname' => 'unique:users|max:20',
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'unique:users|numeric||min:100000000||max:100000000000000|nullable',
            'description' => 'max:400',
            'password' => 'required|string|min:8',
            'role' => 'required'
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
