<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/product', AdminProductController::class);
    $router->resource('/productdetail',AdminProductDetailController::class);
    $router->resource('/categorydetail',CategoryDetailController::class);
    $router->resource('/category',CategoryController::class);
    $router->resource('/user',UserController::class);
    $router->resource('/address',UserAddressController::class);
    $router->resource('/order',OrderController::class);
    $router->resource('/orderitem',OrderItemController::class);

});
