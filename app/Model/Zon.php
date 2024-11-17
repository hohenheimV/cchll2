<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Zon extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_zon';

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
    protected $fillable = [
        'tajuk',
        'tarikh',
        'lokasi'
    ];

    public function getSizeNameAttribute()
    {
        return number_format($this->size / 1048576, 2);
    }
    //https://www.itsolutionstuff.com/post/php-laravel-file-upload-with-progress-bar-exampleexample.html

    public function getZonesAttribute()
    {
        if ($this->lokasi) {
            $zones = config('zonaktiviti.zon');
            $lokasi = explode('_', $this->lokasi);
            return $zones[$lokasi[0]][$lokasi[1]][$lokasi[2]];
        }
        return null;
    }
}

