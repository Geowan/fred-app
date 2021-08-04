<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/auth'], function () use ($router) {
    $router->post('/login', ['uses'=>'AuthController@login']);
    $router->get('/active-user', ['uses'=>'AuthController@activeUser']);
    $router->post('/register', ['uses'=>'AuthController@register']);
});
