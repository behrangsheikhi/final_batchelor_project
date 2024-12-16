<?php

namespace App\Traits\Permissions;

use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissionTrait
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }


    // TODO : change public to protected when publishing the project
    public function has_permission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions->where('name', $permission)->count() > 0;
        } elseif ($permission instanceof Permission) {
            return $this->permissions->where('name', $permission->name)->count() > 0;
        }

        return false;
    }


    public function has_permission_to($permission): bool
    {
        return $this->has_permission($permission) || $this->has_permission_through_role($permission);
    }

    public function has_permission_through_role($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role))
                return true;
        }

        return false;
    }


    public function has_role(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    public function has_any_role($roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }



}
