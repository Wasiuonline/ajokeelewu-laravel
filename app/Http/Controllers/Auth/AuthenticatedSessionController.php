<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\General;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request, General $general)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if($general::DetToken($request->header("mine"))){
        $data = auth()->user();
        $token = $data->createToken($request->email);
        $data['token'] = $token->plainTextToken;
        return response()->json($data, 200);
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request, General $general)
    {
        if($general->DetUser($request->header("mine"), $request->id)){
        $tokenId = explode("|", $request->header("token"));
        $tokenId = $tokenId[0];
        $user = User::where('id', $request->id)->first();
        $user->tokens()->where('id', $tokenId)->delete();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $logout = ["logout" => $tokenId];
        return response()->json($logout, 200);
        }

    }
}
