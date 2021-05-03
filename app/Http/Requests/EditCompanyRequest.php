<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class EditCompanyRequest extends FormRequest
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
            'name' => 'required|max:50',
            'img_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'work_sector' => 'required|max:70',
            'description' => 'max:400',
            'email' => 'email|max:50',
            'phone' => 'numeric||min:100000000||max:100000000000000',
            'website' => 'nullable|url|max:50',
            'default_lang' => 'required|min:2|max:2'
        ];
    }
    
}
