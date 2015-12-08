<?php

$api = app('Dingo\Api\Routing\Router');

// API Endpoints [version 1.0]
$api->version('v1', ['scopes' => ['read_user_data', 'write_user_data']], function ($api) {
	// User Resource
	$api->get('users', ['as' => 'users.index', 
		'uses' => 'App\Api\V1\Controllers\UserController@index']);
	$api->get('users/{id}', ['as' => 'users.show', 
		'uses' => 'App\Api\V1\Controllers\UserController@show']);
});
