<?php
    

 Route::group(['namespace' => 'webmuscets\PageManager\Http\Controllers','prefix' => 'page-manager', 'middleware' => ['web']], function(){
    Route::get('/', 'PageController@index');

    Route::resource('/pages','PageController');
    //Route::get('/pages/{id}/sections','PageFieldController@sections');
    //Route::get('/pages/{pageID}/sections/{sectionID}/fields','PageFieldController@listFields');
    //Route::put('/page-sections/{sectionID}/fields','PageFieldController@updateFields');

    Route::resource('/layouts','LayoutController');
    Route::get('/layouts/{layoutID}/sections','LayoutSectionController@sections');
    Route::get('/layouts/{layoutID}/sections/{sectionID}/fields','LayoutSectionController@listFields');
    Route::put('/layout-sections/{sectionID}/fields','LayoutSectionController@updateFields');

    Route::get('/assets/{folder}/{file}', 'AssetController@getAsset');

});
