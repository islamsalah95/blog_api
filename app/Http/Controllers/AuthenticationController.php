<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Mail\VerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->code = Str::random(6, 'alnum');
        $user->save();
        Mail::to($user)->send(new VerificationCode($user->code));

        $tokens = $user->createToken('Android')->plainTextToken;
        $user->token = 'Bearer ' . $tokens;

        return ResponseTrait::success($user);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $tokens = $user->createToken('Android')->plainTextToken;
        $user->token = 'Bearer ' . $tokens;

        return ResponseTrait::success($user);
    }


    public function verify(Request $request)
    {
    
         $user =  auth('sanctum')->user();
    
        if (!$user) {
            return ResponseTrait::error('Invalid token');
        }
    
        if ($user->code !== $request->code) {
            return ResponseTrait::error('Incorrect code');
        }

        $user->code = null;
        $user->save();
        
        
        return ResponseTrait::success($user, 'Correct code');
    }
}