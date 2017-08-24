<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use App\Services\Contracts\VehicleServiceContract;

class SearchController extends Controller
{

    protected $vehicleService;

    public function __construct(VehicleServiceContract $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function ajaxAutoComplete(Request $request) {
        $search = $request->get('term','');
        $data = $body_name = $brand_name = $model_name = $brand_model =  array();
        // $vehicles = $this->searchQuery($search);  
        $vehicles =  $this->vehicleService->search($search);

        foreach ($vehicles as $vehicle) {
            $body_name[]=array('value'=>$vehicle->body_name);
            $brand_name[]=array('value'=>$vehicle->brand_name);
            $model_name[]=array('value'=>$vehicle->model_name);
            $brand_model[]=array('value'=>$vehicle->brand_model);
        }
        
        $data = array_merge($brand_model, array_merge($model_name, array_merge($body_name, $brand_name)));
        $result_merge = array_unique($data, SORT_REGULAR );
        $result_filter = array_filter($result_merge, function ($item) use ($search) {
            if (strripos($item['value'], $search, 0) !== false) {
                return true;
            }
            return false;
        });
        return response()->json($result_filter);
    }

    public function searchQuery($search){
        
        $vehicles = Vehicle::searchByQuery($query);
        return $vehicles;
    }

    public function show($id){
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle', compact('vehicle'));
    }

    public function searchVehicle(Request $request){
        $error = ['error' => 'No results found, please try with different keywords.'];
        $params = [
            'body' => [
                'from' => 0,
                'size' => 2,
                'post_filter'=> [
                    'bool'=>[
                        'must' => [],
                    ]
                ],
                'sort' =>[
                    '_uid' =>'asc',
                ],
                'aggs'=>[
                    "brands" => [
                        "terms" => [
                            'field' => "brand_name",
                            "order" => ["_term" => "asc" ],    
                        ],
                    ],
                    'colors'=>[
                        'terms'=>[
                            'field'=>'color',
                            "order" => ["_term" => "asc" ],    
                        ]
                    ],
                    'cities'=>[
                        'terms'=>[
                            'field'=>'city_name',
                            "order" => ["_term" => "asc" ],    
                        ]
                    ]
                ],
                
            ],
        ];

        if($request->has('q')){
            $keyword = $request->get('q');
             $params['body']['query'] = [
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
        }

        if($request->has('brand')){
            $brand = explode(',', $request->get('brand'));
            $parameter = ['terms'=> ['brand_name' => $brand]];
            array_push($params['body']['post_filter']['bool']['must'], $parameter);
        }

        if($request->has('color')){
            $color = explode(',', $request->get('color'));
            $parameter = ['terms'=> ['color' => $color]];
            array_push($params['body']['post_filter']['bool']['must'], $parameter);
        }

        if($request->has('location')){
            $location = explode(',', $request->get('location'));
            $parameter = ['terms'=> ['city_name' => $location]];
            array_push($params['body']['post_filter']['bool']['must'], $parameter);
        }

        if($request->has('lastId')){
            $uid = 'vehicles#'.$request->get('lastId');
            $params['body']['search_after'] = [$uid];
        }

        
        $vehicles = Vehicle::complexSearch($params);
        $vehiclesAggreagation = $vehicles->getAggregations();
        $vehiclesAggreagationBrand = $vehiclesAggreagation['brands']['buckets'];
        $vehiclesAggreagationColor = $vehiclesAggreagation['colors']['buckets'];
        $vehiclesAggreagationCities = $vehiclesAggreagation['cities']['buckets'];

        if($request->ajax()){
            if($vehicles->count()){
                response()->json($vehicles); 
                return view('data', compact('vehicles'));
            }
            response()->json('');
            return;
        }
        if($vehicles->count())
            return view('search', compact('vehicles', 'vehiclesAggreagationBrand', 'vehiclesAggreagationColor', 'vehiclesAggreagationCities'));
        else
            return view('search', compact('error'));
    }
}
