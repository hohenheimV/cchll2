<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MIB_laporan extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    // The name of the table associated with the model
    protected $table = 'maklumat_aktiviti_rakan_taman';

    // The primary key for the model
    protected $primaryKey = 'id';

    // The attributes that are mass assignable
    protected $fillable = [
        'id_rakan',
        'name',
        'taman',
        'laporan',
        'fail',
        'gambar',
    ];

    // The attributes that should be mutated to dates
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'fail' => 'array',
        'gambar' => 'array',
    ];

    public function mib()
    {
        return $this->belongsTo(MIB::class, 'id_rakan', 'id');
    }
}
