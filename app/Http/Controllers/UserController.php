<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    //

    public function store(Request $request)
    {
      /*  $token = $request->header('Authorization');
        
        $user = DB::table('users')
                    ->where('token', $token)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $expiryTime = Carbon::parse($user->expiry_time);

        if ($expiryTime->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }*/
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'role'  => 'required',
           ]);
           
           $expiryTime = Carbon::now()->addMinutes(30);
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'token' => Str::random(60),
            'expiry_time' => $expiryTime,
           
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Generate new token
            $newToken = Str::random(60);
            $expiryTime = Carbon::now()->addMinutes(30);

            // Update user's token in database
            $user->expiry_time=$expiryTime;
            $user->token = $newToken;
            $user->save();
            $role = $user->role;

            return response()->json([
                'message' => 'Successfully logged in.',
                'token' => $newToken,
                'role' => $role,
                'expiry_time' => Carbon::now()->addMinutes(210),
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials.',
        ], 401);
    }

}
