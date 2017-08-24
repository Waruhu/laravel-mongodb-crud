<?php

namespace App\Repositories;

use App\Vehicle;
use App\Repositories\Contracts\VehicleRepositoryContract;

class VehicleRepository implements VehicleRepositoryContract
{
    /**
     * The cache instance.
    */
    protected $model;
         
    public function __construct(Vehicle $model)
    {     
        $this->model = $model;
    }
    
    public function getVehicleById($id)
    {
        return $this->model->find($id); 
    }

    public function search($keyword)
    {
        $query =  [
            'bool'=>[
                'should'=>[
                    [
                        'multi_match' => [
                            'query' => $keyword,
                            'fields' =>[
                                'brand_name',
                                'model_name',
                                'body_name',
                                'brand_model'
                            ],
                            'operator' => 'or',         
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'model_name'=>"*$keyword*"
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'brand_name'=>"*$keyword*"
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'body_name'=>"*$keyword*"
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'brand_model'=>"*$keyword*"
                        ],
                    ], 
                ],
            ],
        ];

        return $this->model->searchByQuery($query); 
    }
}
