<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/app','middleware'=>'auth'], function () use ($router) {
    $router->get('/data', ['uses'=>'AppController@app_data']);
    $router->post('/inspection/save', ['uses'=>'InspectionController@store']);
    $router->get('/inspection/index', ['uses'=>'InspectionController@index']);
});

$router->group(['prefix' => 'reports/default','middleware'=>'auth'], function () use ($router) {
    $router->post('/summaries', ['uses'=>'ReportsController@summary']);
});
