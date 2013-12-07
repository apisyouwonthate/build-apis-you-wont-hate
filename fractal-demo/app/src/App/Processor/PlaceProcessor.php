<?php namespace App\Processor;

use Place;

use League\Fractal\CollectionResource;
use League\Fractal\ProcessorAbstract;
use League\Fractal\Scope;

class PlaceProcessor extends ProcessorAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function process(Scope $scope, Place $place)
    {
        $data = [
            'id'           => (int) $place->id,
            'name'         => $place->name,
            'lat'          => $place->lat,
            'lon'          => $place->lon,
            'address1'     => $place->address1,
            'address2'     => $place->address2,
            'city'         => $place->city,
            'state'        => $place->state,
            'zip'          => $place->zip,
            'website'      => $place->website,
            'phone'        => $place->phone,
        ];

        if ($scope->isRequested('checkins') and $place->checkins) {
            $resources = new CollectionResource($place->checkins, CheckinProcessor::class);
            $data['checkins'] = $scope->embedChildScope('checkins', $resources);
        }

        return $data;
    }

}