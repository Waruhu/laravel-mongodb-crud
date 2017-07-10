<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use Leaque\Fractal;
use app\Book;

class BookTransformer extends TransformerAbstract
{
	public function transform(Book $book)
	{
	    return [
	        'id'      => $book['_id'],
            'title'   => $book['title'],
            'isbn'    => (int) $book['isbn'],
            'author'  => [
				'name'  => $book['author'],
				'email' => $book['author'] .'@gmail.com',
            ],
            'category'    => (int) $book['category'],
	    ];
	}
}
