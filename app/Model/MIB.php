<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MIB extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    // The name of the table associated with the model
    protected $table = 'maklumat_rakan_taman'; 

    // The primary key for the model
    protected $primaryKey = 'id';

    // The attributes that are mass assignable
    protected $fillable = [
        'ref_num',
        'no_siri',
        'name',
        'email',
        'negeri',
        'pbt',
        'taman',
        'kawasan',
        'fail',
        'penduduk',
        'jawatankuasa',
        'alamat',
        'approved_by',
        'approved_at',
        'status',
        'catatan_jln',
        'peruntukan',
        'status_keahlian',
    ];

    // The attributes that should be mutated to dates
    protected $dates = [
        'approved_at',
        'deleted_at',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'kawasan' => 'array',
        'fail' => 'array',
        'jawatankuasa' => 'array',
    ];

    // The default values for the model's attributes
    protected $attributes = [
        'status' => 'Diperakui',
    ];
}
