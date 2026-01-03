<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleCollection extends ResourceCollection
{
        public function toArray(Request $request): array
    {
        return [
            "data" => SaleResource::collection($this->collection),
        ];
    }
}
