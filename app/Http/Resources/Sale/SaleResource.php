<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
        public function toArray(Request $request): array
    {
        $sale = $this->resource;

        return [
            "id"       => $sale->id,

            "user_id"  => $sale->user_id,
            "user"     => [
                "full_name" => trim((optional($sale->user)->name ?? '') . ' ' . (optional($sale->user)->surname ?? '')) ?: null,
            ],

            "client_id" => $sale->client_id,
            "client"    => [
                "id"         => optional($sale->client)->id,
                "full_name"  => optional($sale->client)->full_name,
                "n_document" => optional($sale->client)->n_document,
            ],

            "type_client"  => $sale->type_client,

            "sucursale_id" => $sale->sucursale_id,
            "sucursale"    => [
                "name" => optional($sale->sucursale)->name,
            ],

            "subtotal"  => $sale->subtotal,
            "discount"  => $sale->discount,
            "total"     => $sale->total,
            "igv"       => $sale->igv,

            "state_sale"    => $sale->state_sale,
            "state_payment" => $sale->state_payment,
            "state_entrega" => $sale->state_entrega,

            "debt"          => $sale->debt,
            "paid_out"      => $sale->paid_out,
            "date_validation"   => $sale->date_validation,
            "date_pay_complete" => $sale->date_pay_complete,

            "description"   => $sale->description,
            "created_at"         => optional($sale->created_at)?->format("Y-m-d h:i A"),
            "created_at_format"  => optional($sale->created_at)?->format("Y-m-d"),

            "sale_details" => $sale->sale_details
                ? $sale->sale_details->map(fn ($detail) => SaleDetailResource::make($detail))
                : [],

            "payments" => $sale->payments
                ? $sale->payments->map(function ($p) {
                    return [
                        "id"             => $p->id,
                        "method_payment" => $p->method_payment,
                        "banco"          => $p->banco,
                        "amount"         => $p->amount,
                        "n_transaction"  => $p->n_transaction,
                    ];
                })->values()
                : [],
        ];
    }
}
