<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Rubrique;
use App\Models\Tag;

class ShopController extends Controller
{
    //
    public function shopData($resto_id){

        // get rubriques & articles
        $rubriques = Rubrique::where('resto_id', $resto_id)->orderBy('ordre')->with('articles')->get();

        // envoyer le json
        return response()->json( [
            'shop' => $rubriques
        ] );

    }
}
