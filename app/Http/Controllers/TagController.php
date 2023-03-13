<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    // liste des tags disponibles
    public function index()
    {
        //
        $tags = Tag::select('id','titre','contenu')->get();
        return response()->json( ['tags' => $tags] );
    }

}
