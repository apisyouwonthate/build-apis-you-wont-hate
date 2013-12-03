<?php

use League\Fractal;

class BeerController extends ApiController
{
    public function index()
    {
        $data = [
            [
                'id'           => "1",
                'name'         => 'Stowford Press',
                'manufacturer' => 'Stowford Press',
            ],
            [
                'id'           => "2",
                'name'         => 'Green Goblin',
                'manufacturer' => 'Hobgoblin',
            ]
        ];

        return $this->respondWithCollection($data, function($scope, array $beer) {
            return [
                'id' => (int) $beer['id'],
                'name' => $beer['name']
            ];
        });
    }

}