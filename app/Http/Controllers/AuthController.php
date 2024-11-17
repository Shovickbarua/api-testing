<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        
        // Validate the request data
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255',
        //     'password' => 'required|string|min:8',
        // ]);
        // dd($validatedData);
        // die();
        // Create a new user instance and save it
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        // $user->sendEmailVerificationNotification();
        event(new Registered($user));

        // Optionally, return a response or redirect
        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user,
        ], 201);
    }


}
