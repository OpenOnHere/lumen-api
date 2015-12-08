<?php

// Welcome Page
$app->get('/', function () {
	return ['name' => 'TatuQ API Server.', 'doc_url' => env('API_DOC_URL')];
});

// API Documents
$app->get('docs', 'Controller@docs');

// OAuth2.0 Sever Routes
$app->post('api/oauth/access_token', ['as' => 'oauth.access_token', 'uses' => 'OAuthController@issueAccessToken']);
$app->get('api/oauth/me', ['as' => 'oauth.owner', 'uses' => 'OAuthController@owner']);
$app->get('api/oauth/authorize', ['as' => 'oauth.authorize.get', 'uses' => 'OAuthController@authorize']);
$app->post('api/oauth/authorize', ['as' => 'oauth.authorize.post', 'uses' => 'OAuthController@issueAuthorize']);

// JWT Auth
$app->post('api/auth/login', 'AuthController@postLogin');