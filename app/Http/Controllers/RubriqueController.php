<?php

namespace App\Http\Controllers;

use App\Models\Rubrique;
use App\Models\Resto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RubriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $resto_id )
    {
        //envoyer la liste de rubrique dans le menu selon le resto
        $resto = Resto::select('nom')->where('id', $resto_id)->first();
        $rubriques = Rubrique::where('resto_id', $resto_id)->orderBy('ordre')->get();
        return response()->json( ['resto' => $resto->nom, 'rubriques' => $rubriques] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // retourne la vue views/rubriques
        return view("restos.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. validation
        $request->validate([
            'titre' => 'required|string|max:255',
            //'picture' => 'image|max:1024',
        ]);

        // 2. upload image
        //if ( $request->image )
        //    $chemin_image = $request->picture->store('rubriques');

        // 3. enregistre Rubrique
        $createRubrique = Rubrique::create($request->all());

        $lastInsertID = $createRubrique->id;

        // 4. retourne vers les rubriques
        //return redirect(route("rubriques.index"));
        return response()->json( ['rubriqueId' => $lastInsertID] );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rubrique  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function show(Rubrique $rubrique)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rubrique  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubrique $rubrique)
    {
        //
        return view("rubriques.edit", compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rubrique  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $resto_id, Rubrique $rubrique)
    {
        // 1. validation
        $request->validate([
            'titre' => 'required|string|max:255'
        ]);
        
        $rubrique->update([
            'titre' => $request->titre
        ]);

        return response()->json( ['message' => 'update'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rubrique  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubrique $rubrique)
    {
        //
    }

    public function updateListeOrder(Request $request)
    {
        //
        $liste = $request->liste;
        $req = "UPDATE rubriques SET ordre=field(`id`, {$liste} ) WHERE id IN ( {$liste} )";
        $result = DB::update( DB::raw($req) );

        return response()->json( ['message' => 'ok'] );
    }

}
