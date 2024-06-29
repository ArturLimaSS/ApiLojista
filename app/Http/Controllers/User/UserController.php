<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UsersProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function read()
    {
        $users = User::where("is_active", '1')->get();
        return response()->json([
            'users' => $users
        ]);
    }
    public function register(Request $request)
    {
        try {
            $userData = [
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "fantasy_name" => $request->fantasy_name,
                "document" => $request->document,
                "phone" => $request->phone,
                "type" => $request->type,
                "name" => $request->name,
                "is_admin" => $request->is_admin
            ];

            $user = User::create($userData);
            $log_message = "**Novo Usuário Cadastrado!**
                **Nome**: " . $request->name . "
                **Email**: " . $request->email . "
                **CPF/CNPJ**: " . $request->document . "
                **Mensagem de Boas-Vindas**: Olá, " . $request->name . ", seja bem-vindo(a) ao Gestec! 
                Meu nome é [Seu Nome] e estou aqui para ajudar você no que precisar sobre o Gestec.
                Aqui você encontrará informações, poderá esclarecer dúvidas, sugerir melhorias e contar com todo o suporte necessário para o seu sucesso com o Gestec.
                Estou à disposição para ajudar!";

            // Log::channel('discord_new_user')->info($log_message);
            return response()->json([
                "message" => "Usuário criado com sucesso!",
                "token" => $user->createToken("AuthToken")->plainTextToken
            ]);
        } catch (\Exception $e) {
            // Log::channel('discord_new_user')->error("Ocorreu um erro ao criar usuário! Log: " . $e->getMessage());
            return response()->json(['message' => 'Falha ao criar usuário.', "error" => $e->getMessage()], 500);
        }
    }
    public function get(Request $request)
    {
        $userLogged = auth()->user();
        $user = DB::table('users')
            ->leftJoin('tb_user_address', 'users.id', '=', 'tb_user_address.user_id')
            ->select('users.*', 'tb_user_address.*')
            ->where('users.id', $userLogged->id)->first();

        if (isset($user[0])) {
            return response()->json([
                "message" => "Usuário encontrado com sucesso!",
                "user" => $user
            ], 200);
        } else {
            return response()->json([
                "message" => "Usuário não encontrado!"
            ]);
        }
    }
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::find($request->id);

                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->name = $request->name;
                $user->fantasy_name = $request->fantasy_name;
                $user->document = $request->document;
                $user->save();

                // $userAddress = new UserAddress();
                // $userAddress->userId = $request->id;
                // $userAddress->street = $request->street;
                // $userAddress->number = $request->number;
                // $userAddress->complement = $request->complement;
                // $userAddress->neighborhood = $request->neighborhood;
                // $userAddress->city = $request->city;
                // $userAddress->state = $request->state;
                // $userAddress->postal_code = $request->postal_code;
                // $userAddress->save();

                return response()->json(["message" => "Usuário atualizado com sucesso!"]);
            });
        } catch (\Exception $e) {
            Log::channel('discord_new_user')->error("Ocorreu um erro ao atualizar usuário! Log: " . $e->getMessage());
            return response()->json(['message' => 'Falha ao atualizar usuário.', "error" => $e->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        User::where('id', $request->id)->update(['is_active' => '0']);
        return response()->json(['message' => 'Usuário deletado com sucesso!']);
    }

    public function updateImage(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();

                $userId = auth()->user()->id;
                $userName = auth()->user()->name;

                $fileName = "profile_image_{$userId}_" . str_replace(' ', '_', $userName) . '.' . $extension;

                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $user = User::where('id', $userId)->first();
                $user->profile_image_path = "storage/" . $filePath; // Atualiza o caminho da imagem de perfil
                $user->save(); // Salva as alterações no banco de dados

                return response()->json([
                    'message' => 'Arquivo enviado com sucesso!',
                    'path' => $filePath
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao enviar o arquivo.', "error" => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Erro ao fazer upload da imagem.'], 422);
    }
}
