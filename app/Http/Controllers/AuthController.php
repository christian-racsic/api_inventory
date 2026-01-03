<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
        public function register()
    {
        Gate::authorize('create', User::class);

        $validator = Validator::make(request()->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User();
        $user->name     = request()->name;
        $user->email    = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json($user, 201);
    }

        public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message'       => 401,
                'message_text'  => 'Credenciales inválidas',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

        public function me()
    {
        $user = auth('api')->user();

        if (! $user) {
            return response()->json([
                'message' => 401,
                'message_text' => 'No autenticado',
            ], 401);
        }

        return response()->json([
            'message' => 200,
            'user'    => $this->userPayload($user),
        ], 200);
    }

        public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

        public function refresh()
    {
        try {
            $newToken = auth('api')->refresh();
            return $this->respondWithToken($newToken);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 401,
                'message_text' => 'Token inválido o expirado',
            ], 401);
        }
    }

        protected function respondWithToken($token)
    {
        $user = auth('api')->user();

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
            'user'         => $this->userPayload($user),
        ], 200);
    }

        protected function userPayload($user): array
    {
        $sucursaleName = optional($user->sucursale)->name;
        $roleId        = optional($user->role)->id;
        $roleName      = optional($user->role)->name;
        $permissions = $user->getAllPermissions()->pluck('name');

        return [
            'id'           => $user->id,
            'full_name'    => trim(($user->name ?? '').' '.($user->surname ?? '')),
            'name'         => $user->name,
            'surname'      => $user->surname,
            'email'        => $user->email,
            'avatar'       => $user->avatar ? env('APP_URL').'storage/'.$user->avatar : null,
            'sucursale_id' => $user->sucursale_id,
            'sucursale'    => ['name' => $sucursaleName],
            'role'         => ['id' => $roleId, 'name' => $roleName],
            'permissions'  => $permissions,
        ];
    }
}
