<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_categories';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'delated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id')->published()->latest('created_at');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'category_id')->published()->latest('created_at');
    }

    public function scopeArtikel($query)
    {
        return $query->where('slug', 'not like', '%hubungi-kami%')
            ->where('slug', 'not like', '%faq%');
    }

    public function scopeNotmeta($query)
    {
        return $query->where('slug', 'not like', '%meta%');
    }

    public function scopeMeta($query)
    {
        return $query->where('slug', 'like', '%meta%');
    }

    public function scopeHubungi($query)
    {
        return $query->where('slug', 'like', '%hubungi-kami%');
    }

    public function scopeFaq($query)
    {
        return $query->where('slug', 'like', '%faq%');
    }
}
