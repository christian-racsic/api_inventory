<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Client\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Cliente\ClienteResource;
use App\Http\Resources\Cliente\ClienteCollection;

class ClientController extends Controller
{
        public function index(Request $request)
    {
        Gate::authorize("viewAny", Client::class);

        $search = $request->get("search");
        $user   = auth('api')->user();

        $query = Client::query();
        if ($search && strlen(trim($search)) > 0) {
            $query->where(
                DB::raw("clients.full_name || '' || clients.n_document || '' || clients.phone || '' || COALESCE(clients.email,'')"),
                "ilike",
                "%{$search}%"
            );
        }
        $query->where(function ($q) use ($user) {
            if (!$user->hasAnyRole(['Super-Admin', 'Admin'])) {
                if ($user->hasRole('ManagerSucursal')) {
                    if (!is_null($user->sucursale_id)) {
                        $q->where('sucursale_id', $user->sucursale_id);
                    }
                } else {
                    $q->where('user_id', $user->id);
                }
            }
        });

        $clients = $query
            ->with(['user','sucursale']) 
            ->orderBy("id", "desc")
            ->paginate(15);

        return response()->json([
            "total_page" => $clients->lastPage(),
            "clients"    => ClienteCollection::make($clients),
        ]);
    }

        public function store(Request $request)
    {
        Gate::authorize("create", Client::class);

        $exits_client_full_name = Client::where("full_name", $request->full_name)->first();
        if ($exits_client_full_name) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CLIENTE YA EXISTE. CAMBIAR EL NOMBRE"
            ]);
        }

        $exits_client_n_document = Client::where("n_document", $request->n_document)->first();
        if ($exits_client_n_document) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CLIENTE YA EXISTE. CAMBIAR EL N° DE DOCUMENTO"
            ]);
        }

        $request->request->add(["user_id" => auth('api')->user()->id]);
        $request->request->add(["sucursale_id" => auth('api')->user()->sucursale_id]);

        $client = Client::create($request->all());

        return response()->json([
            "message" => 200,
            "client"  => ClienteResource::make($client),
        ]);
    }

        public function show(string $id)
    {
        Gate::authorize("view", Client::class);

        $client = Client::findOrFail($id);

        return response()->json([
            "client" => ClienteResource::make($client),
        ]);
    }

        public function update(Request $request, string $id)
    {
        Gate::authorize("update", Client::class);

        $exits_client_full_name = Client::where("full_name", $request->full_name)
            ->where("id", "<>", $id)
            ->first();
        if ($exits_client_full_name) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CLIENTE YA EXISTE. CAMBIAR EL NOMBRE"
            ]);
        }

        $exits_client_n_document = Client::where("n_document", $request->n_document)
            ->where("id", "<>", $id)
            ->first();
        if ($exits_client_n_document) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL CLIENTE YA EXISTE. CAMBIAR EL N° DE DOCUMENTO"
            ]);
        }

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return response()->json([
            "message" => 200,
            "client"  => ClienteResource::make($client),
        ]);
    }

        public function destroy(string $id)
    {
        Gate::authorize("delete", Client::class);

        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json([
            "message" => 200,
        ]);
    }
}
