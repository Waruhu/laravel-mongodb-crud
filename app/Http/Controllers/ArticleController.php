<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = Article::all();
        if (!$articles) {
            throw new HttpException(400, "Invalid data");
        }
        return response()->json(
            $articles,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $article = new Article;
        $article->title = $request->input('title');
        $article->price = $request->input('price');
        $article->author = $request->input('author');
        $article->editor = $request->input('editor');
        if ($article->save()) {
            return response()->json([
                'message' => 'article created',
            ], 200);
        }
        throw new HttpException(400, "Invalid data");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if (!$id) {
           throw new HttpException(400, "Invalid id");
        }
        $article = Article::find($id);
        return response()->json([
            $article,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }
        $article = Article::find($id);
        $article->title = $request->input('title');
        $article->price = $request->input('price');
        $article->author = $request->input('author');
        $article->editor = $request->input('editor');
        if ($article->save()) {
            return response()->json([
                'message' => 'article updated',
            ], 200);
        }
        throw new HttpException(400, "Invalid data");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }
        $article = Article::find($id);
        $article->delete();
        return response()->json([
            'message' => 'article deleted',
        ], 200);
    }
}
