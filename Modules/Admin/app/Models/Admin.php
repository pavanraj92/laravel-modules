<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\AdminFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Modules\AdminRolePermission\App\Models\Role;
use Modules\AdminRolePermission\App\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'mobile',
        'website_name',
        'website_slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            if (empty($admin->website_slug)) {
                $admin->website_slug = Str::slug($admin->website_name);
            }
        });

        static::updating(function ($admin) {
            if (empty($admin->website_slug)) {
                $admin->website_slug = Str::slug($admin->website_name);
            }
        });
    }

    public function scopeFilter($query, $name)
    {
        if ($name) {
            return $query->where(function ($q) use ($name) {
                $q->where('first_name', 'like', '%' . $name . '%')
                  ->orWhere('last_name', 'like', '%' . $name . '%');
            });
        }
        return $query;
    }
    /**
     * filter by status
     */
    public function scopeFilterByStatus($query, $status)
    {
        if (!is_null($status)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function getFullNameAttribute()
    {
        $first = trim($this->first_name ?? '');
        $last = trim($this->last_name ?? '');
        return trim("{$first} {$last}");
    }

    public static function getPerPageLimit(): int
    {
        return Config::has('get.admin_page_limit')
            ? Config::get('get.admin_page_limit')
            : 10;
    }

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_admin',      // pivot table name
            'admin_id',        // foreign key on pivot table for this model
            'role_id'          // foreign key on pivot table for Role model
        );
    }
}
