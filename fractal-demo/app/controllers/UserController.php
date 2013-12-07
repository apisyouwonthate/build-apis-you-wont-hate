<?php

use App\Processor\UserProcessor;

class UserController extends ApiController
{
    public function index()
    {
        $users = User::take(10)->get();

        return $this->respondWithCollection($users, UserProcessor::class);
    }
}