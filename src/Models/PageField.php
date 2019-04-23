<?php namespace webmuscets\PageManager\Models;

use Illuminate\Database\Eloquent\Model,
    webmuscets\FormManager\Render\Form,
    webmuscets\FormManager\Creator\Form as FormManager,
    webmuscets\TableManager\Table;

class PageField extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_manager_page_section_fields";

    public static function getFieldTypes() {
        return [
            'title' => 'title',
            'headline' => 'headline',
            'description' => 'description',
            'picture' => 'picture',
            'video' => 'video',
            'yt_video' => 'yt_video',
        ];
    }

    public static function getForm($sectionID) {
        $baseUrl = '/page-manager/page-sections/'.$sectionID.'/fields';
        $form = new Form;
        $form->fields = [
            'fields' => [
                'type' => 'multiline',
                'fields' => [
                    [
                        'type' => 'hidden',
                        'property' => 'id',
                    ],
                    [
                        'type' => 'hidden',
                        'property' => 'page_section_id',
                    ],
                    [
                        'type' => 'text',
                        'property' => 'name',
                        'placeholder' => 'title',
                    ],
                    [
                        'type' => 'select',
                        'property' => 'type',
                        'listItems' => self::getFieldTypes(),
                    ],
                ],
            ],
        ];
    
        $items = self::where('page_section_id','=',$sectionID)->get();

        $form->fields['fields']['rows'] = $items;

        $form->config = [
            'url' => $baseUrl,
            'method' => 'PUT',
        ];

        return $form->render();
    }
}