<?php

namespace App\Http\Resources\Conversion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ConversionCollection extends ResourceCollection
{
        public function toArray(Request $request): array
    {
        return [
            "data" => ConversionResource::collection($this->collection),
        ];
    }
}
