<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVerify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        //$credentials = $request->only('email', 'password');
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt([ 
            'email' => $email,
            'password' => $password,
            'actif' => 'oui'
            ])
            ) {
            // return redirect()->intended('/')
            //             ->withSuccess('Signed in');
            $user = Auth::user();
            $token = $user->createToken(time())->plainTextToken;


            return response()->json([
                'prenom'=> $user->prenom,
                'nom'=> $user->nom,
                'role'=> $user->role,
                'token'=> $token,
            ]);
        }
  
        //return redirect("login")->withSuccess('Login details are not valid');
        return response()->json(["message","Authentication Required"], 422);
    }

    public function registration()
    {
        return view('auth.registration');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        // if(Auth::check()){
        //     return view('dashboard');
        // }
  
        // return redirect('login')->withSuccess('You are not allowed to access');

        return view('index');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function verifyAccount($token) 
    {
        return view('auth.createpass');
    }

    public function createPass(Request $request, $token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Désolé, impossible de valider le mail.';

        if (!$is_null->is_email_verified){
            $verifyUser->user->is_email_verified = 1;
            $verifyUser->user->save();
            $message = "Votre email est vérifié. Vous pouvez vous connecter.";

            DB::table('users')->where('id', $token)
                ->update(['password' => Hash::make( $request->password )]);

        }

        return view('users.created')->with('message','You are not allowed to access');
    }
}