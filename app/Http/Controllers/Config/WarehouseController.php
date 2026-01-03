<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Models\Config\Sucursale;
use App\Models\Config\Warehouse;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{
        public function index(Request $request)
    {
        $search = trim((string) $request->get("search", ''));
        $query = Warehouse::with(['sucursal'])->orderBy("id", "desc");

        if ($search !== '') {
            $query->where("name", "ilike", "%{$search}%");
        }

        $warehouses = $query->get();
        $sucursales = Sucursale::where("state", 1)->get(['id','name']);

        return response()->json([
            "warehouses" => $warehouses->map(function ($warehouse) {
                return [
                    "id"           => $warehouse->id,
                    "name"         => $warehouse->name,
                    "address"      => $warehouse->address,
                    "sucursale_id" => $warehouse->sucursale_id,
                    "sucursal"     => [
                        "id"   => optional($warehouse->sucursal)->id,
                        "name" => optional($warehouse->sucursal)->name,
                    ],
                    "state"        => (int) $warehouse->state,
                    "created_at"   => optional($warehouse->created_at)?->format("Y/m/d h:i:s"),
                ];
            }),
            "sucursales" => $sucursales->map(fn($s) => [
                "id"   => $s->id,
                "name" => $s->name,
            ]),
        ]);
    }

        public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string',
            'sucursale_id' => 'required|integer|exists:sucursales,id',
            'address'      => 'nullable|string',
            'state'        => 'nullable|integer',
        ]);
        $exist_warehouse = Warehouse::where("name", $request->name)->first();
        if ($exist_warehouse) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DEL ALMACÉN YA EXISTE, INTENTE UNO NUEVO"
            ]);
        }

        $warehouse = Warehouse::create([
            'name'         => $request->name,
            'address'      => $request->address,
            'sucursale_id' => $request->sucursale_id,
            'state'        => $request->input('state', 1),
        ]);
        $warehouse->load(['sucursal']);

        return response()->json([
            "message"   => 200,
            "warehouse" => [
                "id"           => $warehouse->id,
                "name"         => $warehouse->name,
                "address"      => $warehouse->address,
                "state"        => (int) $warehouse->state,
                "sucursale_id" => $warehouse->sucursale_id,
                "sucursal"     => [
                    "id"   => optional($warehouse->sucursal)->id,
                    "name" => optional($warehouse->sucursal)->name,
                ],
                "created_at"   => optional($warehouse->created_at)?->format("Y/m/d h:i:s"),
            ],
        ]);
    }

        public function show(string $id)
    {
        $warehouse = Warehouse::with(['sucursal'])->findOrFail($id);

        return response()->json([
            "warehouse" => [
                "id"           => $warehouse->id,
                "name"         => $warehouse->name,
                "address"      => $warehouse->address,
                "state"        => (int) $warehouse->state,
                "sucursale_id" => $warehouse->sucursale_id,
                "sucursal"     => [
                    "id"   => optional($warehouse->sucursal)->id,
                    "name" => optional($warehouse->sucursal)->name,
                ],
                "created_at"   => optional($warehouse->created_at)?->format("Y/m/d h:i:s"),
            ],
        ]);
    }

        public function update(Request $request, string $id)
    {
        $request->validate([
            'name'         => 'required|string',
            'sucursale_id' => 'required|integer|exists:sucursales,id',
            'address'      => 'nullable|string',
            'state'        => 'nullable|integer',
        ]);
        $exist_warehouse = Warehouse::where("name", $request->name)
            ->where("id", "<>", $id)
            ->first();

        if ($exist_warehouse) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DEL ALMACÉN YA EXISTE, INTENTE UNO NUEVO"
            ]);
        }

        $warehouse = Warehouse::findOrFail($id);

        $warehouse->update([
            'name'         => $request->name,
            'address'      => $request->address,
            'sucursale_id' => $request->sucursale_id,
            'state'        => $request->input('state', $warehouse->state),
        ]);

        $warehouse->load(['sucursal']);

        return response()->json([
            "message"   => 200,
            "warehouse" => [
                "id"           => $warehouse->id,
                "name"         => $warehouse->name,
                "address"      => $warehouse->address,
                "state"        => (int) $warehouse->state,
                "sucursale_id" => $warehouse->sucursale_id,
                "sucursal"     => [
                    "id"   => optional($warehouse->sucursal)->id,
                    "name" => optional($warehouse->sucursal)->name,
                ],
                "created_at"   => optional($warehouse->created_at)?->format("Y/m/d h:i:s"),
            ],
        ]);
    }

        public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return response()->json([
            "message" => 200,
        ]);
    }
}
