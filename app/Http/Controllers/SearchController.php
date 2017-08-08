<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $vehicles = Vehicle::all();   
        $error = ['error' => 'No results found, please try with different keywords.'];
        if($request->has('q')) {
            $search = $request->get('q');
            $vehicles = $this->searchQuery($search);
            $vehiclesAggreagation = $vehicles->getAggregations();
            return $vehicles->count() ? view('search', compact(['vehicles', 'vehiclesAggreagation'])) : view('search', compact(['error']));
        }
        return view('search', compact('vehicles'));
    }
    
    public function autoComplete(Request $request) {
        $search = $request->get('term','');
        $data = $body_name = $brand_name = $model_name =  array();
        $vehicles = $this->searchQuery($search);  
        foreach ($vehicles as $vehicle) {
            $body_name[]=array('value'=>$vehicle->body_name);
            $brand_name[]=array('value'=>$vehicle->brand_name);
            $model_name[]=array('value'=>$vehicle->model_name);
        }
        $data = array_merge(array_merge($body_name,$brand_name), $model_name);
        $result_merge = array_unique($data, SORT_REGULAR);
        $result_filter = array_filter($result_merge, function ($item) use ($search) {
            if (strripos($item['value'], $search, 0) !== false) {
                return true;
            }
            return false;
        });
        return response()->json($result_filter);
    }

    public function searchQuery($search){
        $query =  [
            'bool'=>[
                'should'=>[
                    [
                        'multi_match' => [
                            'query' => $search,
                            'fields' =>[
                                'brand_model^5',
                                'brand_name',
                                'model_name',
                                'body_name'
                            ],
                            'operator' => 'or',         
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'model_name'=>"*$search*"
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'brand_name'=>"*$search*"
                        ],
                    ],
                    [
                        'wildcard'=>[
                            'body_name'=>"*$search*"
                        ],
                    ], 
                ],
            ],
        ];  
        $aggregationQuery = 
        [
            "aggs" => [
                "terms" => [
                    'field' => "color",
                    "order" => ["_term" => "asc" ],    
                ],
                "aggs"=>[
                    "prices" =>[
                        'extended_stats' => [
                            'field' => 'price'
                        ]
                    ],
                ],
            ]
        ];
        $vehicles = Vehicle::searchByQuery($query, $aggregationQuery);
        return $vehicles;
    }

    public function show($id){
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle', compact('vehicle'));
    }
}
