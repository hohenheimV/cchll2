<?php
namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Home extends Model implements Viewable
{
    use InteractsWithViews;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_counter';

    public function visits()
    {
        $expiresAt = now()->addHours(24);
        return views($this)->cooldown($expiresAt)->record();
    }

    public function visited(){
        return views($this)->count();
    }
}
