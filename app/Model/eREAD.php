<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Kategori;

class eREAD extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
 
    protected $table = 'web_eread';

   
    protected $primaryKey = 'id';

   
    protected $dates = ['created_at', 'updated_at', 'delated_at'];

  
    protected $fillable = [
        'tajuk',
        'keterangan',
        'dokumen',
        'mimes',
        'size',
        'extension',
        'tarikh',
        'kate'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kate', 'id');
    }

    public function getSizeNameAttribute()
    {
        return number_format($this->size / 1048576, 2);
    }

    //https://www.itsolutionstuff.com/post/php-laravel-file-upload-with-progress-bar-exampleexample.html
}
