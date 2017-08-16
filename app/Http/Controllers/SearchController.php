<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;


class SearchController extends Controller
{
    public function ajaxAutoComplete(Request $request) {
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
        $vehicles = Vehicle::searchByQuery($query);
        return $vehicles;
    }

    public function show($id){
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicle', compact('vehicle'));
    }

    public function search(Request $request)
    {
        $error = ['error' => 'No results found, please try with different keywords.'];
        if($request->has('q')){
            $search = $request->get('q');
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
        }else{
            $query = [
                $query = 'match_all' => (object)[],
            ];
        }
        
        $search_after = "vehicles#5975d31b5250e13f3e11dc81";
        $vehicles = $this->SearchAfter($search_after, $query);
        $vehiclesAggreagation = $vehicles->getAggregations();
        $vehiclesAggreagationBrand = $vehiclesAggreagation['aggs']['buckets'];
        $vehiclesAggreagationColor = $vehiclesAggreagation['colors']['buckets'];
        if($vehicles->count())
            return view('loadmore',compact('vehicles', 'vehiclesAggreagationBrand', 'vehiclesAggreagationColor'));
        else
            return view('loadmore',compact('error'));
        
    }

    public function SearchAfter($search_after, $query){
        $params = [
            'body' =>[
                'from' => 0,
                'size' => 2,
                'query' => $query,
                'search_after' =>[
                    $search_after,
                ],
                'sort' =>[
                    '_uid' =>'asc',
                ],
                'aggs' => [
                    "aggs" => [
                        "terms" => [
                            'field' => "brand_name",
                            "order" => ["_term" => "asc" ],    
                        ],
                        "aggs"=>[
                            "prices" =>[
                                'extended_stats' => [
                                    'field' => 'price'
                                ]
                            ],
                        ],
                    ],
                    'colors'=>[
                        'terms'=>[
                            'field'=>'color',
                        ]
                    ]        
                ]
            ]
        ];
        $vehicles = Vehicle::complexSearch($params);
        return $vehicles; 
    }
    
    public function loadByAjax(Request $request)
    {
        $output = '';
        $id = $request->id;
        $search_after = "vehicles#".$id;
        if($request->has('q')){ //chek keyword is typed
            $search = $request->get('q');
            $query =  [
                'bool'=>[
                    'should'=>[
                        [
                            'multi_match' => [
                                'query' => $search,
                                'fields' =>[
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
            if($request->has('brand') && $request->has('color')){ //chek keyword is type and brand with color filter is checked
                $brand = explode(',', $request->get('brand'));
                $color = explode(',', $request->get('color'));
                $post_filter = [
                    'bool'=>[
                        'must'=>[
                            [
                                'terms' => [
                                    'brand_name'=>$brand,
                                ],
                            ],
                            [
                                'terms' => [
                                    'color'=> $color,
                                ],
                            ],
                        ]
                    ]
                ];
                return $this->doByAjax($query, $post_filter, $search_after);
            }else if($request->has('brand')){  //check keyword is typed and brand filter is checked
                $brand = explode(',', $request->get('brand'));
                $post_filter = [
                    'terms'=>[
                        'brand_name'=>$brand
                    ]
                ];
                return $this->doByAjax($query, $post_filter, $search_after);
            }else{                                                  //check is keyword typed and color filter is checked
                $color = explode(',', $request->get('color'));
                $post_filter = [
                    'terms'=>[
                        'color'=>$color
                    ]
                ];
                return $this->doByAjax($query, $post_filter, $search_after);
            }  
        }else if($request->ajax() && isset($request->brand) && isset($request->color)){ //brand and color is checked but nothing keyword
            $brand = explode(',', $request->get('brand'));
            $color = explode(',', $request->get('color'));
            $query = [
                'bool' => [
                    'must' => [
                        [
                            'terms'=>[
                                'brand_name'=> $brand,
                            ]
                        ],
                        [
                            'terms'=>[
                                'color'=> $color,
                            ]
                        ],
                    ],
                ]
            ];
        }else if($request->ajax() && isset($request->brand)){ //brand filter is checked but nothing keyword
            $brand = explode(',', $request->get('brand'));
            $query = [
                'terms' => [
                    'brand_name' => $brand
                ]
            ];
        }else if($request->ajax() && isset($request->color)){ //color filter is checked but nothing keyword
            $color = explode(',', $request->get('color'));
            $query = [
                'terms' => [
                    'color' => $color
                ]
            ];
        }else{
            $query = [
                $query = 'match_all' => (object)[],
            ];
        }
        $post_filter = (object)[];
        return $this->doByAjax($query, $post_filter, $search_after);
    }

    public function doByAjax($query, $post_filter, $search_after){
        $params = [
            'body'=>[
                'from' => 0,
                'size' => 2,
                'query' => $query,
                'post_filter'=>$post_filter,
                'search_after' =>[
                    $search_after,
                ],
                'sort' =>[
                    '_uid' =>'asc',
                ],
            ],
        ];
        $vehicles = Vehicle::complexSearch($params);
        if($vehicles->count()){
            response()->json($vehicles); //return to ajax
            return view('data', compact('vehicles'));
        }else{
            response()->json(''); //return to ajax
        }
        return ;
    }

    public function filterAjax(Request $request){
        $post_filter = (object)[];
        $error = ['error' => 'No Items Found'];
        $search_after = "vehicles#5975d31b5250e13f3e11dc81";
        if($request->has('q')){ //check keyword is not nulls
            $search = $request->get('q');
            $query =  [
                    'bool'=>[
                        'should'=>[
                            [
                                'multi_match' => [
                                    'query' => $search,
                                    'fields' =>[
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
        }else{
            if($request->has('brand')){                          //brand is checked and there is keyword
                $brand = explode(',', $request->get('brand'));
                $query = [
                    'terms' => [
                        'brand_name' => $brand
                    ]        
                ];
            }else{
                $color = explode(',', $request->get('color'));  //color is checked and there is keyword
                $query = [
                    'terms' => [
                        'color' => $color
                    ]        
                ];
            }
        }

        if($request->has('brand') && $request->has('color')){ //brand and color is checked but nothing keyword
            $brand = explode(',', $request->get('brand'));
            $color = explode(',', $request->get('color'));
            $post_filter = [
                'bool'=>[
                    'must'=>[
                        [
                            'terms' => [
                                'brand_name'=>$brand,
                            ],
                        ],
                        [
                            'terms' => [
                                'color'=> $color,
                            ],
                         ],
                    ]
                ]
            ];
        }else if($request->has('brand')){                   //brand is checked but nothing keyword
            $brand = explode(',', $request->get('brand'));
            $post_filter = [
                'terms' => [
                    'brand_name'=>$brand,
                ],
            ];
        }else if($request->has('color')){                   //color is checked but nothing keyword
            $color = explode(',', $request->get('color'));
            $post_filter = [
                'terms' => [
                    'color'=>$color,
                ],
            ];
        }

        $params = [
            'body'=>[
                'from' => 0,
                'size' => 2,
                'query' => $query,
                'post_filter'=>$post_filter,
                'search_after' =>[
                    $search_after,
                ],
                'sort' =>[
                    '_uid' =>'asc',
                ],
            ],
        ];
        $vehicles = Vehicle::complexSearch($params);
        if($vehicles->count()){
            response()->json($vehicles); //return to ajax
            return view('data', compact('vehicles'));
        }else{
            response()->json(''); //return to ajax
            return view('data', compact('error'));
        }
    }
}
