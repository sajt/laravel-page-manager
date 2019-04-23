<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class Layout extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_layouts";

    public function sections() {
    	return $this->hasMany(__NAMESPACE__.'\LayoutSection');
    }

    public static function getTableView() {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = ['name' => 'Name'];
        
        $table->items = self::all();
        
        foreach ($table->items as $key => $item) {
            $item->actions = view('page-manager::layouts.actions',compact('item'))->render();
        }
        return $table->render();
    }


    public static function getForm($id = false) {
        $baseUrl = '/page-manager/layouts/';
        $form = new Form;
        $form->fields = [
            'layout.name' => [ 
                'type' => 'text', 
                'label' => 'Name', 
                'attributes' => [ 
                    'required' => 'required',
                ]
            ],
            'layout_sections' => [
                'type' => 'multiline',
                'fields' => [
                    [
                        'type' => 'text',
                        'property' => 'block',
                        'label' => 'Inner block name',
                    ],
                    [
                        'type' => 'text',
                        'property' => 'caption',
                        'label' => 'Dashboard caption',
                    ],
                    [
                        'type' => 'select',
                        'property' => 'is_list',
                        'label' => 'Is list?',
                        'listItems' => [
                            0 => 'No',
                            1 => 'Yes',
                        ],
                    ],
                ],
            ],
        ];

        if($id) {
            $item = self::find($id);
            foreach ($item->toArray() as $name => $value) {
                $form->values['layout.'.$name] = $value;
            }

            $form->fields['layout_sections']['fields'][] = [ 'type' => 'hidden', 'property' => 'id'];
            $form->fields['layout_sections']['rows'] = $item->sections;
        }

        $form->config = [
            'url' => $id ? $baseUrl.$id : $baseUrl,
            'method' => $id ? 'PUT' : 'POST',
            'files' => true,
        ];

        return $form->render();
    }

}