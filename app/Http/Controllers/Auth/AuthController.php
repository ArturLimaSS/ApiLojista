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
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nome' => 'required|string',
            'cpf' => 'required|string',
            'telefone' => 'required|string',
            'rua' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'cep' => 'required|string',

        ]);
    }
}
