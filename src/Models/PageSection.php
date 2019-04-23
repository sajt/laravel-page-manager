<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class PageSection extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_page_sections";

    public function page() {
      return $this->belongsTo(__NAMESPACE__.'\Page');
    }

    public function items() {
      return $this->hasMany(__NAMESPACE__.'\PageSectionItem');
    }

}