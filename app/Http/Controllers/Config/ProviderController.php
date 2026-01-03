<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Models\Config\Provider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
        public function index(Request $request)
    {
        $search = $request->get("search");

        $providers = Provider::where(DB::raw("providers.full_name || '' || providers.ruc || '' || providers.phone || '' || COALESCE(providers.email,'')"),"ilike","%".$search."%")->orderBy("id","desc")->get();

        return response()->json([
  'providers' => $providers->map(function ($prov) {
      return [
          'id'         => $prov->id,
          'full_name'  => $prov->full_name,
          'ruc'        => $prov->ruc,
          'email'      => $prov->email,
          'phone'      => $prov->phone,
          'address'    => $prov->address,
          'state'      => $prov->state,
          'imagen'     => $prov->imagen_url,
          'created_at' => $prov->created_at->format('Y-m-d h:i A'),
      ];
  }),
]);

    }

        public function store(Request $request)
    {
        $is_provider_exists = Provider::where("ruc",$request->ruc)->first();
        if($is_provider_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "EL PROVEDOR YA EXISTE, INTENTE UN RUC DIFERENTE"
            ]);
        }

        if($request->hasFile("image")){
            $path = Storage::putFile("providers",$request->file("image"));
            $request->request->add(["imagen" => $path]);
        }
        $provider = Provider::create($request->all());

        return response()->json([
            "message" => 200,
            "provider" => [
                "id" => $provider->id,
                "full_name" => $provider->full_name,
                "ruc" => $provider->ruc,
                "email" => $provider->email,
                "phone" => $provider->phone,
                "address" => $provider->address,
                "state" => (int) $provider->state,
                "imagen" => $provider->imagen ? env("APP_URL")."storage/".$provider->imagen : NULL,
                "created_at" => $provider->created_at->format("Y-m-d h:i A"),
            ],
        ]);
    }

        public function show(string $id)
    {
    }

        public function update(Request $request, string $id)
    {
        $is_provider_exists = Provider::where("ruc",$request->ruc)->where("id","<>",$id)->first();
        if($is_provider_exists){
            return response()->json([
                "message" => 403,
                "message_text" => "EL PROVEDOR YA EXISTE, INTENTE UN RUC DIFERENTE"
            ]);
        }
        $provider = Provider::findOrFail($id);
        if($request->hasFile("image")){
            if($provider->imagen){
                Storage::delete($provider->imagen);
            }
            $path = Storage::putFile("providers",$request->file("image"));
            $request->request->add(["imagen" => $path]);
        }
        $provider->update($request->all());

        return response()->json([
            "message" => 200,
            "provider" => [
                "id" => $provider->id,
                "full_name" => $provider->full_name,
                "ruc" => $provider->ruc,
                "email" => $provider->email,
                "phone" => $provider->phone,
                "address" => $provider->address,
                "state" => (int) $provider->state,
                "imagen" => $provider->imagen ? env("APP_URL")."storage/".$provider->imagen : NULL,
                "created_at" => $provider->created_at->format("Y-m-d h:i A"),
            ],
        ]);
    }

        public function destroy(string $id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
