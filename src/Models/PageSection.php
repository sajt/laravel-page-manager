<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class PageSection extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_page_sections";

    public function page() {
      return $this->belongsTo('App\Models\Page');
    }

    public function items() {
      return $this->hasMany('App\Models\PageSectionItem');
    }

    public static function getTableView($pageID) {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = [
            'caption' => 'Section',
        ];

        $table->items = self::where('page_id','=',$pageID)->get();

        foreach ($table->items as $key => $item) {
            $item->actions = view('page-manager::page-sections.actions',compact('item'))->render();
        }
        return $table->render();
    }

}

