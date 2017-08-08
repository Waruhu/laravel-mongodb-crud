<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Elasticquent\ElasticquentTrait;

class Brand extends Eloquent
{
    //
    use ElasticquentTrait;

    protected $mappingProperties = [
        'id' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'brand' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'model' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
    ];


    public function getIndexDocumentData()
    {
        return array(
            'id'        => $this->id,
            'brand'      => $this->brand,
            'model'     => $this->model
        );
    }

    public function getTypeName()
    {
        return 'brands';
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
