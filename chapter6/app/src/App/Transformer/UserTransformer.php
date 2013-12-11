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

    public function links(User $user, $url, $method)
    {
        return [
            'settings' => $this->addLink("{$url}/{$this->id}/settings", 'GET'),
            'profile' => $this->addLink("{$url}/{$this->id}/profile", 'DELETE'),
            'upload_image' => $this->addLink("{$url}/{$this->id}/image", 'PUT'),
            'delete' => $this->addLink("", 'GET'),
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
