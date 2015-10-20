<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OAuthController extends Controller
{
    /**
     * Instantiate a new OAuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['authorize', 'issueAuthorize']]);
        $this->middleware('check-authorization-params', ['only' => ['authorize', 'issueAuthorize']]);
        // $this->middleware('csrf', ['only' => 'issueAuthorize']);
    }

    /**
     * Issue oauth acess token & refresh access token.
     *
     * @return Response
     */
    public function issueAccessToken()
    {
        return Authorizer::issueAccessToken();
    }

    /**
     * Show the profile for the resource owner.
     *
     * @return Response
     */
    public function owner()
    {
        $ownerId = Authorizer::getResourceOwnerId();
        return ['user' => User::findOrFail($ownerId)];
    }

    /**
     * Handle incoming auth code requests.
     *
     * @return Response
     */
    public function authorize() {
        // display a form where the user can authorize the client to access it's data
        $authParams = Authorizer::getAuthCodeRequestParams();
        $formParams = array_except($authParams,'client');
        $formParams['client_id'] = $authParams['client']->getId();
        return View::make('oauth.authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
    }

    /**
     * Issue request with the Auth Code Grant.
     *
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function issueAuthorize(Request $request) {
        $params = Authorizer::getAuthCodeRequestParams();
        $params['user_id'] = Auth::user()->id;
        $redirectUri = '';

        // if the user has allowed the client to access its data, redirect back to the client with an auth code
        if ($request->input('approve') !== null) {
            $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
        }

        // if the user has denied the client to access its data, redirect back to the client with an error message
        if ($request->input('deny') !== null) {
            $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }
}