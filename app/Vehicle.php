<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Elasticquent\ElasticquentTrait;

class Vehicle extends Eloquent
{
    //
    use ElasticquentTrait;

        protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
            'normalizer'=>[
                'lowerasciinormalizer' => [
                      'type' => 'custom',
                       "filter"=>  [ "lowercase", "asciifolding" ]
                ]
            ],
        ],
    ];

    protected $mappingProperties = [
        'id' => [
                'type' => 'string',
                'analyzer' => 'default',
                'fielddata' => true,

        ],
        'model_name' => [
                'type' => 'keyword',
                'normalizer'=> 'lowerasciinormalizer'
        ],
        'model_name_search' => [
                'type' => 'keyword'
        ],
        'brand_name' => [
                'type' => 'keyword',
                'normalizer'=> 'lowerasciinormalizer'
        ],
        'category_body_name' => [
                'type' => 'keyword'
        ],
        'body_name' => [
                'type' => 'keyword',
                'normalizer'=> 'lowerasciinormalizer'
        ],
        'brand_model' => [
                'type' => 'keyword',
                'normalizer'=> 'lowerasciinormalizer'
        ],
        'province_id' => [
                'type' => 'keyword'
        ],
        'province_name' => [
                'type' => 'keyword'
        ],
        'city_id' => [
                'type' => 'keyword'
        ],
        'city_name' => [
                'type' => 'keyword'
        ],
        'location_search' => [
                'type' => 'text'
        ],
        'caption' => [
                'type' => 'text'
        ],
        'color' => [
                'type' => 'keyword'
        ],
        'price' => [
                'type' => 'double'
        ],
        'condition' => [
                'type' => 'keyword'
        ],
        'description' => [
                'type' => 'text'
        ],

        'features' => [
                'type' => 'keyword'
        ],
        'fuel' => [
                'type' => 'keyword'
        ],
        'creator_id' => [
                'type' => 'keyword'
        ],
        'mileage' => [
                'type' => 'double'
        ],
        'transmission' => [
                'type' => 'text'
        ],
        'variant' => [
                'type' => 'text'
        ],

        'year' => [
                'type' => 'integer'
        ],
        'created_at' => [
                'type' => 'date',
                "format" => "YYYY-MM-dd'T'HH:mm:ss.SSSZZ"
        ],
        'updated_at' => [
                'type' => 'date',
                "format" => "YYYY-MM-dd'T'HH:mm:ss.SSSZZ"
        ],
    ];

    public function getIndexDocumentData()
    {
        return array(
            'id'        => $this->id,
            'caption'      => $this->caption,
            'city_id'     => $this->city_id,
            'city_name'     => $this->city_name,
            'color'     => $this->color,
            'condition'     => $this->condition,
            'description'     => $this->description,
            'features'     => $this->features,
            'fuel'     => $this->fuel,
            'machine_capacity'     => $this->machine_capacity,
            'mileage'     => $this->mileage,
            'price'     => $this->price,
            'province_id'     => $this->province_id,
            'province_name'     => $this->province_name,
            'status'     => $this->status,
            'transmission'     => $this->transmission,
            'variant'     => $this->variant,
            'year'     => $this->year,
            'location_search'     => $this->brand_model,
            'model_name'     => $this->model,
            'model_name_search'     => $this->model,
            'brand_name'     => $this->brand,
            'body_name'     => $this->body_name,
            'brand_model'     => $this->brand .' ' .$this->model,
        );
    }

    public function getTypeName()
    {
        return 'vehicles';
    }
    
    /*
    //this function to solve this error:
    Elasticsearch\Common\Exceptions\BadRequest400Exception with message 'illegal_argument_exception: 
    The parameter [fields] is no longer supported, please use [stored_fields] to retrieve stored fields 
    or _source filtering if the field is not stored'
    */
    private function buildFieldsParameter($getSourceIfPossible, $getTimestampIfPossible) { 
        return null; 
    }
}
