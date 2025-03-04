<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ePIL extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    protected $table = 'epil_maklumat_pelan';
    protected $primaryKey = 'id_pelan';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    
    // Disable timestamps if not needed in the table
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'nama_pelan',
        'nama_pbt',
        'alamat1_pelan',
        'alamat2_pelan',
        'alamat3_pelan',
        'poskod_pelan',
        'negeri_pelan',
        'daerah_pelan',
        'mukim_pelan',
        'parlimen_pelan',
        'dun_pelan',
        'mediaSosial_pelan',
        'gambar_dokumen_pelan',
        'id_permohonan',
        'status'
    ];

    // Cast attributes to the desired types
    protected $casts = [
        'status' => 'string',
        'id_permohonan' => 'string',
    ];
}
