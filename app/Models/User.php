<?php

namespace App\Models;
use App\Models\Config\Sucursale;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
        use HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

        protected $fillable = [
        'name',
        'email',
        'password',
        "surname",
        "avatar",
        "role_id",
        "sucursale_id",
        "phone",
        "type_document",
        "n_document",
        "gender",
        "state",
    ];

        protected $hidden = [
        'password',
        'remember_token',
    ];

        protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    public function getJWTCustomClaims()
    {
        return [];
    }

        public function role()
    {
        return $this->belongsTo(Role::class, "role_id");
    }

        public function sucursale()
    {
        return $this->belongsTo(Sucursale::class, "sucursale_id")->withTrashed();
    }

        public function getFullNameAttribute(): ?string
    {
        $full = trim(($this->name ?? '') . ' ' . ($this->surname ?? ''));
        return $full !== '' ? $full : null;
    }
}
