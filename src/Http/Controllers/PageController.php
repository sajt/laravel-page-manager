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
		
		foreach ($page->layout->sections as $key => $section) {
			$newSection = new PageSection;
			$sectionInput = [
				'page_id' => $page->id,
				'layout_section_id' => $section->id,
				'block' => $section->block,
				'caption' => $section->caption,
				'is_list' => $section->is_list,
			];
			$newSection->fill($sectionInput)->save();
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

		return Redirect::to('/page-manager');
	}

	public function destroy($id) {
		$item = Page::findOrFail($id);
		$item->delete();

		return Redirect::to('/page-manager');
	}
	
}
