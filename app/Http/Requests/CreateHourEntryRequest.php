<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class CreateHourEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        if (Auth::user()->isAdmin()) {
            return true;
        } else {
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
            'users' => 'required',
            'projects' => 'required|required_without:no_project|numeric',
            'bag_hours' => 'required|required_without:no_bag_hour|numeric',
            'hours' => 'required|numeric',
            'validate' => 'required|required_with:0,1|numeric'
        ];
    }
}
