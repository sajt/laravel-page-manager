<?php

namespace webmuscets\PageManager\Http\Requests;

use webmuscets\PageManager\Http\Requests\Request;

class PageRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'crud.page.slug' => 'required',
        	'crud.page.layout_id' => 'required',
        ];
    }
}