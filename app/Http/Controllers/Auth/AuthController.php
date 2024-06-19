<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado'
            ], 404);
        } else if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Senha incorreta'
            ], 404);
        }

        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
            'message' => 'Usuário logado com sucesso!'
        ], 200);
    }

    public function Logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'message' => 'Usuário deslogado com sucesso!'
        ], 200);
    }

    public function Register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'document' => ['required', 'string', 'max:255'],
            'fantasy_name' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'representative_name' => ['required', 'string']
        ]);

        try {
            $user = new User($request->all());
            $user->password =  Hash::make($request->password);
            $user->save();
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
