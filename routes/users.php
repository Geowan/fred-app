<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/user-management','middleware' => 'auth'], function () use ($router) {

    //roles
    $router->get('/roles',["uses"=>"RolesController@index"]);
    $router->post('/roles',["uses"=>"RolesController@store"]);
    $router->put('/roles/',["uses"=>"RolesController@update"]);
    $router->delete('/roles',["uses"=>"RolesController@destroy"]);


    $router->get('role-permissions',["uses"=>"PermissionController@index"]);
    $router->post('role-permissions',["uses"=>"PermissionController@store"]);
    $router->put('role-permissions',["uses"=>"PermissionController@update"]);
    $router->delete('role-permissions',["uses"=>"PermissionController@destroy"]);

    $router->get('all-permissions',["uses"=>"PermissionController@unallocatedPermissions"]);

    //users
    $router->get('user/form-data',["uses"=>"UsersController@formData"]);
    $router->get('users',["uses"=>"UsersController@index"]);
    $router->post('users',["uses"=>"UsersController@store"]);
    $router->put('users',["uses"=>"UsersController@update"]);
    $router->delete('users',["uses"=>"UsersController@destroy"]);


});
