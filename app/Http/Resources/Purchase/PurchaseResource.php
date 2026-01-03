<?php

namespace App\Http\Resources\Purchase;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
        public function toArray(Request $request): array
    {
        $p = $this->resource;

        return [
            "id" => $p->id,

            "warehouse_id" => $p->warehouse_id,
            "warehouse" => [
                "name" => optional($p->warehouse)->name,
            ],

            "user_id" => $p->user_id,
            "user" => [
                "full_name" => trim((optional($p->user)->name ?? '') . ' ' . (optional($p->user)->surname ?? '')) ?: null,
            ],

            "sucursale_id" => $p->sucursale_id,
            "sucursale" => [
                "name" => optional($p->sucursale)->name,
            ],

            "date_emision" => $p->date_emision ? Carbon::parse($p->date_emision)->format("Y-m-d") : null,

            "state" => $p->state,
            "type_comprobant" => $p->type_comprobant,
            "n_comprobant" => $p->n_comprobant,

            "provider_id" => $p->provider_id,
            "provider" => [
                "full_name" => optional($p->provider)->full_name,
            ],

            "total" => $p->total,
            "importe" => $p->importe,
            "igv" => $p->igv,
            "description" => $p->description,

            "created_at" => optional($p->created_at)?->format("Y-m-d h:i A"),
            "details" => $this->whenLoaded('purchase_details', function () use ($p) {
                return $p->purchase_details->map(function ($d) {
                    return [
                        "id" => $d->id,

                        "product_id" => $d->product_id,
                        "product" => [
                            "title" => optional($d->product)->title,
                            "sku"   => optional($d->product)->sku,
                        ],

                        "unit_id" => $d->unit_id,
                        "unit" => [
                            "name" => optional($d->unit)->name,
                        ],

                        "price_unit" => $d->price_unit,
                        "total"      => $d->total,
                        "quantity"   => $d->quantity,
                        "state"      => $d->state,

                        "user_entrega" => $d->user_entrega ? [
                            "id"        => optional($d->user)->id,
                            "full_name" => trim((optional($d->user)->name ?? '') . ' ' . (optional($d->user)->surname ?? '')) ?: null,
                        ] : null,

                        "date_entrega" => $d->date_entrega
                            ? Carbon::parse($d->date_entrega)->format("Y-m-d")
                            : null,

                        "description" => $d->description,
                    ];
                })->values();
            }, []),
        ];
    }
}
