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
            'name' => ['required', Rule::unique('customers')->ignore($this->customer->id)],
            'email' => ['required','email',Rule::unique('customers')->ignore($this->customer->id)],
            'phone' => ['required', 'numeric', 'min:100000000', 'max:100000000000000', Rule::unique('customers')->ignore($this->customer->id)],
            'description' => 'max:400'
        ];
    }
}
