<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class LayoutSection extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_layout_sections";

    public function layout() {
      return $this->belongsTo(__NAMESPACE__.'\Layout');
    }

    public function fields() {
      return $this->hasMany(__NAMESPACE__.'\LayoutSectionField');
    }

    public static function getTableView($layoutID) {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = [
            'caption' => 'Section',
        ];

        $table->items = self::where('layout_id','=',$layoutID)->get();

        foreach ($table->items as $key => $item) {
            $item->actions = view('page-manager::layout-sections.actions',compact('item'))->render();
        }
        return $table->render();
    }

}

