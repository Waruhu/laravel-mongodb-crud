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
        $search = null;
        if($request->has('q')) {
            $search = $request->get('q');
            $query =  [
                'match'=>[
                    '_all' => $search,
                ]
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
            $vehiclesAggreagation = $vehicles->getAggregations();
            return $vehicles->count() ? view('search', compact(['vehicles', 'vehiclesAggreagation'])) : $error;
        }
        return view('search', compact('vehicles'));
    }
    
    public function autoComplete(Request $request) {
        $query = $request->get('term','');
        $vehicles=Vehicle::where('brand_model','LIKE','%'.$query.'%')->get();
        $data = array();
        foreach ($vehicles as $vehicle) {
                $data[]=array('value'=>$vehicle->brand_model ,'id'=>$vehicle->_id);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'','id'=>''];
    }
}
