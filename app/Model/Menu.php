<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Menu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_menu';

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
    protected $dates = ['created_at', 'updated_at', 'delated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'title', 'page_id', 'article_id','category_id', 'url', 'target', 'ordering', 'parent_id'];

    public function getLinkAttribute()
    {

        if ($this->type == 'pages' && isset($this->pages->slug)) {
            return url($this->type.'/'.$this->pages->slug);
        } else if ($this->type == 'articles' && isset($this->articles->slug)) {
            return url($this->type.'/'.$this->articles->slug);
        } else if($this->type == 'category' && isset($this->categories->slug)) {
            return url($this->type.'/'.$this->categories->slug);
        } else if($this->type == 'url') {
            return $this->url;
        }else{
            return 'JavaScript:void(0);';
        }
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id')->whereNull('parent_id')->with('parent');
    }
    public function submenu()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('ordering', 'asc');
    }
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('ordering', 'asc');
    }
    // recursive, loads all descendants
    public function grandchildren()
    {
        return $this->children()->with('grandchildren','categories','articles','pages');
    }

    public function pages()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
