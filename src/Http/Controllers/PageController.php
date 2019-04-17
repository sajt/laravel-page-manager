<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Page;

class PageController extends Controller {
	public function index()
	{

		$pages = Page::all();
		$card = [
			'header' => [
				'caption' => 'Pages',
			],
			'body' => view('page-manager::pages',compact('pages'))->render(),
		];
		return view('page-manager::components.card',compact('card'));
	}
}
