<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model,
    Cviebrock\EloquentSluggable\Sluggable,
    App\Libraries\FormManager\Render\Form,
    App\Libraries\FormManager\Creator\Form as FormManager,
    App\Libraries\DataTable\Table;

class Page extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "pages";

    use Sluggable;

    public function sluggable() {
        return ['slug' => ['source' => 'title']];
    }

    public function picture() {
    	return $this->belongsTo('\App\Models\Picture');
    }

    public function pageSections() {
    	return $this->hasMany('\App\Models\PageSection');
    }

    public function getContent() {
      $sections = [];
      foreach ($this->pageSections as $key => $section) {
	      $content = [];
	      if ($section->content)
	          $content =  unserialize($section->content);

	      if (isset($content['item']) && !isset($content['items']))
	      	$content = $content['item'];
 
	      if (isset($content['items']) && !isset($content['item']))
	      	$content = $content['items'];
	      
	      $sections[$section->name] = $content;
      }

      return $sections;
    }

    public static function getTableView($languageID = false) {
        $table = new Table;
        $table->hasAction = true;
        $table->fields = [
            'title' => 'Cím',
            'link' => 'Link',
        ];
        
        if(!$languageID)
            $table->items = self::where('language_id','=',Language::siteLanguageID());
        else 
            $table->items = self::where('language_id','=',$languageID);

        $table->items = $table->items->get();
        
        foreach ($table->items as $key => $item) {
            $item->actions = view('admin.modules.pages.actions',compact('item'))->render();
            $item->link = view('admin.modules.pages.link',compact('item'))->render();
        }
        return $table->render();
    }


    public static function getForm($id = false) {
        $baseUrl = '/dashboard/pages/';
        $form = new Form;
        $form->fields = FormManager::getFields('pages');
        $form->lists = [
            'language_id' => Language::getLanguageNames(),
        ];
        
        if($id) {
            $item = self::find($id)->toArray();
            foreach ($item as $name => $value) {
                $form->values[$name] = $value;
            }
        }

        $form->config = [
            'url' => $id ? $baseUrl.$id : $baseUrl,
            'method' => $id ? 'PUT' : 'POST',
            'files' => true,
        ];

        return $form->render();
    }




}