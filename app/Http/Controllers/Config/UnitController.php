<?php

namespace App\Http\Controllers\Config;

use App\Models\Config\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
        public function index(Request $request)
    {
        $search = $request->get("search");
        $units = Unit::where("name","ilike","%".$search."%")->orderBy("id","desc")->get();

        return response()->json([
            "units" => $units->map(function($unit) {
                return [
                    "id" => $unit->id,
                    "name" => $unit->name,
                    "description" => $unit->description,
                    "state" => $unit->state,
                    "created_at" => $unit->created_at->format("Y/m/d h:i:s"),
                ];
            })
        ]);
    }

        public function store(Request $request)
    {
        $exist_unit = Unit::where("name",$request->name)->first();

        if($exist_unit){
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DE LA UNIDAD YA EXISTE, INTENTE UNO NUEVO"
            ]);
        }
        $unit = Unit::create($request->all());
        
        return response()->json([
            "message" => 200,
            "unit" => [
                "id" => $unit->id,
                "name" => $unit->name,
                "description" => $unit->description,
                "state" => $unit->state,
                "created_at" => $unit->created_at->format("Y/m/d h:i:s"),
            ],
        ]);
    }

        public function show(string $id)
    {
    }

        public function update(Request $request, string $id)
    {
        $exist_unit = Unit::where("name",$request->name)->where("id","<>",$id)->first();

        if($exist_unit){
            return response()->json([
                "message" => 403,
                "message_text" => "EL NOMBRE DE LA UNIDAD YA EXISTE, INTENTE UNO NUEVO"
            ]);
        }
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        
        return response()->json([
            "message" => 200,
            "unit" => [
                "id" => $unit->id,
                "name" => $unit->name,
                "description" => $unit->description,
                "state" => $unit->state,
                "created_at" => $unit->created_at->format("Y/m/d h:i:s"),
            ],
        ]);
    }

        public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json([
            "message" => 200 
        ]);
    }
}
