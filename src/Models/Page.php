<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model, DB,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class Page extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_pages";

    public function sections() {
    	return $this->hasMany(__NAMESPACE__.'\PageSection');
    }

    public function layout() {
        return $this->belongsTo(__NAMESPACE__.'\Layout');
    }

    public static function getTableView() {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = ['slug' => 'URL'];
        
        $table->items = self::all();
        
        foreach ($table->items as $key => $item) {
            $item->actions = view('page-manager::pages.actions',compact('item'))->render();
        }
        return $table->render();
    }


    public static function getForm($id = false) {
        $baseUrl = '/page-manager/pages/';
        $form = new Form;
        $form->fields = [
            'page.is_system' => [
                'type' => 'checkbox',
                'label' => 'Is system?',
            ],
            'page.slug' => [ 
                'type' => 'text', 
                'label' => 'Slug', 
                'attributes' => [ 
                    'required' => 'required',
                ]
            ],
        ];

        if(config('page-manager.languages')) {
            $form->fields['page.internal_url'] = [ 
                'type' => 'text', 
                'label' => 'Internal URI (Group)',
            ];

            $form->fields['page.language_id'] = [
                'type' => 'select',
                'label' => 'Language',
            ];

            $form->lists['page.language_id'] = DB::table(config('page-manager.languages_table'))->pluck(config('page-manager.languages_name_field'),'id')->all();
        }


        $form->values = ['page.is_system' => 1];

        if($id) {
            $item = self::find($id);
            foreach ($item->toArray() as $name => $value) {
                $form->values['page.'.$name] = $value;
            }
        } else {
            $form->fields['page.layout_id'] = [
                'type' => 'select',
                'label' => 'Layout',
            ];

            $form->lists['page.layout_id'] = Layout::pluck('name','id')->all();
        }

        $form->config = [
            'url' => $id ? $baseUrl.$id : $baseUrl,
            'method' => $id ? 'PUT' : 'POST',
            'files' => true,
        ];

        return $form->render();
    }

}