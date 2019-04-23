<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller, Redirect;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Page,
	webmuscets\PageManager\Http\Requests\PageFieldRequest,
	webmuscets\PageManager\Models\PageSection,
	webmuscets\PageManager\Models\PageField;

class PageFieldController extends Controller {
	public function sections($pageID)
	{
		$page = Page::findOrFail($pageID);
		$card = [
			'header' => [
				'caption' => $page->slug.' / sections',
            	'actions' => [
	                [
	                    'url' =>  '/page-manager',
	                    'caption' => 'Back',
	                ],
                ]
			],
			'body' => PageSection::getTableView($pageID),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function listFields($pageID, $sectionID) {
		$page = Page::findOrFail($pageID);
		$section = PageSection::findOrFail($sectionID);
		$card = [
			'header' => [
				'caption' => $page->slug. '/ sections / ' .$section->caption,
            	'actions' => [
	                [
	                    'url' =>  '/page-manager/pages/'.$pageID.'/sections',
	                    'caption' => 'Back',
	                ],
                ]
			],
			'body' => PageField::getForm($sectionID),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function updateFields(PageFieldRequest $request, $sectionID) {
		foreach ($request['crud']['fields'] as $key => $input) {
			$input['page_section_id'] = $sectionID;
			PageField::updateOrCreate(['id' => $input['id']], $input);
		}

        $deletableItems = isset($request['deletableItems']) && is_array($request['deletableItems']) ? $request['deletableItems'] : [];

        foreach ($deletableItems as $itemID) {
            $section = PageField::findOrFail($itemID);
            $section->delete();
        }

        $section = PageSection::findOrfail($sectionID);
        $page = Page::findOrfail($section->page_id);
        return Redirect::to('/page-manager/pages/'.$page->id.'/sections');
	}
	
}
