<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Slider extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_sliders';

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
    protected $fillable = ['slider_image','title','subtitle','url','target','is_active','popup'];

    public function scopeActive($query)
    {
        return $query->where('is_active',1);
    }

    public function setSliderImageAttribute($value)
    {
        if($value){
            $this->attributes['slider_image'] = str_replace('10.28.203.150','192.168.0.120',$value);
        }else{
            $this->attributes['slider_image'] = null;
        }
    }
}
