<?php

namespace Modules\AdminRolePermission\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Admin;

class Role extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'role_admin');
    }

    public function scopeFilter($query, $keyword)
    {
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }
}
