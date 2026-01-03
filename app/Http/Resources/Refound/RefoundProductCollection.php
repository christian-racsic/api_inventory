<?php

namespace App\Http\Resources\Refound;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RefoundProductCollection extends ResourceCollection
{
        public function toArray(Request $request): array
    {
        return [
            "data" => RefoundProductResource::collection($this->collection),
        ];
    }
}
