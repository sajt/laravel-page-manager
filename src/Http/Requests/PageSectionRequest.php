<?php

namespace App\Http\Requests;

class PageSectionRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}