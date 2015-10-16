<?php

namespace App\Api\V1\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Api\V1\Transformers\UserTransformer;

class UserController extends BaseController
{
	/**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api.auth');
        $this->scopes('read_user_data');
    }

    /**
     * List all users resource.
     * 
     * Get a JSON representation of all the registered users.
     *
     */
    public function index() 
    {
        // $users = User::all();
        // return $this->response->collection($users, new UserTransformer, ['key' => 'users']);

        // Or Paginated
        $users = User::paginate(25);
        return $this->response->paginator($users, new UserTransformer, ['key' => 'users']);
    }

    /**
     * Show profile for specift user
     * 
     * @param int $id
     * @return Response
     */
    public function show($id) 
    {
        // faker data
        $user = factory('App\User')->make();
    	return $this->response->item($user, new UserTransformer, ['key' => 'user']);
    }

    /**
     * Register user
     *
     * Register a new user with a `phone` and `password`.
     *
     */
    public function store()
    {

    }
}