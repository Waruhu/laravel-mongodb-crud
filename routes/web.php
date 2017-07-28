<?php
use App\Book;
use App\vehicle;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::resource('books', 'BookController');

Route::get('/elasticsearch', ['as' => 'search', 'uses' => function() {
  // Check if user has sent a search query

  if($query = Input::get('query', false)) {
    // Use the Elasticquent search method to search ElasticSearch
//   $client = ClientBuilder::create()->build();
    $params = [
        'match' => [
            'title' => $query
        ]
    ];
    // $books = Book::search($query);
    $books = Book::searchByQuery($params);
  } else {
    $books = Book::all();
  }
  return View::make('elasticquent/bookindex', compact('books'));

}]);

Route::get('/search', function(){
    return view('search', ['vehicles'=>vehicle::all()]);
});
