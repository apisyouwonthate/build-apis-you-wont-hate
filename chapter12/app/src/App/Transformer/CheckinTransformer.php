<?php namespace App\Transformer;

use Checkin;
use Log;

use League\Fractal\TransformerAbstract;

class CheckinTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableEmbeds = [
        'place',
        'user',
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Checkin $checkin)
    {
        return [
            'id'          => (int) $checkin->id,
            'created_at'  => (string) $checkin->created_at,

            'links'        => [
                [
                    'rel' => 'self',
                    'uri' => '/checkins/'.$checkin->id,
                ],
            ],
        ];
    }

    /**
     * Embed Place
     *
     * @return League\Fractal\Resource\Item
     */
    public function embedPlace(Checkin $checkin)
    {
        $place = $checkin->place;

        Log::info("Embedding place-{$place->id} into checkin-{$checkin->id}");

        return $this->item($place, new PlaceTransformer);
    }

    /**
     * Embed User
     *
     * @return League\Fractal\Resource\Item
     */
    public function embedUser(Checkin $checkin)
    {
        $user = $checkin->user;

        Log::info("Embedding user-{$user->id} into checkin-{$checkin->id}");

        return $this->item($user, new UserTransformer);
    }
}
