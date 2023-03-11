<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Rubrique;
use App\Models\Tag;
use Illuminate\Support\facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rubrique_id)
    {
        //
        $articles = Article::select('id','titre','prix', 'ordre')->where('rubrique_id', $rubrique_id)->orderBy('ordre')->get();
        $rubriqueTitre = Rubrique::select('titre')->where('id', $rubrique_id)->first();
        return response()->json( ['articles' => $articles, 'rubrique'=> $rubriqueTitre->titre] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $rubrique_id)
    {
        //
        $request->validate([
            'titre' => 'required|string|max:255',
            'rubrique_id' => 'integer|required',
            'titre' => 'string|nullable',
            'resume' => 'string|nullable',
            'contenu' => 'string|nullable',
            'prix' => 'numeric|nullable'
        ]);

        $articleCreate = Article::create([
            'user_id' => Auth::id(),
            'rubrique_id' => $rubrique_id,
            'titre' => $request->titre,
            'resume' => $request->resume,
            'contenu' => $request->contenu,
            'prix' => $request->prix            
        ]);

        if ($request->has('tags')){
            $articleCreate->tags()->attach($request->tags);
        }

        //$articleCreate->tag()->sync((array)$request->input('tag'));

        return response()->json( ['message' => 'OK' ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rubrique_id, $articleId)
    {
        //

        //$article = Article::select('titre','resume','contenu','prix')->where('id', $articleId)->with(['tags'])->firstOrFail();
        //$tags = Tag::select('id')->get();

        // $article = Article::with('tags')->findOrFail($articleId);

        // return response()->json([
        //     'titre' => $article->titre,
        //     'resume' => $article->resume,
        //     'contenu' => $article->contenu,
        //     'prix' => $article->prix,
        //     'tags' => $article->tags->pluck('id')
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rubrique_id, $articleId)
    {
        //
        $article = Article::with('tags')->findOrFail($articleId);

        return response()->json([
            'titre' => $article->titre,
            'resume' => $article->resume,
            'contenu' => $article->contenu,
            'picture' => $article->picture,
            'prix' => $article->prix,
            'tags' => $article->tags->pluck('id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rubrique_id, Article $article)
    {
        //
        // 1. validation
        $request->validate([
            'titre' => 'required|string|max:255'
        ]);

        
        $article->update([
            'titre' => $request->titre,
            'resume' => $request->resume,
            'contenu' => $request->contenu,
            'prix' => $request->prix
        ]);
        $article->tags()->sync($request->tags);

        return response()->json( ['message' => 'update'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Article $article)
    {
        //
        $article->deleted_at = now();
        $article->deleted_by = Auth::id();
        $article->save();

        return response()->json( ['message' => 'destroy'] );
    }

    public function updateListeOrder(Request $request)
    {
        //
        $liste = $request->liste;
        $req = "UPDATE articles SET ordre=field(`id`, {$liste} ) WHERE id IN ( {$liste} )";
        $result = DB::update( DB::raw($req) );

        return response()->json( ['Article updateListeOrder' => $liste] );
    }

    public function uploadPicture( Request $request, $id)
    {
        if ($request->has("picture")) {
            $article = Article::findOrFail($id);

            if ($article->picture){
                Storage::delete($article->picture);
            }
            
            $chemin_image = $request->picture->store("articles");
            
            $article->update([
                'picture' => isset($chemin_image) ? $chemin_image : $article->picture
            ]);

        }
        
        return response()->json( ['message' => 'ok'] );
    }

    public function uploadPictureRemove( Request $request, $id)
    {
        $article = Article::findOrFail($id);
        if ($article->picture){
            Storage::delete($article->picture);
        }
        $article->picture = null;
        $article->update([
            'picture' => isset($chemin_image) ? $chemin_image : $article->picture
        ]);
        return response()->json( ['message' => 'ok'] );
    }
}
