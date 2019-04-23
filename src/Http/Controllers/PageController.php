<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller, Redirect;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Page,
	webmuscets\PageManager\Http\Requests\PageRequest,
	webmuscets\PageManager\Models\PageSection;

class PageController extends Controller {
	public function index()
	{
		$card = [
			'header' => [
				'caption' => 'Pages',
            	'actions' => [
	                [
	                    'url' =>  '/page-manager/pages/create',
	                    'caption' => 'New Page',
	                ],
                ]
			],
			'body' => Page::getTableView(),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function create() {
        $card = [
            'header' =>	['caption' => 'Create Page'],
            'body' => Page::getForm(),
        ];
        return view('page-manager::components.card',compact('card'));
	}

	public function store(PageRequest $request) {
		$page = new Page;
		$pageInputs = $request['crud']['page'];
		
		if(!isset($pageInputs['is_system']) || !$pageInputs['is_system'])
			$pageInputs['is_system'] = 0;

		$page->fill($pageInputs)->save();

		foreach ($request['crud']['page_sections'] as $key => $sectionInput) {
			$section = new PageSection;
			$section->page_id = $page->id;
			$section->fill($sectionInput)->save();
		}
		
		return Redirect::to('/page-manager');
	}

	public function edit($id) {
        $card = [
            'header' =>	['caption' => 'Edit Page'],
            'body' => Page::getForm($id),
        ];
        return view('page-manager::components.card',compact('card'));
	}

	public function update(PageRequest $request,$id) {
		$page = Page::findOrFail($id);
		$pageInputs = $request['crud']['page'];
		
		if(!isset($pageInputs['is_system']) || !$pageInputs['is_system'])
			$pageInputs['is_system'] = 0;

		$page->fill($pageInputs)->update();

		foreach ($request['crud']['page_sections'] as $key => $sectionInput) {
			$sectionInput['page_id'] = $page->id;
			PageSection::updateOrCreate(['id' => $sectionInput['id']], $sectionInput);
		}

        $deletableItems = isset($request['deletableItems']) && is_array($request['deletableItems']) ? $request['deletableItems'] : [];

        foreach ($deletableItems as $itemID) {
            $section = PageSection::findOrFail($itemID);
            $section->delete();
        }

		return Redirect::to('/page-manager');
	}

	public function destroy($id) {
		$item = Page::findOrFail($id);
		$item->delete();

		return Redirect::to('/page-manager');
	}
	
}
