<?php

namespace App;

use ScoutElastic\Searchable;
// use Illuminate\Database\Eloquent\Model;
use ScoutElastic\SearchableModel;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Post extends Eloquent
{
    use Searchable;

    protected $indexConfigurator = TutorialIndexConfigurator::class;

    protected $searchRules = [
        //
        PostSearchRule::class
    ];


    public function toSearchableArray()
    {
      return array(
          'id'        => $this->_id,
          'title'     => $this->title,
          'description'     => $this->description,
          'year'     => $this->year,
          'author_id'     => $this->author_id,
      );
    }

    // We don't analyze numbers, all text is in English
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
            'description' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
            'year' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'author_id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'author_name' => [
                'type' => 'string',
                'analyzer' => 'english'
            ]
        ]
    ];

    // Each book belongs to one author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
