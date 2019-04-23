<?php

namespace webmuscets\PageManager\Http\Requests;

use webmuscets\PageManager\Http\Requests\Request;

class LayoutSectionFieldRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'crud.fields.*.name' => 'required',
        	'crud.fields.*.type' => 'required',
        ];
    }
}