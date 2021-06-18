<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiTokenController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
            ->first();

        if($user && $user->id ) {
            if(Hash::check($request->password, $user->password)) {
                return $this->update($user);
            }
        }

        return response(['message' => 'Login fail'], 404)
            ->header('Content-Type', 'text/plain');
    }

    private function update(User $user)
    {
        $token = Str::random(60);

        $user->api_token = hash('sha256', $token);
        $user->update();

        return ['token' => $token];
    }
}
