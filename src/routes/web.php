<?php
    

 Route::group(['namespace' => 'webmuscets\PageManager\Http\Controllers','prefix' => 'page-manager', 'middleware' => ['web']], function(){
    Route::get('/', 'PageController@index');
    Route::get('/assets/{folder}/{file}', 'AssetController@getAsset');

});
