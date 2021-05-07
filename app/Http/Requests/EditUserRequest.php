<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use Auth;


class EditUserRequest extends FormRequest
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
            'nickname' => ['required', 'max:20', Rule::unique('users')->ignore($this->user->id)],
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:100',
            'email' => ['required', 'string', 'email', 'max:50', Rule::unique('users')->ignore($this->user->id)],
            'phone' => ['numeric', 'min:100000000', 'max:100000000000000', 'nullable', Rule::unique('users')->ignore($this->user->id)],
            'description' => 'max:400',
            'password' => 'string|min:8|max:25|confirmed|nullable',
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
