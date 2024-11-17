<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Faq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_articles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'delated_at', 'published_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'faqs');
        });

        static::creating(function ($article) {
            $article->type = 'faqs';
        });

        static::creating(function ($article) {
            $article->slug = Str::slug($article->title, '-');
        });
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = 'faqs';
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::user()->id;;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
