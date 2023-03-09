<?php

namespace App\Http\Controllers;

use App\Models\Resto;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use DateTime;

class RestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return view("restos.index");
        $restos = Resto::all(['id','nom','actif','dt_abon']);
        return response()->json( $restos );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("restos.form", ['fonction'=>'Ajouter']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'nom' => 'required',
            'tel' => 'required'
        ]);

        // format date fr en date database
        // version blade formulaire
        // if ($request->dt_abon){
        //     $dt_abon = \DateTime::createFromFormat('d/m/Y', $request->dt_abon);
        //     $dateAbon = $dt_abon->format('Y-m-d');
        // } else {
        //     $dateAbon = date('Y-m-d');
        // }

        // format date fr en date database
        // version SPA
        // conversion timestamp en date db
        $dateAbon = date('Y-m-d', $request->dt_abon/1000);
        

        // creation dans la base de données
        $createResto = Resto::create([
            'nom' => $request->nom,
            'tel' => $request->tel,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'commentaire' => $request->commentaire,
            'dt_abon' => $dateAbon,
            'user_creat' => Auth::id(),
            'actif' => $request->actif
        ]);

        // redirige vers la liste des restaurants
        //return redirect("restos");
        return response()->json(['message'=>'création restaurant OK'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function show(Resto $resto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function edit(Resto $resto)
    {
        //
        // $resto = Resto::findOrFail($resto_id);

        // return response()->json([
        //     'titre' => $article->titre,
        //     'resume' => $article->resume,
        //     'contenu' => $article->contenu,
        //     'prix' => $article->prix,
        //     'tags' => $article->tags->pluck('id')
        // ]);
            return response()->json([
                'nom' => $resto->nom,
                'tel' => $resto->tel,
                'email' => $resto->email,
                'adresse' => $resto->adresse,
                'commentaire' => $resto->commentaire,
                'dt_abon' => $resto->dt_abon,
                'actif' => $resto->actif == 1 ? true : false
            ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resto $resto)
    {
        //
        $request->validate([
            'nom' => 'required|string|max:255',
            'tel' => 'required|string|max:255'
        ]);

        $dateAbon = date('Y-m-d', $request->dt_abon/1000);

        $resto->update([
            'nom' => $request->nom,
            'tel' => $request->tel,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'commentaire' => $request->commentaire,
            'dt_abon' => $dateAbon,
            'actif' => $request->actif == true ? 1:0
        ]);

        return response()->json( ['message resto' => 'update'] );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resto  $resto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resto $resto)
    {
        //
    }
}
