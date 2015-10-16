<?php

namespace App\Api\V1\Transformers;

use App\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	public function transform(User $user)
    {
        return [
            'name'    => $user->name,
            'phone'   => $user->phone,
            'createdTime'    => (string)$user->created_at
        ];
    }

}