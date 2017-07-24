<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Elasticquent\ElasticquentTrait;

class Book extends Eloquent
{
    //
    use ElasticquentTrait;

    protected $mappingProperties = [
        'id' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'isbn' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'title' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'author' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
        'category' => [
                'type' => 'string',
                'analyzer' => 'standard'
        ],
    ];

    public function getIndexDocumentData()
    {
        return array(
            'id'        => $this->id,
            'isbn'      => $this->isbn,
            'title'     => $this->title,
            'author'    => $this->author,
            'category'  => $this->category
        );
    }

    public function getTypeName()
    {
        return 'books';
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
