<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/administrative','middleware'=>'auth'], function () use ($router) {

    //checklist categories
    $router->get('checklist-categories', ['uses'=>'ChecklistCategoryController@index']);
    $router->post('checklist-categories', ['uses'=>'ChecklistCategoryController@store']);
    $router->put('checklist-categories', ['uses'=>'ChecklistCategoryController@update']);
    $router->delete('checklist-categories', ['uses'=>'ChecklistCategoryController@destroy']);


    $router->get('checklist-items', ['uses'=>'ChecklistItemsController@index']);
    $router->post('checklist-items', ['uses'=>'ChecklistItemsController@store']);
    $router->put('checklist-items', ['uses'=>'ChecklistItemsController@update']);
    $router->delete('checklist-items', ['uses'=>'ChecklistItemsController@destroy']);



    //vehicles
    $router->get('vehicles/form', ['uses'=>'VehiclesController@formData']);
    $router->get('vehicles', ['uses'=>'VehiclesController@index']);
    $router->post('vehicles', ['uses'=>'VehiclesController@store']);
    $router->put('vehicles', ['uses'=>'VehiclesController@update']);
    $router->delete('vehicles', ['uses'=>'VehiclesController@destroy']);



});
