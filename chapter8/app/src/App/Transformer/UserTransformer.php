<?php namespace App\Transformer;

use User;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableEmbeds = [
        'checkins'
    ];

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

    /**
     * Embed Checkins
     *
     * @return League\Fractal\Resource\Collection
     */
    public function embedCheckins(User $user)
    {
        $checkins = $user->checkins;

        return $this->collection($checkins, new CheckinTransformer);
    }
}
