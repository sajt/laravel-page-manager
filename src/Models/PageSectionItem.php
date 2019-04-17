<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSectionItem extends Model {
    protected $guarded = array('id','created_at','updated_at');
    protected $table = "page_section_items";

    public static function setItems($request,$sectionID) {
		$deletableItems = isset($request['deletableItems']) && is_array($request['deletableItems']) ? $request['deletableItems'] : [];

        foreach ($deletableItems as $itemID) {
            $item = self::findOrFail($itemID);
            $item->delete();
        }
        foreach ($request['crud']['items'] as $key => $input) {
        	if($input['id']) {
	       		$sectionItem = self::find($input['id']);
	       		$content = PageSection::setItem($sectionItem->content, $input);
    			$sectionItem->fill(['content' => $content])->update();
        	} else {
        		self::create([
        			'page_section_id' => $sectionID,
        			'content' => PageSection::setItem(false, $input),
        		]);
        	}
        }
    }

    public static function getFormFields($blockTypes,$items) {
    	$fields = [];

		$fields['items'] = [
		  'type' => 'multiline',
		  'config' => ['size' => 'full'],
		];

		foreach ($blockTypes as $key => $value) {
			$fields['items']['fields'][] = [
			      'type' => PageSection::inputTypes($key),
			      'property' => $key,
			      'label' => trans('block_types.'.$key),
			];
		}

		$fields['items']['fields'][] = [
			'type' => 'hidden',
			'property' => 'id',
		];

		foreach ($items as $sectionItem) {
			$content = unserialize($sectionItem->content);
			$content = $content && is_array($content) ? $content : [];
			$fields['items']['rows'][] = ['id' => $sectionItem->id] + $content; 
		}

		return $fields;    	
    }
}