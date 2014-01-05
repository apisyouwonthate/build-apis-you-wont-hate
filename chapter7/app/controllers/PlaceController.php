<?php

use App\Transformer\PlaceTransformer;

class PlaceController extends ApiController
{
    public function index()
    {
        $places = Place::take(10)->get();

        return $this->respondWithCollection($places, new PlaceTransformer);
    }

    public function show($id)
    {
        $place = Place::find($id);

        if (! $place) {
            return $this->errorNotFound('Did you just invent an ID and try loading a place? Muppet.');
        }
        
        return $this->respondWithItem($place, new PlaceTransformer);
    }
}