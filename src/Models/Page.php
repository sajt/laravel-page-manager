<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class Page extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_pages";

    public function sections() {
    	return $this->hasMany(__NAMESPACE__.'\PageSection');
    }

    public static function getTableView() {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = ['title' => 'Title'];
        
        $table->items = self::where('is_article','=',0)->get();
        
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
            'page.title' => [ 
                'type' => 'text', 
                'label' => 'Title', 
                'attributes' => [ 
                    'required' => 'required',
                ]
            ],
            'page.slug' => [ 
                'type' => 'text', 
                'label' => 'Slug', 
                'attributes' => [ 
                    'required' => 'required',
                ]
            ], 
            'page_sections' => [
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

        $form->values = [
            'page.is_system' => 1,
        ];
    
        if($id) {
            $item = self::find($id);
            foreach ($item->toArray() as $name => $value) {
                $form->values['page.'.$name] = $value;
            }

            $form->fields['page_sections']['fields'][] = [ 'type' => 'hidden', 'property' => 'id'];
            $form->fields['page_sections']['rows'] = $item->sections;
        }

        $form->config = [
            'url' => $id ? $baseUrl.$id : $baseUrl,
            'method' => $id ? 'PUT' : 'POST',
            'files' => true,
        ];

        return $form->render();
    }

}