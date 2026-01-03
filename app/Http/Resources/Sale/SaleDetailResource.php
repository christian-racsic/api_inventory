<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
{
        public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "product_id" => $this->resource->product_id,
            "product" => [
                "id" => $this->resource->product->id,
                "title" => $this->resource->product->title,
                "sku" => $this->resource->product->sku,
                "warehouses" => $this->resource->product->warehouses->map(function($warehouse) {
                    return [
                        "id" => $warehouse->id,
                        "warehouse_id" => $warehouse->warehouse_id,
                        "warehouse" => [
                            "name" => $warehouse->warehouse->name,
                        ],
                        "unit_id" => $warehouse->unit_id,
                        "unit" => [
                            "name" => $warehouse->unit->name,
                        ],
                        "stock" => $warehouse->stock,
                        "umbral" => $warehouse->umbral,
                        "state_stock" => $warehouse->state_stock,
                    ];
                }),
                "wallets" => $this->resource->product->wallets->map(function($wallet) {
                    return [
                        "id" => $wallet->id,
                        "type_client" => $wallet->type_client,
                        "type_client_name" => $wallet->type_client == 1 ? 'Cliente Final' : 'Cliente Empresa',
                        "sucursale_id" => $wallet->sucursale_id,
                        "sucursale" => $wallet->sucursale ? [
                            "name" => $wallet->sucursale->name,
                        ] : NULL,
                        "unit_id" => $wallet->unit_id,
                        "unit" => [
                            "name" => $wallet->unit->name,
                        ],
                        "price" => $wallet->price,
                    ];
                }),
                "tax_selected" => $this->resource->product->tax_selected,
                "importe_iva" => $this->resource->product->importe_iva,
                "price_general" => $this->resource->product->price_general,
                "price_company" => $this->resource->product->price_company,
                "is_discount" => $this->resource->product->is_discount,
                "max_discount" => $this->resource->product->max_discount,
                "disponibilidad" => $this->resource->product->disponibilidad,
                "is_gift" => $this->resource->product->is_gift,
                "imagen" => $this->resource->product->product_imagen,
            ],
            "product_categorie_id" => $this->resource->product_categorie_id,
            "product_categorie" => [
                "title" => $this->resource->product_categorie->title,
            ],
            "unit_id" => $this->resource->unit_id,
            "unit" => [
                "id" => $this->resource->unit->id,
                "name" => $this->resource->unit->name,
            ],
            "warehouse_id" => $this->resource->warehouse_id,
            "warehouse" => [
                "id" => $this->resource->warehouse->id,
                "name" => $this->resource->warehouse->name,
            ],
            "quantity" => $this->resource->quantity,
            "price" => $this->resource->price_unit,
            "discount" => $this->resource->discount,
            "subtotal" => $this->resource->subtotal,
            "igv" => $this->resource->igv,
            "total" => $this->resource->total,
            "description" => $this->resource->description,
            "state_attention" => $this->resource->state_attention ?? 1,
            "quantity_pending" => $this->resource->quantity_pending,
        ];
    }
}
