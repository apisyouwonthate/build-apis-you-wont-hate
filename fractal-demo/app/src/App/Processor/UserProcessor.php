<?php namespace App\Processor;

use User;

use League\Fractal\ItemResource;
use League\Fractal\CollectionResource;
use League\Fractal\ProcessorAbstract;
use League\Fractal\Scope;

class UserProcessor extends ProcessorAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function process(Scope $scope, User $user)
    {
        $data = [
            'id'           => (int) $user->id,
            'name'         => $user->name,
            'bio'          => $user->bio,
            'gender'       => $user->gender,
            'location'     => $user->location,
            'birthday'     => $user->birthday,
            'joined'       => (string) $user->created_at,
        ];

        if ($scope->isRequested('checkins') and $user->checkins) {
            $resources = new CollectionResource($user->checkins, CheckinProcessor::class);
            $data['checkins'] = $scope->embedChildScope('checkins', $resources);
        }

        return $data;
    }

}