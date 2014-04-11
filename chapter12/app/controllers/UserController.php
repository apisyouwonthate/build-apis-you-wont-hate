<?php

use App\Transformer\CheckinTransformer;
use App\Transformer\UserTransformer;

class UserController extends ApiController
{
    public function index()
    {
        $users = User::take(10)->with('checkins', 'checkins.place')->get();

        return $this->respondWithCollection($users, new UserTransformer);
    }

    public function show($userId)
    {
        $user = User::find($userId);

        if (! $user) {
            return $this->errorNotFound('User not found');
        }

        return $this->respondWithItem($user, new UserTransformer);
    }

    public function getCheckins($userId)
    {
        $user = User::find($userId);

        if (! $user) {
            return $this->errorNotFound('User not found');
        }

        return $this->respondWithCollection($user->checkins, new CheckinTransformer);
    }
}
