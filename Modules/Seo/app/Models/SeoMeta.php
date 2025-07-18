<?php

namespace Modules\Seo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;
use Kyslik\ColumnSortable\Sortable;

class SeoMeta extends Model
{
    use HasFactory, Sortable;

    /**
     * The table associated with the model.
     */
    protected $table = 'seo_meta';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'model_name',
        'model_record_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * The attributes that should be sortable.
     */
    public $sortable = [
        'model_name',
        'meta_title',
        'created_at',
    ];

    /**
     * Filter by model name
     */
    public function scopeFilter($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('meta_title', 'like', '%' . $keyword . '%')
                  ->orWhere('model_name', 'like', '%' . $keyword . '%');
            });
        }
        return $query;
    }

    /**
     * Filter by model name
     */
    public function scopeFilterByModel($query, $modelName)
    {
        if ($modelName) {
            return $query->where('model_name', $modelName);
        }
        return $query;
    }

    /**
     * Get available model options
     */
    public static function getModelOptions()
    {
        return [
            'Page' => 'Page',
            'Post' => 'Post',
            'Category' => 'Category',
            'Banner' => 'Banner',
            'Faq' => 'FAQ',
        ];
    }

    /**
     * Get per page limit
     */
    public static function getPerPageLimit(): int
    {
        return Config::has('get.admin_page_limit')
            ? Config::get('get.admin_page_limit')
            : 10;
    }
    
}
