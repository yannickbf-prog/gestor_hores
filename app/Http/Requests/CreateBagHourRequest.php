<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Auth;

class CreateBagHourRequest extends FormRequest {

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

    protected function prepareForValidation() {
        
        $type_str = $this->type_id;
        
        $type_obj = json_decode($type_str, true);   
        
        echo var_dump($type_obj);
        
        $type_id = $type_obj["bht_id"];
        
        $this->merge(['type_id' => $type_id]);
        
        $format_num = str_replace(",", ".", $this->total_price);
        $this->merge(['total_price' => $format_num]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        App::setLocale($this->lang);

        return [
            'type_id' => 'required|numeric',
            'project_id' => 'required|numeric',
            'contracted_hours' => 'required|numeric|max:100000000',
            'total_price' => 'required|numeric|max:9999999',
        ];
    }

}
