<?php

namespace App\Models\Config;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategorie extends Model
{
    use SoftDeletes;

    protected $fillable = ["title","imagen","state"];
    protected $appends = ['imagen_url'];

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

    public function getImagenUrlAttribute(): ?string
    {
        $path = $this->imagen;
        if (!$path) return null;

        $path = ltrim($path, '/');
        $path = preg_replace('#^(storage/|public/)#', '', $path);

        if (Str::startsWith($path, ['http://','https://'])) return $path;
        return Storage::disk('public')->url($path);
    }
}
