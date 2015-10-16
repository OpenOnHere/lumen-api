<?php

// Welcome Page
$app->get('/', function () {
	return ['name' => 'TatuQ API Server.', 'doc_url' => env('API_DOC_URL')];
});

// API Documents
$app->get('docs', 'Controller@docs');

// OAuth2.0 Sever Routes
$app->post('oauth/access_token', ['as' => 'oauth.access_token', 'uses' => 'OAuthController@issueAccessToken']);
$app->get('oauth/me', ['as' => 'oauth.owner', 'uses' => 'OAuthController@owner']);
$app->get('oauth/authorize', ['as' => 'oauth.authorize.get', 'uses' => 'OAuthController@authorize']);
$app->post('oauth/authorize', ['as' => 'oauth.authorize.post', 'uses' => 'OAuthController@issueAuthorize']);