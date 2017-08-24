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
  if($query = Input::get('query', false)) {
    $params = [
        'match' => [
            'title' => $query
        ]
    ];
    $books = Book::searchByQuery($params);
  } else {
    $books = Book::all();
  }
  return View::make('elasticquent/bookindex', compact('books'));
}]);

Route::get('/vehicle/find/{id}', 'VehicleController@findVehicleById');