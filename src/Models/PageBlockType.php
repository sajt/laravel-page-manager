<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlockType extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_block_types";


    public function getFieldList() {
    	$fields = [];
    	foreach ($this->toArray() as $key => $value) {
    		if($value && $key != 'id')
    			$fields[$key] = $value;
    	}

    	return $fields;
    }

}

