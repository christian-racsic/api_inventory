<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Config\Sucursale;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
        public function index(Request $request)
    {
        Gate::authorize("viewAny", User::class);

        $search = $request->get("search");

        $query = User::query()
            ->with(['role', 'sucursale']); // evitar N+1
        if ($search && strlen(trim($search)) > 0) {
            $query->where(
                DB::raw("users.name || ' ' || COALESCE(users.surname,'') || ' ' || users.email || ' ' || COALESCE(users.phone,'')"),
                "ilike",
                "%{$search}%"
            );
        }

        $users = $query
            ->orderBy("id", "desc")
            ->get();

        return response()->json([
            "users" => $users->map(function ($user) {
                return [
                    "id"          => $user->id,
                    "name"        => $user->name,
                    "surname"     => $user->surname,
                    "full_name"   => $user->full_name, // accesor del modelo
                    "email"       => $user->email,
                    "role_id"     => (int) $user->role_id,
                    "role"        => [
                        "name" => optional($user->role)->name,
                    ],
                    "phone"       => $user->phone,
                    "state"       => $user->state,
                    "sucursale_id"=> (int) $user->sucursale_id,
                    "sucursale"   => [
                        "name" => optional($user->sucursale)->name,
                    ],
                    "avatar"      => $user->avatar ? url(Storage::url($user->avatar)) : null,
                    "type_document"=> $user->type_document,
                    "n_document"  => $user->n_document,
                    "gender"      => $user->gender,
                    "created_at"  => optional($user->created_at)?->format("Y-m-d h:i A"),
                ];
            }),
        ]);
    }

    public function config()
    {
        $sucursales = Sucursale::select('id','name')->get();
        $roles      = Role::select('id','name')->get();

        return response()->json([
            "sucursales" => $sucursales->map(function ($sucursal) {
                return [
                    "id"   => $sucursal->id,
                    "name" => $sucursal->name,
                ];
            }),
            "roles" => $roles->map(function ($rol) {
                return [
                    "id"   => $rol->id,
                    "name" => $rol->name,
                ];
            }),
        ]);
    }

        public function store(Request $request)
    {
        Gate::authorize("create", User::class);
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email',
            'role_id'   => 'required|integer|exists:roles,id',
            'password'  => 'nullable|string|min:6',
            'imagen'    => 'nullable|file|image|max:4096',
        ]);

        $is_user_exists = User::where("email", $request->email)->first();
        if ($is_user_exists) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO YA EXISTE"
            ]);
        }

        if ($request->hasFile("imagen")) {
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if ($request->password) {
            $request->request->add(["password" => bcrypt($request->password)]);
        }
        $user = User::create($request->all());
        $role = Role::findOrFail($request->role_id);
        $user->assignRole($role);

        return response()->json([
            "message" => 200,
            "user" => [
                "id"          => $user->id,
                "name"        => $user->name,
                "surname"     => $user->surname,
                "full_name"   => $user->full_name,
                "email"       => $user->email,
                "role_id"     => (int) $user->role_id,
                "state"       => $user->state,
                "role"        => [
                    "name" => optional($user->role)->name,
                ],
                "phone"       => $user->phone,
                "sucursale_id"=> (int) $user->sucursale_id,
                "sucursale"   => [
                    "name" => optional($user->sucursale)->name,
                ],
                "avatar"      => $user->avatar ? url(Storage::url($user->avatar)) : null,
                "type_document"=> $user->type_document,
                "n_document"  => $user->n_document,
                "gender"      => $user->gender,
                "created_at"  => optional($user->created_at)?->format("Y-m-d h:i A"),
            ],
        ]);
    }

        public function update(Request $request, string $id)
    {
        Gate::authorize("update", User::class);

        $request->validate([
            'email'     => 'required|email',
            'role_id'   => 'nullable|integer|exists:roles,id',
            'password'  => 'nullable|string|min:6',
            'imagen'    => 'nullable|file|image|max:4096',
        ]);

        $is_user_exists = User::where("email", $request->email)
            ->where("id", "<>", $id)
            ->first();
        if ($is_user_exists) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO YA EXISTE"
            ]);
        }

        $user = User::findOrFail($id);
        $oldRoleId = $user->role_id;

        if ($request->hasFile("imagen")) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if ($request->password) {
            $request->request->add(["password" => bcrypt($request->password)]);
        }
        $user->update($request->all());
        if ($request->filled('role_id') && (int)$request->role_id !== (int)$oldRoleId) {
            if (!is_null($oldRoleId)) {
                $role_old = Role::find($oldRoleId);
                if ($role_old) {
                    $user->removeRole($role_old);
                }
            }
            $role_new = Role::findOrFail($request->role_id);
            $user->assignRole($role_new);
        }

        return response()->json([
            "message" => 200,
            "user" => [
                "id"          => $user->id,
                "name"        => $user->name,
                "surname"     => $user->surname,
                "full_name"   => $user->full_name,
                "email"       => $user->email,
                "role_id"     => (int) $user->role_id,
                "role"        => [
                    "name" => optional($user->role)->name,
                ],
                "phone"       => $user->phone,
                "state"       => $user->state,
                "sucursale_id"=> (int) $user->sucursale_id,
                "sucursale"   => [
                    "name" => optional($user->sucursale)->name,
                ],
                "avatar"      => $user->avatar ? url(Storage::url($user->avatar)) : null,
                "type_document"=> $user->type_document,
                "n_document"  => $user->n_document,
                "gender"      => $user->gender,
                "created_at"  => optional($user->created_at)?->format("Y-m-d h:i A"),
            ],
        ]);
    }

        public function destroy(string $id)
    {
        Gate::authorize("delete", User::class);

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            "message" => 200
        ]);
    }
}
