<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resto;

class RestoApiController extends Controller
{
    //
    public function restos()
    {
        $restos = Resto::all(['id','nom','actif','dt_abon']);
        return response()->json( $restos );
    }
}
