<?php

namespace webmuscets\PageManager\Http\Requests;

use webmuscets\PageManager\Http\Requests\Request;

class LayoutRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'crud.layout.name' => 'required',
        ];
    }
}