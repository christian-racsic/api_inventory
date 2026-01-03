<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
        public function index(Request $request)
    {
        Gate::authorize('viewAny',Role::class);
        $search = $request->get("search");
        $roles = Role::where("name","ilike","%".$search."%")->orderBy("id","desc")->get();

        return response()->json([
            "roles" => $roles->map(function($role) {
                return [
                    "id" => $role->id,
                    "name" => $role->name,
                    "created_at" => $role->created_at->format("Y/m/d h:i:s"),
                    "permissions" => $role->permissions->map(function($permission) {
                        return [
                            "id" => $permission->id,
                            "name" => $permission->name,
                        ];
                    }),
                    "permissions_pluck" => $role->permissions->pluck("name"),
                ];
            })
        ]);
    }

        public function store(Request $request)
    {
        Gate::authorize('create',Role::class);
        $exist_role = Role::where("name",$request->name)->first();

        if($exist_role){
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DEL ROL YA EXISTE, INTENTE UNO NUEVO"
            ]);
        }

        $role = Role::create([
            "name" => $request->name,
            "guard_name" => "api"
        ]);
        $permissions = $request->permissions;
        foreach ($permissions as $key => $permission) {
            $role->givePermissionTo($permission);
        }
        return response()->json([
            "message" => 200,
            "role" => [
                "id" => $role->id,
                "name" => $role->name,
                "created_at" => $role->created_at->format("Y/m/d h:i:s"),
                "permissions" => $role->permissions->map(function($permission) {
                    return [
                        "id" => $permission->id,
                        "name" => $permission->name,
                    ];
                }),
                "permissions_pluck" => $role->permissions->pluck("name"),
            ],
        ]);
    }

        public function show(string $id)
    {
    }

        public function update(Request $request, string $id)
    {
        Gate::authorize('update',Role::class);
         $exist_role = Role::where("name",$request->name)->where("id","<>",$id)->first();

         if($exist_role){
             return response()->json([
                 "message" => 403,
                 "message_text" => "EL NOMBRE DEL ROL YA EXISTE, INTENTE UNO NUEVO"
             ]);
         }
 
         $role = Role::findOrFail($id);

         $role->update([
            "name" => $request->name
         ]);
         $permissions = $request->permissions;
         $role->syncPermissions($permissions);
         return response()->json([
             "message" => 200,
             "role" => [
                "id" => $role->id,
                "name" => $role->name,
                "created_at" => $role->created_at->format("Y/m/d h:i:s"),
                "permissions" => $role->permissions->map(function($permission) {
                    return [
                        "id" => $permission->id,
                        "name" => $permission->name,
                    ];
                }),
                "permissions_pluck" => $role->permissions->pluck("name"),
            ],
         ]);
    }

        public function destroy(string $id)
    {
        Gate::authorize('delete',Role::class);
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
