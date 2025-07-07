<?php

namespace Modules\Email\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
// use Modules\Email\Database\Factories\EmailFactory;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'subject',
        'description',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($email) {
            if (empty($email->slug)) {
                $email->slug = Str::slug($email->title);
            }
        });

        static::updating(function ($email) {
            if ($email->isDirty('title')) {
                $email->slug = Str::slug($email->title);
            }
        });
    }

    // protected static function newFactory(): EmailFactory
    // {
    //     // return EmailFactory::new();
    // }

    public function scopeFilter($query, $title)
    {
        if ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
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
}
