<?php

namespace App\Services;

use App\Services\Contracts\VehicleServiceContract;
use App\Repositories\Contracts\VehicleRepositoryContract;

class VehicleService implements VehicleServiceContract
{
    protected $vehicleRepository;
     
    public function __construct(VehicleRepositoryContract $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    
    public function get($id)
    {
        return $this->vehicleRepository->getVehicleById($id);
    }

    public function search($keyword)
    {
        return $this->vehicleRepository->search($keyword);
    }
 
}
