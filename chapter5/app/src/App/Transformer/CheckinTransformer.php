<?php namespace App\Transformer;

use Checkin;
use League\Fractal\TransformerAbstract;

class CheckinTransformer extends TransformerAbstract
{
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
        ];
    }
}
