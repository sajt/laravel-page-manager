<?php

namespace App\Http\Requests;

class PageRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'crud.title' => 'required',
        ];
    }
}