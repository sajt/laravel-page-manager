<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model,
    App\Libraries\FormManager\Render\Form,
    App\Libraries\FormManager\Creator\Form as FormManager,
    App\Libraries\DataTable\Table;

class PageSection extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_sections";

    public function page() {
      return $this->belongsTo('App\Models\Page');
    }

    public function blockType() {
      return $this->belongsTo('App\Models\PageBlockType');
    }

    public function items() {
      return $this->hasMany('App\Models\PageSectionItem');
    }

    public static function inputTypes($type) {
      $types = [
        'title' => 'text',
        'headline' => 'textarea',
        'description' => 'textarea',
        'img' => 'file',
        'video' => 'file',
        'yt_video' => 'text',
      ];

      return $types[$type];
    }

    public static function setItem($content = false,$input) {
      $content = $content && is_array(unserialize($content)) ? unserialize($content) : [];

      foreach ($input as $property => $value) {
        if($property == 'img' && $value) {          
          $picture = Picture::find(Picture::add($value));
          $content[$property] = '/pictures/'.$picture->filename;
        }

        if ($property != 'img')
          $content[$property] = $value;
      }
      return serialize($content);
    }

    public static function getTableView($pageID) {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = [
            'caption' => 'Szekció neve',
        ];

        $table->items = self::where('page_id','=',$pageID)->get();

        foreach ($table->items as $key => $item) {
            $item->actions = view('admin.modules.page-sections.actions',['id' => $item->id])->render();
        }
        return $table->render();
    }


    public static function getForm($id) {
        $form = new Form;
        $form->fields = [];

        $item = self::find($id);
        $blockTypes = $item->blockType->getFieldlist();
        
        if($item->is_list)
          $form->fields = PageSectionItem::getFormFields($blockTypes,$item->items);
        else {
          foreach ($blockTypes as $key => $value) {
            $form->fields[$key] = [
              'label' => trans('block_types.'.$key),
              'type' => self::inputTypes($key),
            ];        
          }
          $content = unserialize($item->content);
          $content = $content && is_array($content) ? $content : [];
          foreach ($content as $name => $value) {
            $form->values[$name] = $value;
          }
        }

        $form->config = [
            'url' => '/dashboard/page-sections/'.$id,
            'method' => 'PUT',
            'files' => true,
        ];

        return $form->render();

    }
}

