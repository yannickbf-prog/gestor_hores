<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class EditUserHourEntryRequest extends FormRequest
{
/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
        /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        if (Auth::user()->isUser()) {
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
    public function rules() {
        App::setLocale($this->lang);

        return [
            "days" => "required",
            "days.*" => ["required", "string", "date_format:d/m/Y", 'before_or_equal:' . now()->format('d/m/Y')],
            "hours" => "required|array",
            "hours.*" => "required|int|min:1|max:24",
            "customers" => "required|array",
            "customers.*" => "required|string",
            "projects" => "required|array",
            "projects.*" => "required|string",
            //"inputed_hours" => "required|array",
            //"inputed_hours.*" => "required|int|min:1|max:24",
            "desc" => "required|array",
            "desc.*" => "required|string|min:5|max:1000",
        ];
    }
    
    public function messages(){
        return [
            'days.*.required' => 'days_required',
            'days.*.string' => 'days_string',
            'days.*.date_format' => 'days_date_format',
            'days.*.before_or_equal' => 'days_before_or_equal',
            'hours.*.required' => 'hours_required',
            'hours.*.int' => 'hours_int',
            'hours.*.min' => 'hours_min',
            'hours.*.max' => 'hours_max',
//            'users.*.required' => 'users_required',
//            'users.*.string' => 'users_string',
            'desc.*.required' => 'desc_required',
            'desc.*.string' => 'desc_string',
            'desc.*.min' => 'desc_min',
            'desc.*.max' => 'desc_max',
            
        ];
    }
}
