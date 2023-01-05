<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check email
        $user = User::where('email', $fields['email'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return[
            'message' => 'Logged out'
        ];
    }

    public function update(Request $request)
    {

//        if($user->id !== auth()->id()) {
//            return response([
//                'message' => 'Bad creds'
//            ], 401);
//        }

        $validatedData = $request->validate([
            'first_name' => [
                'required',
                'max:16',
                Rule::unique('users')->ignore(auth()->id())],
            'last_name' => [
                'required',
                'max:16',
                Rule::unique('users')->ignore(auth()->id())],
            'email' => [
                'required',
                'email',
                'max:40',
                Rule::unique('users')->ignore(auth()->id())],
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validatedData['password']) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        //update user
        auth()->user()->update($validatedData);

        return auth()->user();
    }

}
