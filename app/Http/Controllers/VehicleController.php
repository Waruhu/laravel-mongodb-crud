<?php

namespace App\Http\Controllers;

use App\Services\Contracts\VehicleServiceContract;
use App\Services\VehicleService;
// use App\Vehicle;

class VehicleController extends Controller
{
    /**
     * The user repository instance.
     */
    protected $vehicleService;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(VehicleServiceContract $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Show the user with the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function findVehicleById($id)
    {
        $vehicle =  $this->vehicleService->get($id);
        // $vehicle = Vehicle::find($id);
        return view('vehicle', compact('vehicle'));
    }
}