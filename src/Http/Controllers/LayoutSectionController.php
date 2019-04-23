<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller, Redirect;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Layout,
	webmuscets\PageManager\Http\Requests\LayoutSectionFieldRequest,
	webmuscets\PageManager\Models\LayoutSection,
	webmuscets\PageManager\Models\LayoutSectionField;

class LayoutSectionController extends Controller {
	public function sections($layoutID)
	{
		$layout = Layout::findOrFail($layoutID);
		$card = [
			'header' => [
				'caption' => $layout->name.' / sections',
            	'actions' => [
	                [
	                    'url' =>  '/page-manager/layouts',
	                    'caption' => 'Back',
	                ],
                ]
			],
			'body' => LayoutSection::getTableView($layoutID),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function listFields($layoutID, $sectionID) {
		$layout = Layout::findOrFail($layoutID);
		$section = LayoutSection::findOrFail($sectionID);
		$card = [
			'header' => [
				'caption' => $layout->name. '/ sections / ' .$section->caption,
            	'actions' => [
	                [
	                    'url' =>  '/page-manager/layouts/'.$layoutID.'/sections',
	                    'caption' => 'Back',
	                ],
                ]
			],
			'body' => LayoutSectionField::getForm($sectionID),
		];
		return view('page-manager::components.card',compact('card'));
	}

	public function updateFields(LayoutSectionFieldRequest $request, $sectionID) {
		foreach ($request['crud']['fields'] as $key => $input) {
			$input['layout_section_id'] = $sectionID;
			LayoutSectionField::updateOrCreate(['id' => $input['id']], $input);
		}

        $deletableItems = isset($request['deletableItems']) && is_array($request['deletableItems']) ? $request['deletableItems'] : [];

        foreach ($deletableItems as $itemID) {
            $section = LayoutSectionField::findOrFail($itemID);
            $section->delete();
        }

        $section = LayoutSection::findOrfail($sectionID);
        $layout = Layout::findOrfail($section->layout_id);
        return Redirect::to('/page-manager/layouts/'.$layout->id.'/sections');
	}
	
}
