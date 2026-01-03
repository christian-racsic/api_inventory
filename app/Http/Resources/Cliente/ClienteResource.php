<?php

namespace App\Http\Resources\Cliente;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
        public function toArray(Request $request): array
    {
        $c = $this->resource;
        $birth = null;
        if (!empty($c->birth_date)) {
            try {
                $birth = Carbon::parse($c->birth_date)->format('Y-m-d');
            } catch (\Throwable $e) {
                $birth = null;
            }
        }

        return [
            "id"            => $c->id,
            "name"          => $c->name,
            "surname"       => $c->surname,
            "full_name"     => $c->full_name,
            "phone"         => $c->phone,
            "email"         => $c->email,
            "type_client"   => $c->type_client,
            "type_document" => $c->type_document,
            "n_document"    => $c->n_document,
            "birth_date"    => $birth,

            "user_id"       => $c->user_id,
            "user"          => [
                "full_name" => trim((optional($c->user)->name ?? '') . ' ' . (optional($c->user)->surname ?? '')) ?: null,
            ],

            "sucursale_id"  => $c->sucursale_id,
            "sucursale"     => [
                "name" => optional($c->sucursale)->name,
            ],

            "state"         => $c->state,
            "gender"        => $c->gender,
            "ubigeo_region"    => $c->ubigeo_region,
            "ubigeo_provincia" => $c->ubigeo_provincia,
            "ubigeo_distrito"  => $c->ubigeo_distrito,
            "region"        => $c->region,
            "provincia"     => $c->provincia,
            "distrito"      => $c->distrito,
            "address"       => $c->address,

            "created_at"    => optional($c->created_at)?->format("Y-m-d h:i A"),
        ];
    }
}
