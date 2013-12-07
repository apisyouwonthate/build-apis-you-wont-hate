<?php namespace App\Processor;

use Checkin;

use League\Fractal\ItemResource;
use League\Fractal\ProcessorAbstract;
use League\Fractal\Scope;

class CheckinProcessor extends ProcessorAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function process(Scope $scope, Checkin $checkin)
    {
        $data = [
            'id'          => (int) $checkin->id,
            'created_at'  => (string) $checkin->created_at,
        ];

        if ($scope->isRequested('place') and $checkin->place) {
            $resource = new ItemResource($checkin->place, PlaceProcessor::class);
            $data['place'] = $scope->embedChildScope('place', $resource);
        }

        return $data;
    }

}