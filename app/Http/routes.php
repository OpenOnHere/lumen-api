<?php

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

$app->get('oauth/me', function() {
	return LucaDegasperi\OAuth2Server\Facades\Authorizer::getResourceOwnerId();
});

$app->get('oauth/authorize', ['as' => 'oauth.authorize.get','middleware' => ['check-authorization-params', 'auth'], function() {
    // display a form where the user can authorize the client to access it's data
   $authParams = Authorizer::getAuthCodeRequestParams();
   $formParams = array_except($authParams,'client');
   $formParams['client_id'] = $authParams['client']->getId();
   return View::make('oauth.authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
}]);

$app->post('oauth/authorize', ['as' => 'oauth.authorize.post','middleware' => ['csrf', 'check-authorization-params', 'auth'], function() {

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = Auth::user()->id;
    $redirectUri = '';

    // if the user has allowed the client to access its data, redirect back to the client with an auth code
    if (Input::get('approve') !== null) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }

    // if the user has denied the client to access its data, redirect back to the client with an error message
    if (Input::get('deny') !== null) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }
    return Redirect::to($redirectUri);
}]);