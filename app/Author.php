<?php

namespace App;

use ScoutElastic\Searchable;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use ScoutElastic\SearchableModel;

class Author extends Eloquent
{
    use Searchable;

    protected $indexConfigurator = TutorialIndexConfigurator::class;

    protected $searchRules = [
        //

    ];

    public function toSearchableArray()
    {
      return array(
          'id'        => $this->_id,
          'name'     => $this->name
      );
    }

    protected $mapping = [
     'properties' => [
         'name' => [
             'type' => 'string',
             'analyzer' => 'english'
         ]
     ]
 ];

  // Each author can write several books
   public function posts()
   {
       return $this->hasMany(Post::class);
   }
}
