<?php namespace webmuscets\PageManager\Models;
use Illuminate\Database\Eloquent\Model;

class PageSectionItem extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_page_section_items";

}