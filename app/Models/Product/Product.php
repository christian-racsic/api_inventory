<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Config\ProductCategorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "title",
        "sku",
        "imagen",
        "product_categorie_id",
        "price_general",
        "price_company",
        "description",
        "is_discount",
        "max_discount",
        "is_gift",
        "disponibilidad",
        "state",
        "state_stock",
        "warranty_day",
        "tax_selected",
        "importe_iva",
    ];
    protected $appends = ['product_imagen', 'image_url'];

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set('America/Lima');
        $this->attributes["created_at"]= Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();
    }

    public function product_categorie() {
        return $this->belongsTo(ProductCategorie::class,"product_categorie_id");
    }
    public function warehouses() {
        return $this->hasMany(ProductWarehouse::class);
    }
    public function wallets() {
        return $this->hasMany(ProductWallet::class);
    }

        public function getProductImagenAttribute(): ?string
    {
        $path = $this->attributes['imagen'] ?? null;
        if (!$path) return null;

        $path = ltrim($path, '/');
        $path = preg_replace('#^(storage/|public/)#', '', $path);
        if (Str::startsWith($path, ['http://','https://'])) {
            return $path;
        }
        return Storage::disk('public')->url($path);
    }

        public function getImageUrlAttribute(): ?string
    {
        return $this->getProductImagenAttribute();
    }

    public function scopeFilterAdvance($query,$search,$categorie_id,$warehouse_id,$unit_id,$sucursale_id,$disponibilidad,$is_gift){
        if($search){
            $query->where(DB::raw("products.title || '' || products.sku"),"ilike","%".$search."%");
        }
        if($categorie_id){
            $query->where("product_categorie_id",$categorie_id);
        }
        if($disponibilidad){
            $query->where("disponibilidad",$disponibilidad);
        }
        if($is_gift){
            $query->where("is_gift",$is_gift);
        }
        if($warehouse_id){
            $query->whereHas("warehouses",function($warehouse) use($warehouse_id){
                $warehouse->where("warehouse_id",$warehouse_id);
            });
        }
        if($unit_id){
            $query->whereHas("warehouses",function($warehouse) use($unit_id){
                $warehouse->where("unit_id",$unit_id);
            });
        }
        if($sucursale_id){
            $query->whereHas("wallets",function($wallet) use($sucursale_id){
                $wallet->where("sucursale_id",$sucursale_id);
            });
        }
        return $query;
    }
}
