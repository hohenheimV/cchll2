<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Manual extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_manual';

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
        'keterangan',
        'dokumen',
        'mimes',
        'size',
        'extension',
        'tarikh'
    ];

    public function getSizeNameAttribute()
    {
        return number_format($this->size / 1048576, 2);
    }

    //https://www.itsolutionstuff.com/post/php-laravel-file-upload-with-progress-bar-exampleexample.html
}
