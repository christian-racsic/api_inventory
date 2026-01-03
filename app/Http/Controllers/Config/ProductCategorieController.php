<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config\ProductCategorie;
use Illuminate\Support\Facades\Storage;

class ProductCategorieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");

        $categories = ProductCategorie::where("title","ilike","%".$search."%")
            ->orderBy("id","desc")
            ->get();

        return response()->json([
    "categories" => $categories->map(function($categorie) {
        $img = $categorie->imagen_url; // absoluta
        return [
            "id"        => $categorie->id,
            "title"     => $categorie->title,
            "state"     => (int) $categorie->state,
            "image"     => $img,   // alias que a veces usa el front
            "imagen"    => $img,   // compatibilidad
            "created_at"=> $categorie->created_at->format("Y-m-d h:i A"),
        ];
    }),
]);

    }

    public function store(Request $request)
    {
        $is_categorie_exists = ProductCategorie::where("title",$request->title)->first();
        if($is_categorie_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "LA CATEGORIA YA EXISTE"
            ]);
        }

        if($request->hasFile("image")){
            $path = Storage::putFile("categories",$request->file("image")); // guarda en public
            $request->merge(["imagen" => $path]);
        }

        $categorie = ProductCategorie::create($request->all());

        return response()->json([
            "message" => 200,
            "categorie" => [
    "id" => $categorie->id,
    "title" => $categorie->title,
    "state" => (int) $categorie->state,
    "image" => $categorie->imagen_url,
    "imagen" => $categorie->imagen_url,
    "created_at" => $categorie->created_at->format("Y-m-d h:i A"),
],

        ]);
    }

    public function update(Request $request, string $id)
    {
        $is_categorie_exists = ProductCategorie::where("title",$request->title)
            ->where("id","<>",$id)
            ->first();

        if($is_categorie_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "LA CATEGORIA YA EXISTE"
            ]);
        }

        $categorie = ProductCategorie::findOrFail($id);

        if($request->hasFile("image")){
            if($categorie->imagen){
                Storage::delete($categorie->imagen);
            }
            $path = Storage::putFile("categories",$request->file("image"));
            $request->merge(["imagen" => $path]);
        }

        $categorie->update($request->all());

        return response()->json([
            "message" => 200,
            "categorie" => [
    "id" => $categorie->id,
    "title" => $categorie->title,
    "state" => (int) $categorie->state,
    "image" => $categorie->imagen_url,
    "imagen" => $categorie->imagen_url,
    "created_at" => $categorie->created_at->format("Y-m-d h:i A"),
],

        ]);
    }

    public function destroy(string $id)
    {
        $categorie = ProductCategorie::findOrFail($id);
        $categorie->delete();

        return response()->json(["message" => 200]);
    }
}
