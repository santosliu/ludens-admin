<?php

use Illuminate\Support\Facades\Route;

// 在 admin 中間件群組內
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    // 你的自訂路徑
    Route::crud('proper-noun', 'ProperNounCrudController');
    Route::crud('unpublish-game', 'UnpublishGameCrudController');
    Route::crud('news-request', 'NewsRequestCrudController');
});
