<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Conversion;
use App\Http\Controllers\Controller;
use App\Models\Product\ProductWarehouse;
use App\Http\Resources\Conversion\ConversionResource;
use App\Http\Resources\Conversion\ConversionCollection;

class ConversionController extends Controller
{
        public function index(Request $request)
    {
        $search_product = $request->search_product;
        $warehouse_id = $request->warehouse_id;
        $unit_start_id = $request->unit_start_id;
        $unit_end_id = $request->unit_end_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $conversion_id = $request->conversion_id;
        
        $conversions = Conversion::filterAdvance($search_product,$warehouse_id,$unit_start_id,$unit_end_id,$start_date,$end_date,$conversion_id)
                                        ->orderBy("id","desc")->paginate(25);

        return response()->json([
            "total_page" => $conversions->lastPage(),
            "conversions" => ConversionCollection::make($conversions),
        ]);
    }

        public function store(Request $request)
    {

        $product_warehouse = ProductWarehouse::where("product_id",$request->product_id)
                                                ->where("unit_id",$request->unit_start_id)
                                                ->where("warehouse_id",$request->warehouse_id)
                                                ->first();

        if($product_warehouse->stock < (int) $request->quantity_start){
            return response()->json([
                "message" => 403,
                "message_text" => "No puedes registrar la conversión, porque no se cuenta con el stock disponible"
            ]);
        }
        $product_warehouse->update([
            "stock" => $product_warehouse->stock - (int) $request->quantity_start,
        ]);

        $product_warehouse = ProductWarehouse::where("product_id",$request->product_id)
                                                ->where("unit_id",$request->unit_end_id)
                                                ->where("warehouse_id",$request->warehouse_id)
                                                ->first();

        if(!$product_warehouse){
            ProductWarehouse::create([
                "product_id" => $request->product_id,
                "warehouse_id" => $request->warehouse_id,
                "unit_id" => $request->unit_end_id,
                "stock" => $request->quantity_end,
            ]);
        }else{
            $product_warehouse->update([
                "stock" => $product_warehouse->stock + $request->quantity_end, 
            ]);
        }
        $conversion = Conversion::create([
            "product_id" => $request->product_id,
            "warehouse_id" => $request->warehouse_id,
            "unit_start_id" => $request->unit_start_id,
            "unit_end_id" => $request->unit_end_id,
            "user_id" => auth('api')->user()->id,
            "quantity_start" => $request->quantity_start,
            "quantity_end"  => $request->quantity_end,
            "description"  => $request->description,
        ]);

        return response()->json([
            "message" => 200,
            "conversion" => ConversionResource::make($conversion),
        ]);
    }

        public function show(string $id)
    {
    }

        public function update(Request $request, string $id)
    {
    }

        public function destroy(string $id)
    {
        $conversion = Conversion::findOrFail($id);
        $product_warehouse = ProductWarehouse::where("product_id",$conversion->product_id)
                                                ->where("unit_id",$conversion->unit_end_id)
                                                ->where("warehouse_id",$conversion->warehouse_id)
                                                ->first();
        if($product_warehouse->stock < $conversion->quantity_end){
            return response()->json([
                "message" => 403,
                "message_text" => "No puedes eliminar esta conversión porque ya no se cuenta con el stock disponible para devolver"
            ]);
        }

        $product_warehouse->update([
            "stock" => $product_warehouse->stock -  $conversion->quantity_end,
        ]);

        $product_warehouse = ProductWarehouse::where("product_id",$conversion->product_id)
                                                ->where("unit_id",$conversion->unit_start_id)
                                                ->where("warehouse_id",$conversion->warehouse_id)
                                                ->first();
        $product_warehouse->update([
            "stock" => $product_warehouse->stock + $conversion->quantity_start,
        ]);

        $conversion->delete();

        return response()->json([
            "message" => 200
        ]);
    }
}
