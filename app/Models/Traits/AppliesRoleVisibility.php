<?php

namespace App\Models\Traits;

trait AppliesRoleVisibility
{
        public function scopeApplyRoleVisibility($query, $user, $sucursaleField = 'sucursale_id', $userField = 'user_id')
    {
        if (!$user) return $query;

        if ($user->hasAnyRole(['Super-Admin','Admin'])) {
            return $query;
        }

        if ($user->hasRole('ManagerSucursal') && $sucursaleField && \Schema::hasColumn($this->getTable(), $sucursaleField)) {
            if (!is_null($user->sucursale_id)) {
                return $query->where($sucursaleField, $user->sucursale_id);
            }
            return $query;
        }

        if ($userField && \Schema::hasColumn($this->getTable(), $userField)) {
            return $query->where($userField, $user->id);
        }

        return $query;
    }
}
