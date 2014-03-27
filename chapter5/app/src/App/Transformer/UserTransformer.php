<?php namespace App\Transformer;

use User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'             => (int) $user->id,
            'name'           => $user->name,
            'bio'            => $user->bio,
            'gender'         => $user->gender,
            'location'       => $user->location,
            'birthday'       => $user->birthday,
            'joined'         => (string) $user->created_at,
        ];
    }
}
