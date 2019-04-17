<?php 
namespace webmuscets\PageManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use webmuscets\PageManager\Models\Page;
use webmuscets\TableManager\Table;

class PageController extends Controller {
	public function index()
	{
		$table = new Table;
		$table->fields = [
			'name' => 'Név',
			'id' => 'ID',
		];
		$table->items = Page::all();

		$card = [
			'header' => [
				'caption' => 'Pages',
			],
			'body' => $table->render(),
		];
		return view('page-manager::components.card',compact('card'));
	}
}
