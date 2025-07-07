<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
// use Modules\Page\Database\Factories\PageFactory;

class Page extends Model
{
    use HasFactory, HasSlug;    

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',       
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'status', // draft, published, archived
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title')) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * filter by title
     */
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
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // protected static function newFactory(): PageFactory
    // {
    //     // return PageFactory::new();
    // }
}
