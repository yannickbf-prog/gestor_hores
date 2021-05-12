<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class CreateTypeBagHourRequest extends FormRequest
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
    
    protected function prepareForValidation()
    {
        $format_num = str_replace(",", ".", $this->hour_price);
        $this->merge(['hour_price' => $format_num]);
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
            
            'name' => 'required|unique:type_bag_hours|max:50',
            'hour_price' => 'required|regex:/^\d+(\.\d{1,2})?$/|max:10',
            'description' => 'max:400'
                
        ];
    }
    
    public function messages(){
        return [
            'hour_price.regex' => __('message.hour_format')
        ];
    }
}
