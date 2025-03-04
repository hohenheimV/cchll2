<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ePIL_dokumen extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    protected $table = 'epil_dokumen_pelan';
    protected $primaryKey = 'id_dokumen_pelan';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    
    // Disable timestamps if not needed in the table
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'nama_fail',
        'keterangan_dokumen_pelan',
        'nama_dokumen_pelan',
        'gambar_dokumen_pelan',
        'id_pelan',
        'status'
    ];

    // Cast attributes to the desired types
    protected $casts = [
        'status' => 'string',
        'id_pelan' => 'string',
    ];
}
