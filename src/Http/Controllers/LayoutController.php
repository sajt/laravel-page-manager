<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller, Redirect;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Layout,
	webmuscets\PageManager\Http\Requests\LayoutRequest,
	webmuscets\PageManager\Models\LayoutSection;

class LayoutController extends Controller {
	public function index()
	{
		$card = [
			'header' => [
				'caption' => 'Layouts',
            	'actions' => [
	                [
	                    'url' =>  '/page-manager/layouts/create',
	                    'caption' => 'New Layout',
	                ],
                ]
			],
			'body' => Layout::getTableView(),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function create() {
        $card = [
            'header' =>	['caption' => 'Create Layout'],
            'body' => Layout::getForm(),
        ];
        return view('page-manager::components.card',compact('card'));
	}

	public function store(LayoutRequest $request) {
		$layout = new Layout;
		$layout->fill($request['crud']['layout'])->save();

		foreach ($request['crud']['layout_sections'] as $key => $sectionInput) {
			$section = new LayoutSection;
			$section->layout_id = $layout->id;
			$section->fill($sectionInput)->save();
		}
		
		return Redirect::to('/page-manager/layouts');
	}

	public function edit($id) {
        $card = [
            'header' =>	['caption' => 'Edit Layout'],
            'body' => Layout::getForm($id),
        ];
        return view('page-manager::components.card',compact('card'));
	}

	public function update(LayoutRequest $request,$id) {
		$layout = Layout::findOrFail($id);
		$layout->fill($request['crud']['page'])->update();

		foreach ($request['crud']['layout_sections'] as $key => $sectionInput) {
			$sectionInput['layout_id'] = $layout->id;
			LayoutSection::updateOrCreate(['id' => $sectionInput['id']], $sectionInput);
		}

        $deletableItems = isset($request['deletableItems']) && is_array($request['deletableItems']) ? $request['deletableItems'] : [];

        foreach ($deletableItems as $itemID) {
            $section = LayoutSection::findOrFail($itemID);
            $section->delete();
        }

		return Redirect::to('/page-manager/layouts');
	}

	public function destroy($id) {
		$item = Layout::findOrFail($id);
		$item->delete();

		return Redirect::to('/page-manager/layouts');
	}
	
}
