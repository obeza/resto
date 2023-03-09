<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{
    //
    public function users()
    {
        $users = User::all(['id','nom','prenom','email','role']);
        return response()->json( $users );
    }
}
