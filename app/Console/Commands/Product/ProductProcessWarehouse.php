<?php

namespace App\Console\Commands\Product;

use App\Models\Product\Product;
use Illuminate\Console\Command;

class ProductProcessWarehouse extends Command
{
        protected $signature = 'app:product-process-warehouse';

        protected $description = 'Analizar las existencias de los productos para saber si el umbral configurado aun no es igual o menor al stock disponible, en caso fuera asi marcaremos al producto con el estado POR AGOTAR O AGOTADO';

        public function handle()
    {
        $PRODUCTS = Product::where("state",1)->get();
        foreach ($PRODUCTS as $PRODUCT) {
            $por_agotar = 0;
            $agotado = 0;
            foreach ($PRODUCT->warehouses as $warehouse) {
                if($warehouse->stock <= $warehouse->umbral){
                    $por_agotar = 1;
                    $warehouse->update([
                        "state_stock" => 2, //POR AGOTAR
                    ]);
                }
                if($warehouse->stock == 0){
                    $agotado = 1;
                    $warehouse->update([
                        "state_stock" => 3, //AGOTADO
                    ]);
                }
            }
            if($por_agotar == 1){
                $PRODUCT->update([
                    "state_stock" => 2,
                ]);
            }
            if($agotado == 1){
                $PRODUCT->update([
                    "state_stock" => 3,
                ]);
            }
        }
    }
}
