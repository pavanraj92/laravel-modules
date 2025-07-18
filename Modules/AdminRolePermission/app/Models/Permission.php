<?php

namespace Modules\AdminRolePermission\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;

class Permission extends Model
{
    use Sortable;
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    protected $sortable = [
        'name',
        'slug',
        'status',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            if (empty($permission->slug)) {
                $permission->slug = Str::slug($permission->name, '_');
            }
        });

        static::updating(function ($permission) {
            // Always regenerate the slug if name has changed
            if ($permission->isDirty('name')) {
                $permission->slug = Str::slug($permission->name, '_');
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function admins()
    {
        return $this->roles()
            ->with('admins')
            ->get()
            ->pluck('admins')
            ->flatten()
            ->unique('id');
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
