<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_tags';

    protected $fillable = ['label', 'title', 'meta_description'];


    public function articles()
    {
        return $this->belongsToMany(Article::class, 'web_article_tag', 'tag_id', 'article_id');
    }
}
