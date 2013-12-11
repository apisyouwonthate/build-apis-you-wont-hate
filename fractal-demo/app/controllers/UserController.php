<?php

use App\Transformer\UserTransformer;

class UserController extends ApiController
{
    public function index()
    {
        $users = User::take(10)->get();

        return $this->respondWithCollection($users, new UserTransformer);
    }
}