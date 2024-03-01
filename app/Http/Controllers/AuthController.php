<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;



use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        $fecha = Carbon::now();
        $userGoogle = Socialite::driver('google')->user();
        // dd($userGoogle);
        $user = User::updateOrCreate([
            'google_id' => $userGoogle->id,
        ], [
            'name' => $userGoogle->name,
            'email' => $userGoogle->email,
            'email_verifed_at' => $fecha,
            'google_id' => $userGoogle->id,
            'google_token' => $userGoogle->token,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
