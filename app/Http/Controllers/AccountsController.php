<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

use App\Models\User;


class AccountsController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()) {
            return view('pages.cuentas.accounts');
        }
    
        $data = User::where('usugrucod', 'Usuario')->get();
    
        return response()->json(['data' => $data]);
    }
    
    public function impersonate($id){
            
        $user = User::findOrFail($id);

        session()->put('impersonate', Auth::id());
        Auth::login($user);
        return redirect('/home');
    }


    public function stopImpersonate(){

        $originalId = session()->get('impersonate');

        if ($originalId) {

            Auth::logout();
            session()->forget('impersonate');

            $user = User::findOrFail($originalId);
            Auth::login($user);

            return redirect('/accounts');
        }

    }
}
