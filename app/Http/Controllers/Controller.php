<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	public function docs()
	{
		return view('docs.index')
			->with('urlToDocs', env('API_DOC_SWAGGER'))
			->with('clientId', env('API_CLIENT_ID'))
			->with('clientSecret', env('API_CLIENT_SECRET'))
			->with('realm', env('API_REALM'))
			->with('appName', env('API_APP_NAME'));
	}
}
