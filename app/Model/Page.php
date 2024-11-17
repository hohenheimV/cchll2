<?php

namespace App\Model;



use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model implements Viewable
{
    use InteractsWithViews;
    use SoftDeletes;
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'user_id', 'type', 'slug',
        'page_image', 'features',
        'title', 'subtitle', 'content',
        'meta_description', 'is_status', 'is_features',
        'view_count', 'layout', 'published_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'pages');
        });

        static::creating(function ($page) {
            $page->type = 'pages';
            $page->user_id = Auth::user()->id;
        });

        static::saving(function ($page) {
            if ($page->slug == null){
                $page->slug = Str::slug($page->title, '-');
            }
        });

        // static::creating(function ($page) {
        //     $page->slug = Str::slug($page->title, '-');
        // });
        // static::updating(function ($page) {
        //     $page->slug = Str::slug($page->title, '-');
        // });
    }

    public function visits()
    {
        $expiresAt = now()->addHours(24);
        return views($this)->cooldown($expiresAt)->record();
    }

    public function visited()
    {
        return views($this)->count();
    }

    public function scopePublished($query)
    {
        return $query->where('is_status', 'like', '%publish%');
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = 'pages';
    }

    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['slug'] = Str::slug($value, '-');
    // }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::user()->id;;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setPageImageAttribute($value)
    {
        if ($value) {
            $this->attributes['page_image'] = str_replace('10.28.203.150', '192.168.0.120', $value);
        } else {
            $this->attributes['page_image'] = null;
        }
    }
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = str_replace('10.28.203.150', '192.168.0.120', $value);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function related($id, $category)
    {
        return Page::where('id', '!=', $id)->where('category_id', $category)->inRandomOrder()->limit(4)->get();
    }
}
