<?php

namespace App\Http\Resources\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransportCollection extends ResourceCollection
{
        public function toArray(Request $request): array
    {
        return [
            "data" => TransportResource::collection($this->collection),
        ];
    }
}
