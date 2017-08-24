<?php
namespace App\Repositories\Contracts;

interface VehicleRepositoryContract {

    public function getVehicleById($id);

    public function search($keyword);
    
}